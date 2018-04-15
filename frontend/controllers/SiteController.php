<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use common\models\Avatar;
use common\models\UserAvatar;
use common\models\UserComment;
use yii\web\UploadedFile;
use common\helpers\CheckUploadFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        //Разрешено для всех
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],

            'eauth' => [
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => ['login'],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "index";
        return $this->render('index');
    }



    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //return Yii::$app->response->redirect(['/signup']);


        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    $identity = User::findByEAuth($eauth);

                    //print_r($identity);
                    //die;
                    //ПЕРЕНАПРАВЛЯЕМ ПОЛЬЗОВАТЕЛЯ ОПЯТЬ НА signup 
                    //и передаём данные чтобы user не вводил их
                    //имя, фамилия. возраст и город
                    $eauth->redirect(['/signup', 
                        'first_name' => $identity->first_name,
                        'last_name' => $identity->last_name,
                        'birthdate' => $identity->birthdate,
                        'city' => $identity->city
                    ]);

                    Yii::$app->getUser()->login($identity);

                    // special redirect with closing popup window
                    $eauth->redirect();
                }
                else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }
            }
            catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
//              $eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }

        // default authorization code through login/password 


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        $this->layout = "signup";

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            //print_r ($model->getErrors());
            //var_dump($model->getErrors());
            //echo $model->signup();
            //die;

            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        $model_avatar = new Avatar();

        $men_avatars =  $model_avatar::find()
                        ->where(['gender' => 'm'])
                        ->select(['*'])->asArray()->all();

        $women_avatars =  $model_avatar::find()
                        ->where(['gender' => 'w'])
                        ->select(['*'])->asArray()->all();


        return $this->render('signup', [
            'model' => $model,
            'men_avatars' => $men_avatars,
            'women_avatars' => $women_avatars,
            'id_avatar_val' => $men_avatars[0]['id_avatar'],
            'id_avatar_src' => $men_avatars[0]['avatar_name'],
        ]);
    }

    public function actionHandler() 
    {

        //echo json_encode($_FILES);
        //print_r ($_FILES['SignupForm']);
        //die;

        if(isset($_FILES['SignupForm'])){

            $uploadFile = new CheckUploadFile();

            $avatar = pathinfo($_FILES['SignupForm']['name']['avatar']);
            $avatar['tempFile'] = $_FILES['SignupForm']['tmp_name']['avatar'];
            $avatar['size'] = $_FILES['SignupForm']['size']['avatar'];

            $avatar = $uploadFile->checkImage(
                Yii::$app->params['max_filesize_img'], 
                Yii::$app->basePath.'/web/avatars/tmp/',
                205,
                205,
                $avatar,
                ['jpg','jpeg','gif','png'],
                'avatartmp'
            );


            if (isset($avatar['namefile'])) {
                $avatar['namefile'] = '/avatars/tmp/'.$avatar['namefile'];
            }

            //print_r($avatar);

            echo json_encode($avatar);

        }

        exit;

    }



    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }



}
