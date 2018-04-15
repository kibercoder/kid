<?php

namespace backend\controllers;

use Yii;
use common\models\TournamentQuestion;
use common\models\TournamentQuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Tournament;
use common\models\QuestionAnswerString;
use common\models\QuestionAnswerPhoto;
use common\models\QuestionAnswerMap;
use common\models\TournamentLinkQuestion;

use common\models\Map;


/**
 * TournamentQuestionController implements the CRUD actions for TournamentQuestion model.
 */
class TournamentQuestionController extends Controller
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

    /**
     * Lists all TournamentQuestion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TournamentQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/tournament/question/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TournamentQuestion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/tournament/question/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TournamentQuestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new TournamentQuestion();
        $modelAnswerString = new QuestionAnswerString();
        $modelAnswerPhoto = new QuestionAnswerPhoto();
        $modelAnswerMap = new QuestionAnswerMap();
        $modelMap = new Map();
        $tournament = new Tournament();

        $countryMap = Map::find()
                        ->select(['country as value', 'country as  label','id_map as id'])
                        ->asArray()
                        ->all();

        $tournaments = $tournament::find()
                        ->select(['id_t', 'title'])
                        ->asArray()
                        ->all();

        if ($model->load(Yii::$app->request->post())) {

            $result = false;

            $tournamentQuestion = Yii::$app->request->post()['TournamentQuestion'];

            switch ($tournamentQuestion['type']) {
              case 1:
                $id = $model->saveQuestionAnswerString($model);
              break;

              case 2:
                $id = $model->saveQuestionAnswerPhoto($model);
              break;

              case 3:
                $id = $model->saveQuestionAnswerMap($model);
              break;

              default;

            }

            if (is_numeric($id)) {
                return $this->redirect(['view', 'id' => $id]);
            }

        }

        return $this->render('/tournament/question/create', [
            'model' => $model,
            'modelAnswerString' => $modelAnswerString,
            'modelAnswerPhoto' => $modelAnswerPhoto,
            'modelAnswerMap' => $modelAnswerMap,
            'modelMap' => $modelMap,
            'countryMap' => $countryMap,
            'tournament' => $tournament,
            'tournaments' => $tournaments
        ]);
    }

    /**
     * Updates an existing TournamentQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelAnswerString = ($model->type == 1) 
                ? QuestionAnswerString::findOne(['id' => $id]) 
                : new QuestionAnswerString();

        $modelAnswerPhoto = ($model->type == 2) 
                ? QuestionAnswerPhoto::findOne(['id' => $id])
                : new QuestionAnswerPhoto();

        $modelAnswerMap = ($model->type == 3) 
                ? QuestionAnswerMap::findOne(['id' => $id])
                : new QuestionAnswerMap();

        $modelMap = ($model->type == 3 && is_numeric($modelAnswerMap->id_map)) 
                    ? Map::findOne(['id_map' => $modelAnswerMap->id_map])
                    : new Map();

        $countryMap = Map::find()
                        ->select(['country as value', 'country as  label','id_map as id'])
                        ->asArray()
                        ->all();

        $tournaments = Tournament::find()
                        ->select(['id_t', 'title'])
                        ->asArray()
                        ->all();


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $result = false;

            $tournamentQuestion = @Yii::$app->request->post()['TournamentQuestion'];

            switch ($tournamentQuestion['type']) {
              case 1:

                $id = $model->UpdateQuestionAnswerString(
                        $model, 
                        $modelAnswerString,
                        $modelAnswerPhoto,
                        $modelAnswerMap
                    );

              break;

              case 2:
                $id = $model->UpdateQuestionAnswerPhoto(
                        $model, 
                        $modelAnswerString,
                        $modelAnswerPhoto,
                        $modelAnswerMap
                    );
              break;

              case 3:
                $id = $model->UpdateQuestionAnswerMap(
                        $model, 
                        $modelAnswerString,
                        $modelAnswerPhoto,
                        $modelAnswerMap
                    );
              break;

              default;

            }

            if (is_numeric($id)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('/tournament/question/update', [
            'model' => $model,
            'modelAnswerString' => $modelAnswerString,
            'modelAnswerPhoto' => $modelAnswerPhoto,
            'modelAnswerMap' => $modelAnswerMap,
            'modelMap' => $modelMap,
            'countryMap' => $countryMap,
            'tournament' => @$tournament,
            'tournaments' => $tournaments
        ]);
    }

    /**
     * Deletes an existing TournamentQuestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $folderByAnswer = Yii::$app->params['path_frontend'].'/img/tournament/answer';

        $filesByAnswer = $this->dir_tree($folderByAnswer);

        //удаляем файлы для ответов с фотографиями
        foreach ($filesByAnswer as $file) {

            //выризаем сам файл из адреса
            $strFile = substr($file, strripos($file, '/'), strlen($file));

            if (stripos($strFile, 'q_'.$id)) {
                unlink ($file);
            }
            
        }

        //Удаляем записи из связанных таблиц
        TournamentLinkQuestion::deleteAll(['id_q' => $id]);
        QuestionAnswerString::deleteAll(['id' => $id]);
        QuestionAnswerPhoto::deleteAll(['id' => $id]);
        QuestionAnswerMap::deleteAll(['id' => $id]);


        $this->findModel($id)->delete();

        return $this->redirect(['/tournament-question/index']);
    }

    //Получаем все файлы в директории
    public function dir_tree($dir) {
       $path = '';
       $stack[] = $dir;
       while ($stack) {
           $thisdir = array_pop($stack);
           if ($dircont = scandir($thisdir)) {
               $i=0;
               while (isset($dircont[$i])) {
                   if ($dircont[$i] !== '.' && $dircont[$i] !== '..') {
                       $current_file = "{$thisdir}/{$dircont[$i]}";
                       if (is_file($current_file)) {
                           $path[] = "{$thisdir}/{$dircont[$i]}";
                       } elseif (is_dir($current_file)) {
                            $path[] = "{$thisdir}/{$dircont[$i]}";
                           $stack[] = $current_file;
                       }
                   }
                   $i++;
               }
           }
       }
       return $path;
    }


    /**
     * Finds the TournamentQuestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TournamentQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TournamentQuestion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
