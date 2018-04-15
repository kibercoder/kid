<?php

namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\Tournament;
use common\models\TournamentQuestion;
use common\models\QuestionAnswerMap;
use common\models\QuestionAnswerPhoto;
use common\models\QuestionAnswerString;
use common\models\TournamentLinkQuestion;
use common\models\Map;
use common\models\Tickets;
use common\models\TournamentPlaces;
use yii\web\NotFoundHttpException;



class TournamentController extends Controller
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
     * Displays tournaments page.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        if (Yii::$app->request->url == '/tournament') {
            throw new NotFoundHttpException('Not found');
        }

        $this->layout = "tournaments";

        //Select Tournaments which have date_begin > curent_date
        $curent_date = strtotime(date('Y-m-d H:i'));

        $mTournament1 = Tournament::find()->where(["type_age" => "1"])
                        ->andWhere(['>', 'date_begin', $curent_date])->asArray()->all();

        $mTournament2 = Tournament::find()->where(["type_age" => "2"])
                        ->andWhere(['>', 'date_begin', $curent_date])->asArray()->all();

        $mTournament3 = Tournament::find()->where(["type_age" => "3"])
                        ->andWhere(['>', 'date_begin', $curent_date])->asArray()->all();

        return $this->render('index', [
            "mTournament1" => $mTournament1,
            "mTournament2" => $mTournament2,
            "mTournament3" => $mTournament3,
        ]);
    }


    /**
     * Get the any tour.
     *
     * @return mixed
     */
    public function actionGetTour()
    {
        $post = Yii::$app->request->post();
        $id_tour = (int)$post['id_tour'];

        if (is_numeric($id_tour)) {

            $curent_date = strtotime(date('Y-m-d H:i'));
            $mTournament = Tournament::find()->where(["id_t" => $id_tour])
                            ->andWhere(['>', 'date_begin', $curent_date])->asArray()->one();

            if (count($mTournament) > 0) {

                $photoByTour = Yii::$app->params['path_frontend'].'/img/tournament/img_tour/'.$mTournament['photo'];

                if (!file_exists($photoByTour) ||
                    !preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $mTournament['photo'])){
                    $mTournament['photo'] = false;
                }

                $mTournament['date_begin'] = date("Y,m,d H:i", $mTournament['date_begin']);


                if ($mTournament['free']) {

                    $places = Tickets::find()->where(["id_t1" => $id_tour])->asArray()->all();

                    $amount_places = count($places);
 
                    $list_places = [];

                    foreach ($places as $place) {

                        $tour = Tournament::find()->where(["id_t" => $place['id_t2']])
                        ->andWhere(['>', 'date_begin', $curent_date])->asArray()->one();

                        $list_places[] = "<li class=\"tour\" id_tour=\"$tour[id_t]\">$tour[title]</li>\n";
                    }


                } else {

                    $places = TournamentPlaces::find()->where(["id_t" => $id_tour])->asArray()->all();
                    $amount_places = count($places)+3;

                    $list_places = [];

                    $list_places[] = "<li>$mTournament[first_place] кидкойнов</li>\n";
                    $list_places[] = "<li>$mTournament[second_place] кидкойнов</li>\n\n";
                    $list_places[] = "<li>$mTournament[third_place] кидкойнов</li>\n";

                    foreach ($places as $place) {
                        $list_places[] = "<li>$place[value] кидкойнов</li>\n";
                    }


                }

                $red_players = [];
                $green_players = [];
                $blue_players = [];

                for($i = 1; $i<=$mTournament['max_member']; $i++){
                    $red_players[] = '<li class="empty"></li>';
                    $green_players[] = '<li class="empty"></li>';
                    $blue_players[] = '<li class="empty"></li>';
                }


                $mTournament['list_places'] = $list_places;

                $mTournament['amount_places'] = $amount_places;

                $mTournament['red_players'] = $red_players;
                $mTournament['green_players'] = $green_players;
                $mTournament['blue_players'] = $blue_players;

                echo json_encode($mTournament);

            } else {
                echo json_encode(['error' => true]);
            }

        }


    }
    
    /**
     * Displays map page.
     *
     * @return mixed
     */
    public function actionMap()
    {

        $this->layout = "empty";

        $map = Map::find()->asArray()->all();

        return $this->render('map', [
                'map' => $map,
        ]);
    }


}
