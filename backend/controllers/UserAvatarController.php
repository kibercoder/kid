<?php

namespace backend\controllers;

use Yii;
use common\models\UserAvatar;
use common\models\UserAvatarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserAvatarController implements the CRUD actions for UserAvatar model.
 */
class UserAvatarController extends Controller
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
     * Lists all UserAvatar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserAvatarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserAvatar model.
     * @param integer $id_a
     * @param integer $id_u
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_a, $id_u)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_a, $id_u),
        ]);
    }

    /**
     * Creates a new UserAvatar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserAvatar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_a' => $model->id_a, 'id_u' => $model->id_u]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserAvatar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_a
     * @param integer $id_u
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_a, $id_u)
    {
        $model = $this->findModel($id_a, $id_u);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_a' => $model->id_a, 'id_u' => $model->id_u]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserAvatar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_a
     * @param integer $id_u
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_a, $id_u)
    {
        $this->findModel($id_a, $id_u)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserAvatar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_a
     * @param integer $id_u
     * @return UserAvatar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_a, $id_u)
    {
        if (($model = UserAvatar::findOne(['id_a' => $id_a, 'id_u' => $id_u])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
