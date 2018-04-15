<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ProfileForm;
use common\models\User;
use common\models\Avatar;
use common\models\UserAvatar;
use common\models\UserComment;
use common\models\Gift;
use common\models\UserGift;
use frontend\models\Friend;
use common\models\UserMessage;

use yii\web\UploadedFile;
use common\helpers\CheckUploadFile;

/**
 * Site controller
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionIndex($id = null)
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        if(\Yii::$app->user->identity->id == $id){
            return $this->redirect(['user/']);
        }

        //выбираем пользователя который у нас авторизован
        //К нему также будут привязаны комментарии
        $user = User::find()->where([
                'id' => ($id) ? $id : \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;
        $this->view->params['owner'] = (!$id) ? true : false ;
        $this->view->params['gifts'] = Gift::find()->all();

        if($id){
            //User::checkUserOnline($id);
            $userOnline = $user->online;
            $this->view->params['userGifts'] = null;
            $checkAlreadyFriend = Friend::find()->where([
                'from_user_id' => \Yii::$app->user->identity->id
            ])->one();           
            
        }else{
            $userOnline = null;
            $this->view->params['userGifts'] = UserGift::find()->where([
                'to_user_id' => \Yii::$app->user->identity->id
            ])->all(); 
            $checkAlreadyFriend = null;    
        }

        $this->layout = "profile";
        return $this->render('index', [
            'user' => $user,
            'userOnline' => $userOnline,
            'checkAlreadyFriend' => $checkAlreadyFriend,
        ]);

    }

     /**
     * Displays Обновление профиля
     *
     * @return mixed
     */
    public function actionEditProfile()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $profile  = new ProfileForm();

        if($profile->load(Yii::$app->request->post(), 'ProfileForm')){
           
            $postUser = Yii::$app->request->post('ProfileForm');

            if($profile->saveProfile($postUser)){
                //Yii::$app->session->setFlash('success','You have updated your profile.');
            }

        }

        //выбираем пользователя который у нас авторизован
        $user = User::findOne(\Yii::$app->user->identity->id);

        $userAvatar = UserAvatar::findOne(['id_u' => \Yii::$app->user->identity->id]);
        $user_avatar = ($userAvatar) ? $userAvatar->id_a : null;

        $model_avatar = new Avatar();

        $men_avatars =  $model_avatar::find()
                        ->where(['gender' => 'm'])
                        ->select(['*'])->asArray()->all();
        $women_avatars =  $model_avatar::find()
                        ->where(['gender' => 'w'])
                        ->select(['*'])->asArray()->all();  
                              
        $this->view->params['user'] = $user;
        $this->layout = "user";
      
        return $this->render('update', [
            'model' => $user,
            'profile' => $profile,
            'men_avatars' => $men_avatars,
            'women_avatars' => $women_avatars,
            'user_avatar' => $user_avatar,
        ]);

    }


    /**
     * Change likes of comments
     *
     * @return mixed
     */
    public function actionChange_like()
    {

        if (is_numeric($_POST['commentid']) && is_numeric($_POST['userid'])){

            $commentid = (int)$_POST['commentid'];
            $userid = (int)$_POST['userid'];

            if ($_POST['action'] == 'more') {

                $params = [':id_u' => $userid, ':id_c' => $commentid];

                $command = Yii::$app->db->createCommand('SELECT id_c, id_u FROM userComment WHERE id_u=:id_u AND id_c=:id_c')
                           ->bindValues($params)
                           ->queryOne();

                if (!is_numeric($command['id_u'])) {
                    $sql = "UPDATE comment SET count_like = count_like + '1' WHERE id = '$commentid'";

                    $sql2 = "INSERT INTO userComment SET id_c = '$commentid', id_u = '$userid'";

                    if (Yii::$app->db->createCommand($sql)->execute()
                        && Yii::$app->db->createCommand($sql2)->execute()) {
                        echo 'true';
                    }
                }

            } else if ($_POST['action'] == 'less') {

                $command = Yii::$app->db->createCommand('SELECT count_like FROM comment WHERE id=:id');

                $count_like = $command->bindValue(':id', $commentid)->queryOne();

                if ((int)$count_like['count_like'] >=1) {
                    $sql = "UPDATE comment SET count_like = count_like - '1' WHERE id = '$commentid'";
                } else {
                    $sql = "UPDATE comment SET count_like = '1' WHERE id = '$commentid'";
                }

                $deleteAll = UserComment::deleteAll(
                            'id_u=:id_u AND id_c=:id_c', 
                            [':id_u' => $userid, ':id_c' => $commentid]
                );

                if (Yii::$app->db->createCommand($sql)->execute() && $deleteAll) {
                    echo 'true';
                }
            }

        }
    
    }

    public function actionHandler() 
    {

        //echo json_encode($_FILES);
        //print_r ($_FILES['SignupForm']['size']['avatar']);
        //die;

        if(isset($_FILES['ProfileForm'])){

            $uploadFile = new CheckUploadFile();

            $avatar = pathinfo($_FILES['ProfileForm']['name']['avatar']);
            $avatar['tempFile'] = $_FILES['ProfileForm']['tmp_name']['avatar'];
            $avatar['size'] = $_FILES['ProfileForm']['size']['avatar'];

            $avatar = $uploadFile->checkImage(
                Yii::$app->params['max_filesize_img'], 
                Yii::$app->basePath.'/web/avatars/tmp/',
                205,
                205,
                $avatar,
                ['jpg','jpeg','gif','png'],
                'avatartmp'
            );

            if ($avatar['namefile']) {
                $avatar['namefile'] = '/avatars/tmp/'.$avatar['namefile'];
            }

            //print_r($avatar);

            echo json_encode($avatar);

        }
        exit;
    }

    /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionNews()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;


        $this->layout = "user";
        return $this->render('news', [
            'user' => $user,
        ]);

    }   

     /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionDialogs()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;

        /*$sql = "SELECT  t1.*, u.username, u.first_name, u.last_name, u.party FROM userMessage as t1 
        LEFT JOIN user as u ON ((u.id = t1.to_user_id AND t1.FROM_user_id = :user_id) OR (u.id = t1.FROM_user_id AND t1.to_user_id = :user_id)) 
        WHERE t1.created IN (select max(t2.created) FROM userMessage as t2 WHERE t2.to_user_id = :user_id OR t2.FROM_user_id = :user_id GROUP BY t2.to_user_id, t2.FROM_user_id) 
        AND t1.to_user_id IN (select t2.to_user_id FROM userMessage as t2 WHERE t2.to_user_id = :user_id OR t2.FROM_user_id = :user_id GROUP BY t2.to_user_id, t2.FROM_user_id) 
        AND t1.FROM_user_id IN (select t2.FROM_user_id FROM userMessage as t2 WHERE t2.to_user_id = :user_id OR t2.FROM_user_id = :user_id GROUP BY t2.to_user_id, t2.FROM_user_id)  
        GROUP BY t1.id , u.username ORDER BY t1.created DESC";

        $dialogList = Yii::$app->db->createCommand($sql)->bindValue(':user_id',\Yii::$app->user->identity->id)->queryAll(\PDO::FETCH_OBJ);
        
        if(count($dialogList)){
            $newDialogList = [];
            foreach ($dialogList as $d => $dialog) {
                if(!array_key_exists( $dialog->username , $dialogList)){
                    $newDialogList[$dialog->username] = $dialog;
                }
            }
            $dialogList = $newDialogList;
        }*/

        $sql = "select to_user_id, from_user_id, max(created) as created from userMessage WHERE to_user_id = :user_id OR FROM_user_id = :user_id group by to_user_id, from_user_id ORDER BY created DESC";

        $dialogList = Yii::$app->db->createCommand($sql)->bindValue(':user_id',\Yii::$app->user->identity->id)->queryAll(\PDO::FETCH_OBJ);

        if(count($dialogList)){
            $newDialogList = [];
            foreach ($dialogList as $d => $dialog) {
                $newDialogList[] = UserMessage::find()->where([
                    'to_user_id' => $dialog->to_user_id,
                    'from_user_id' => $dialog->from_user_id,
                    'created' => $dialog->created,
                ])->one();              
            }
            $dialogList = $newDialogList;
        }

        $this->layout = "user";
        return $this->render('dialogs', [
            'user' => $user,
            'dialogList' => $dialogList
        ]);

    } 

      /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionDialog($id)
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;

        $where = "show_to = 1 AND show_from = 1 AND ((to_user_id = ".$user->id." AND from_user_id = '".$id."') OR  (to_user_id = '".$id."' AND from_user_id = ".$user->id."))";
        $messages = UserMessage::find()->where($where)->orderBy([
            'created' => SORT_ASC,
        ])->all();
      
        $this->layout = "user";
        return $this->render('dialog', [
            'user' => $user,
            'messages' => $messages,
            'id' => $id
        ]);

    }   

      /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionWorks()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;


        $this->layout = "user";
        return $this->render('works', [
            'user' => $user,
        ]);

    } 

      /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionFinance()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;


        $this->layout = "user";
        return $this->render('finance', [
            'user' => $user,
        ]);

    } 

     /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionFriends()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();
        
        $outgoingCount = Friend::find()->where([
            'from_user_id' => \Yii::$app->user->identity->id,
            'accept' => 0
        ])->count();
        $incomingCount = Friend::find()->where([
            'to_user_id' => \Yii::$app->user->identity->id,
            'accept' => 0
        ])->count();
    
        $friends = Friend::find()->where('accept = 1 AND (to_user_id = '.\Yii::$app->user->identity->id.' OR from_user_id= '.\Yii::$app->user->identity->id.')')->all();     

        $this->view->params['user'] = $user;

        $this->layout = "user";
        return $this->render('friends', [
            'user' => $user,
            'incomingCount' => $incomingCount,
            'outgoingCount' => $outgoingCount,
            'friends' => $friends
        ]);

    }  

      /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionFriendsApps()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();
        
        $outgoing = Friend::find()->where([
            'from_user_id' => \Yii::$app->user->identity->id,
            'accept' => 0
        ])->all();
        $incoming = Friend::find()->where([
            'to_user_id' => \Yii::$app->user->identity->id,
            'accept' => 0
        ])->all();

        $this->view->params['user'] = $user;

        $this->layout = "user";
        return $this->render('friends_apps', [
            'user' => $user,
            'incoming' => $incoming,
            'outgoing' => $outgoing,
        ]);

    }    

       /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionSafe()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;


        $this->layout = "user";
        return $this->render('safe', [
            'user' => $user,
        ]);

    } 
    
      /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionMission()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;


        $this->layout = "user";
        return $this->render('mission', [
            'user' => $user,
        ]);

    } 
    
      /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionPayment()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;


        $this->layout = "city/common";
        return $this->render('payment', [
            'user' => $user,
        ]);

    }

         /**
     * Displays Личный кабинет
     *
     * @return mixed
     */
    public function actionTickets()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        //выбираем пользователя который у нас авторизован
        $user = User::find()->where([
                'id' => \Yii::$app->user->identity->id
        ])->one();

        $this->view->params['user'] = $user;


        $this->layout = "user";
        return $this->render('tickets', [
            'user' => $user,
        ]);

    } 


    /**
     * Finds the Avatar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Avatar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
