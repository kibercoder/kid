<?php

namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Settle;

class CityController extends \yii\web\Controller
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
    
    public function actionIndex()
    {
        return $this->redirect(['site/index']);
    }
    
    public function actionSettle(){
        $request = Yii::$app->request;
        $name = $request->get('name');
        if(!$name){
            throw new yii\web\HttpException(400 ,'Параметр name не найден');
        } 
        $settle = new Settle();
        $settle->user_id = \Yii::$app->user->identity->id;
        $settle->name = $name;
        if($settle->save()){
            return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
        }else{
            throw new yii\web\ServerErrorHttpException($settle->getError()); 
        }
    }

    public function actionFilmstudio()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }   
        $producer = Settle::findOne([
            'user_id' => \Yii::$app->user->identity->id,
            'name' => 'producer',
        ]);

        $this->view->params['producer'] = ($producer) ? false : true;    
        $this->layout = 'city/filmstudio';
        return $this->render('filmstudio');
    }

    public function actionRedaction()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }   
        $journalist = Settle::findOne([
            'user_id' => \Yii::$app->user->identity->id,
            'name' => 'journalist',
        ]);

        $this->view->params['journalist'] = ($journalist) ? false : true;    
        $this->layout = 'city/redaction';
        return $this->render('redaction');
    } 

    public function actionStylist()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }   
        $stylist = Settle::findOne([
            'user_id' => \Yii::$app->user->identity->id,
            'name' => 'stylist',
        ]);

        $this->view->params['stylist'] = ($stylist) ? false : true;    
        $this->layout = 'city/stylist';
        return $this->render('stylist');
    }  
    
    public function actionWhitehouse()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }   
        $whitehouse = Settle::findOne([
            'user_id' => \Yii::$app->user->identity->id,
            'name' => 'whitehouse',
        ]);

        $this->view->params['whitehouse'] = ($whitehouse) ? false : true;    
        $this->layout = 'city/whitehouse';
        return $this->render('whitehouse');
    }     
    
    public function actionShop()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }   
    
        $this->layout = 'city/common';
        return $this->render('shop');
    } 
    
    public function actionAcademy()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }   
    
        $this->layout = 'city/common';
        return $this->render('academy');
    }   
}
