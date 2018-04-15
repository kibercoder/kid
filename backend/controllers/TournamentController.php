<?php

namespace backend\controllers;

use Yii;
use common\models\Tournament;
use common\models\TournamentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;

use common\models\TournamentQuestion;
use common\models\QuestionAnswerString;
use common\models\QuestionAnswerPhoto;
use common\models\QuestionAnswerMap;
use common\models\TournamentLinkQuestion;
use common\models\Map;
use common\models\TournamentPlaces;
use common\models\Tickets;

/**
 * TournamentController implements the CRUD actions for Tournament model.
 */
class TournamentController extends Controller
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
     * Lists all Tournament models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TournamentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tournament model.
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
     * Creates a new Tournament model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tournament();

        if ($model->load(Yii::$app->request->post()) && $model->createNewTournament()) {

            return $this->redirect(['view', 'id' => $model->id_t]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Tournament model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->updateTournament($model)) {
            return $this->redirect(['view', 'id' => $model->id_t]);
        }

        $model->questions = ArrayHelper::map(TournamentLinkQuestion::find()
                ->where(['id_t' => $id])
                ->asArray()->all(), 'id_q', 'id_q');

        $model->tickets = ArrayHelper::map(Tickets::find()
                ->where(['id_t1' => $id])
                ->asArray()->all(), 'id_t2', 'id_t2');


        $model->addplace = ArrayHelper::map(TournamentPlaces::find()
                ->where(['id_t' => $id])->orderBy('place')
                ->asArray()->all(), 'place', 'value');

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tournament model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);

        $photoByTour = Yii::$app->params['path_frontend'].'/img/tournament/img_tour/'.$model->photo;

        TournamentLinkQuestion::deleteAll(['id_t' => $id]);
        Tickets::deleteAll(['id_t1' => $id]);
        TournamentPlaces::deleteAll(['id_t' => $id]);

        //удаляем файл фотографии турнира и саму запись турнира из таблицы
        if (file_exists($photoByTour) &&
            preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $model->photo)){

            if (unlink ($photoByTour)) {
                $model->delete();
            } else {
                return false;
            }

        } else {
            $model->delete();
        }

        return $this->redirect(['index']);
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
     * Finds the Tournament model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tournament the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tournament::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
