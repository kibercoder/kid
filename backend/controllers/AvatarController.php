<?php

namespace backend\controllers;

use Yii;
use common\models\Avatar;
use common\models\AvatarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;
use common\helpers\CheckUploadFile;

/**
 * AvatarController implements the CRUD actions for Avatar model.
 */
class AvatarController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can('admin')) {
                throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * Lists all Avatar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AvatarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Avatar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Avatar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Avatar();

        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post()['Avatar'];

            $countAvatarSql = Avatar::find('id_avatar')->orderBy(['id_avatar' => SORT_DESC])->one();

            (int)$countAvatarSql->id_avatar++;


            $uploadFile = new CheckUploadFile();

            $model->avatar_name = UploadedFile::getInstance($model, 'avatar_name');

            $avatar = $uploadFile->checkImage(
                Yii::$app->params['max_filesize_img'], 
                Yii::$app->params['fullPathAvatar'].'site/',
                205,
                205,
                $model->avatar_name,
                ['jpg','jpeg','gif','png'],
                $countAvatarSql->id_avatar
            );


            if ($avatar['success']) {

                $model->avatar_name = $avatar['namefile'];

                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id_avatar]);
                }

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Avatar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $path = Yii::$app->params['fullPathAvatar'].'site/'.$model->avatar_name;

        $old_avatar_name = $model->avatar_name;

        if ($model->load(Yii::$app->request->post())) {

            $post = Yii::$app->request->post()['Avatar'];

            $model->avatar_name = UploadedFile::getInstance($model, 'avatar_name');

            if (preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $model->avatar_name->name)) {

                if (file_exists($path)){
                    unlink ($path);
                }


                $uploadFile = new CheckUploadFile();

                $avatar = $uploadFile->checkImage(
                    Yii::$app->params['max_filesize_img'], 
                    Yii::$app->params['fullPathAvatar'].'site/',
                    205,
                    205,
                    $model->avatar_name,
                    ['jpg','jpeg','gif','png'],
                    $id
                );

                if ($avatar['success']) {

                    $model->avatar_name = $avatar['namefile'];

                    if ($model->save(false)) {

                        return $this->redirect([
                                'view', 
                                'id' => $model->id_avatar
                        ]);

                    }

                }

            } else {

                $model->avatar_name = $old_avatar_name;

                if ($model->save(false)) {

                    return $this->redirect([
                            'view', 
                            'id' => $model->id_avatar
                    ]);

                }

            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Avatar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $path = Yii::$app->params['fullPathAvatar'].'site/'.$model->avatar_name;

        if (file_exists($path)){
            unlink ($path);
        }

        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Avatar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Avatar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avatar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
