<?php

namespace common\models;

use Yii;

use yii\web\UploadedFile;
use common\helpers\CheckUploadFile;
use common\models\Tournament;
use common\models\QuestionAnswerString;
use common\models\QuestionAnswerPhoto;
use common\models\QuestionAnswerMap;
use common\models\Map;

/**
 * This is the model class for table "tournamentQuestion".
 *
 * @property int $id
 * @property int $question Вопрос
 * @property string $type Тип
 *
 * @property QuestionAnswerMap[] $questionAnswerMaps
 * @property Map[] $maps
 * @property QuestionAnswerPhoto $questionAnswerPhoto
 * @property QuestionAnswerString $questionAnswerString
 * @property Tournament $linkT
 */
class TournamentQuestion extends \yii\db\ActiveRecord
{


    public $remove_photo = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournamentQuestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'question', 'type_age'], 'required'],
            [['type', 'question'], 'string'],
            ['type_age', 'in', 'range' => [1, 2, 3]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
            'type' => 'Тип',
            'type_age' => 'Возраст',
            'remove_photo' => 'Удалить фото?'
        ];
    }


    //Добавление данные в модель QuestionAnswerString
    public function saveQuestionAnswerString($model)
    {

        //print '<pre>';
        //print_r(Yii::$app->request->post());

        if (!$model->validate()) {
            return false;
        }

        $modelAnswerString = new QuestionAnswerString();
        $modelAnswerString->load(Yii::$app->request->post());

        $db = Yii::$app->db;

        $outerTransaction = $db->beginTransaction();

        try {

            $db->createCommand()->insert('tournamentQuestion', [
                           'question' => $model->question,
                           'type' => $model->type,
                           'type_age' => $model->type_age
                          ])->execute();

            $lastIdQuestion = Yii::$app->db->getLastInsertID();

            $innerTransaction = $db->beginTransaction();

            try {

                $modelAnswerString->id = $lastIdQuestion;

                if (!$modelAnswerString->validate()) {
                    throw new \Exception();
                }

                $modelAnswerString->photo = UploadedFile::getInstance($modelAnswerString, 'photo');

                $uploadFile = new CheckUploadFile();

                $photo = $uploadFile->checkImage(
                    Yii::$app->params['max_filesize_img'], 
                    Yii::$app->params['path_frontend'].'/img/tournament/answer_string/',
                    false,
                    false,
                    $modelAnswerString->photo,
                    ['jpg','jpeg','gif','png'],
                    "q_".$lastIdQuestion."_1"
                );

                if ($photo['success']) {
                    $modelAnswerString->photo = $photo['namefile'];
                }


                $db->createCommand()->insert('questionAnswerString', [
                   'id' => $modelAnswerString->id,
                   'photo' => $modelAnswerString->photo,
                   'answer1' => $modelAnswerString->answer1,
                   'answer2' => $modelAnswerString->answer2,
                   'answer3' => $modelAnswerString->answer3,
                   'answer4' => $modelAnswerString->answer4,
                   'right_answer' => $modelAnswerString->right_answer
                ])->execute();

                $innerTransaction->commit();

            } catch (\Exception $e) {
              $innerTransaction->rollBack();
              return false;
            } catch (\Throwable $e) {
              $innerTransaction->rollBack();
              return false;
              //throw $e;
            }

            $outerTransaction->commit();
            return $lastIdQuestion;
            

        } catch (\Exception $e) {
          $outerTransaction->rollBack();
          return false;
        } catch (\Throwable $e) {
          $innerTransaction->rollBack();
          return false;
          //throw $e;
        }

    }


    //Добавление данные в модель QuestionAnswerPhoto
    public function saveQuestionAnswerPhoto($model)
    {

        //print '<pre>';
        //print_r(Yii::$app->request->post());


        if (!$model->validate()) {
            return false;
        }


        $modelAnswerPhoto = new QuestionAnswerPhoto();
        $modelAnswerPhoto->load(Yii::$app->request->post());

        $db = Yii::$app->db;

        $outerTransaction = $db->beginTransaction();

        try {

            $db->createCommand()->insert('tournamentQuestion', [
                   'question' => $model->question,
                   'type' => $model->type,
                   'type_age' => $model->type_age
            ])->execute();

            $lastIdQuestion = Yii::$app->db->getLastInsertID();

            $innerTransaction = $db->beginTransaction();

            try {

                $modelAnswerPhoto->id = $lastIdQuestion;

                for($i=1; $i<=8; $i++) {

                    $field = "answerPhoto".$i;

                    $modelAnswerPhoto->$field = UploadedFile::getInstance($modelAnswerPhoto, $field);

                    $uploadFile = new CheckUploadFile();

                    $photo = $uploadFile->checkImage(
                        Yii::$app->params['max_filesize_img'], 
                        Yii::$app->params['path_frontend'].'/img/tournament/answer/',
                        false,
                        false,
                        $modelAnswerPhoto->$field,
                        ['jpg','jpeg','gif','png'],
                        "q_".$lastIdQuestion."_".$i
                    );

                    if (!$photo['success']) {

                        //Удаляем картинки если он есть
                        $folderByAnswer = Yii::$app->params['path_frontend'].'/img/tournament/answer';

                        $filesByAnswer = $this->dir_tree($folderByAnswer);

                        foreach ($filesByAnswer as $file) {

                            //выризаем сам файл из адреса
                            $strFile = substr($file, strripos($file, '/'), strlen($file));

                            if (stripos($strFile, 'q_'.$lastIdQuestion)) {
                                unlink ($file);
                            }
                        }

                        throw new \Exception();
                    } else {
                        $modelAnswerPhoto->$field = $photo['namefile'];
                    }

                }

                if (!$modelAnswerPhoto->validate()) {
                    throw new \Exception();
                }

                //echo 'here<br />';
                //echo $modelAnswerPhoto->right_answer;
                //die;

                $db->createCommand()->insert('questionAnswerPhoto', [
                   'id' => $modelAnswerPhoto->id,
                   'answerPhoto1' => $modelAnswerPhoto->answerPhoto1,
                   'answerPhoto2' => $modelAnswerPhoto->answerPhoto2,
                   'answerPhoto3' => $modelAnswerPhoto->answerPhoto3,
                   'answerPhoto4' => $modelAnswerPhoto->answerPhoto4,
                   'answerPhoto5' => $modelAnswerPhoto->answerPhoto5,
                   'answerPhoto6' => $modelAnswerPhoto->answerPhoto6,
                   'answerPhoto7' => $modelAnswerPhoto->answerPhoto7,
                   'answerPhoto8' => $modelAnswerPhoto->answerPhoto8,
                   'right_answer' => $modelAnswerPhoto->right_answer
                ])->execute();

                $innerTransaction->commit();

            } catch (\Exception $e) {
              $innerTransaction->rollBack();
              return false;
            } catch (\Throwable $e) {
              $innerTransaction->rollBack();
              return false;
              //throw $e;
            }

            $outerTransaction->commit();
            return $lastIdQuestion;
            

        } catch (\Exception $e) {
          $outerTransaction->rollBack();
          return false;
        } catch (\Throwable $e) {
          $innerTransaction->rollBack();
          return false;
          //throw $e;
        }


    }


    //Добавление данные в модель QuestionAnswerMap
    public function saveQuestionAnswerMap($model)
    {

        //print '<pre>';
        //print_r(Yii::$app->request->post());

        if (!$model->validate()) {
            return false;
        }

        $modelAnswerMap = new QuestionAnswerMap();
        $modelAnswerMap->load(Yii::$app->request->post());

        $db = Yii::$app->db;

        $outerTransaction = $db->beginTransaction();

        try {

           $db->createCommand()->insert('tournamentQuestion', [
                           'question' => $model->question,
                           'type' => $model->type,
                           'type_age' => $model->type_age
                          ])->execute();

            $lastIdQuestion = Yii::$app->db->getLastInsertID();

            $innerTransaction = $db->beginTransaction();

            try {

                $modelAnswerMap->id = $lastIdQuestion;

                if (!$modelAnswerMap->validate()) {
                    throw new \Exception();
                }

                $db->createCommand()->insert('questionAnswerMap', [
                   'id' => $modelAnswerMap->id,
                   'id_map' => $modelAnswerMap->id_map
                ])->execute();

                $innerTransaction->commit();

            } catch (\Exception $e) {
              $innerTransaction->rollBack();
              return false;
            } catch (\Throwable $e) {
              $innerTransaction->rollBack();
              return false;
              //throw $e;
            }

            $outerTransaction->commit();
            return $lastIdQuestion;
            

        } catch (\Exception $e) {
          $outerTransaction->rollBack();
          return false;
        } catch (\Throwable $e) {
          $innerTransaction->rollBack();
          return false;
          //throw $e;
        }

    }


    //ОБновляем модель QuestionAnswerString
    public function UpdateQuestionAnswerString($model, $modelAnswerString, $modelAnswerPhoto, $modelAnswerMap)
    {

        //print '<pre>';
        //print_r(Yii::$app->request->post()['TournamentQuestion']);

        $modelPost = Yii::$app->request->post()['TournamentQuestion'];

        $modelAnswerString->load(Yii::$app->request->post());

        //Заносим в переменную id для проверки есть ли запись в таблицы или нет
        $isId = $modelAnswerString->id;

        $db = Yii::$app->db;

        $outerTransaction = $db->beginTransaction();

        try {

            $db->createCommand()->update('tournamentQuestion', [
                         'question' => $model->question,
                         'type' => $model->type,
                         'type_age' => $model->type_age
                      ], 
                      ['id' => $model->id])->execute();

            $innerTransaction = $db->beginTransaction();

            try {

                $modelAnswerString->id = $model->id;

                if (!$modelAnswerString->validate()) {
                    throw new \Exception();
                }

                $old_photo = QuestionAnswerString::find()->where([
                      'id' => $model->id
                  ])->one();


                if (!$modelPost['remove_photo']){

                  $modelAnswerString->photo = UploadedFile::getInstance($modelAnswerString, 'photo');

                  if ($modelAnswerString->photo && preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $modelAnswerString->photo->name)){

                    $uploadFile = new CheckUploadFile();

                    $photo = $uploadFile->checkImage(
                        Yii::$app->params['max_filesize_img'], 
                        Yii::$app->params['path_frontend'].'/img/tournament/answer_string/',
                        false,
                        false,
                        $modelAnswerString->photo,
                        ['jpg','jpeg','gif','png'],
                        "q_".$model->id."_1"
                    );

                    if ($photo['success']) {
                        $modelAnswerString->photo = $photo['namefile'];
                    } else {
                      throw new \Exception();
                    }

                  } else {
                    $modelAnswerString->photo = $old_photo->photo;
                  }

                } else {

                    $fileByAnswer = Yii::$app->params['path_frontend'].'/img/tournament/answer_string/'.$old_photo->photo;

                    if (file_exists($fileByAnswer)) {
                      unlink($fileByAnswer);
                    }

                    $modelAnswerString->photo = null;

                }


                if ($isId && $isId == $model->id) {

                  $db->createCommand()->update('questionAnswerString', [
                     'photo' => $modelAnswerString->photo,
                     'answer1' => $modelAnswerString->answer1,
                     'answer2' => $modelAnswerString->answer2,
                     'answer3' => $modelAnswerString->answer3,
                     'answer4' => $modelAnswerString->answer4,
                     'right_answer' => $modelAnswerString->right_answer
                  ], 
                  ['id' => $model->id])->execute();

                } else {

                  $db->createCommand()->insert('questionAnswerString', [
                     'id' => $modelAnswerString->id,
                     'photo' => $modelAnswerString->photo,
                     'answer1' => $modelAnswerString->answer1,
                     'answer2' => $modelAnswerString->answer2,
                     'answer3' => $modelAnswerString->answer3,
                     'answer4' => $modelAnswerString->answer4,
                     'right_answer' => $modelAnswerString->right_answer
                  ])->execute();

                }

                $innerTransaction->commit();


            } catch (\Exception $e) {
              $innerTransaction->rollBack();
              return false;
            } catch (\Throwable $e) {
              $innerTransaction->rollBack();
              return false;
              //throw $e;
            }

            $outerTransaction->commit();

            //Удаляем существующий записи из других таблиц
            if ($modelAnswerMap->id && $modelAnswerMap->id == $model->id) {
              QuestionAnswerMap::deleteAll(['id' => $model->id]);
            }

            if ($modelAnswerPhoto->id && $modelAnswerPhoto->id == $model->id) {

              QuestionAnswerPhoto::deleteAll(['id' => $model->id]);

              //Удаляем картинки если он есть
              $folderByAnswer = Yii::$app->params['path_frontend'].'/img/tournament/answer';

              $filesByAnswer = $this->dir_tree($folderByAnswer);

              foreach ($filesByAnswer as $file) {

                  //выризаем сам файл из адреса
                  $strFile = substr($file, strripos($file, '/'), strlen($file));

                  if (stripos($strFile, 'q_'.$model->id)) {
                      unlink ($file);
                  }
              }

            }

            return $model->id;
            

        } catch (\Exception $e) {
          $outerTransaction->rollBack();
          return false;
        } catch (\Throwable $e) {
          $innerTransaction->rollBack();
          return false;
          //throw $e;
        }

    }


    //ОБновляем модель QuestionAnswerPhoto
    public function UpdateQuestionAnswerPhoto($model, $modelAnswerString, $modelAnswerPhoto, $modelAnswerMap)
    {

        //print '<pre>';
        //print_r(Yii::$app->request->post());
        $modelAnswerPhoto->load(Yii::$app->request->post());

        //Заносим в переменную id для проверки есть ли запись в таблицы или нет
        $isId = $modelAnswerPhoto->id;

        $db = Yii::$app->db;

        $outerTransaction = $db->beginTransaction();

        try {

            $db->createCommand()->update('tournamentQuestion', [
                         'question' => $model->question,
                         'type' => $model->type,
                         'type_age' => $model->type_age
                      ], 
                      ['id' => $model->id])->execute();

            $innerTransaction = $db->beginTransaction();

            try {

                $modelAnswerPhoto->id = $model->id;

                $old_photo = QuestionAnswerPhoto::find()->where([
                    'id' => $model->id
                ])->one();

                for($i=1; $i<=8; $i++) {

                    $field = "answerPhoto".$i;

                    $modelAnswerPhoto->$field = UploadedFile::getInstance($modelAnswerPhoto, $field);

   
                    if ($modelAnswerPhoto->$field && preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $modelAnswerPhoto->$field->name)) {

                      $uploadFile = new CheckUploadFile();

                      $photo = $uploadFile->checkImage(
                          Yii::$app->params['max_filesize_img'], 
                          Yii::$app->params['path_frontend'].'/img/tournament/answer/',
                          140,
                          140,
                          $modelAnswerPhoto->$field,
                          ['jpg','jpeg','gif','png'],
                          "q_".$model->id."_".$i
                      );

                      if (!$photo['success']) {

                          //Удаляем картинки если он есть
                          $folderByAnswer = Yii::$app->params['path_frontend'].'/img/tournament/answer';

                          $filesByAnswer = $this->dir_tree($folderByAnswer);

                          foreach ($filesByAnswer as $file) {

                              //выризаем сам файл из адреса
                              $strFile = substr($file, strripos($file, '/'), strlen($file));

                              if (stripos($strFile, 'q_'.$model->id)) {
                                  unlink ($file);
                              }
                          }

                          throw new \Exception();
                      } else {
                          $modelAnswerPhoto->$field = $photo['namefile'];
                      }

                    } else if (preg_match('/\.(?:jp(?:e?g|e|2)|gif|png)$/i', $old_photo->$field)) {

                        $fileByAnswer = Yii::$app->params['path_frontend'].'/img/tournament/answer/'.$old_photo->$field;

                        if (file_exists($fileByAnswer)) {

                          $modelAnswerPhoto->$field = $old_photo->$field;

                        } else {
                          throw new \Exception();
                        }
                    }

                }


                if (!$modelAnswerPhoto->validate()) {
                    throw new \Exception();
                }

                if ($isId && $isId == $model->id) {

                  $db->createCommand()->update('questionAnswerPhoto', [
                   'answerPhoto1' => $modelAnswerPhoto->answerPhoto1,
                   'answerPhoto2' => $modelAnswerPhoto->answerPhoto2,
                   'answerPhoto3' => $modelAnswerPhoto->answerPhoto3,
                   'answerPhoto4' => $modelAnswerPhoto->answerPhoto4,
                   'answerPhoto5' => $modelAnswerPhoto->answerPhoto5,
                   'answerPhoto6' => $modelAnswerPhoto->answerPhoto6,
                   'answerPhoto7' => $modelAnswerPhoto->answerPhoto7,
                   'answerPhoto8' => $modelAnswerPhoto->answerPhoto8,
                   'right_answer' => $modelAnswerPhoto->right_answer
                  ], 
                  ['id' => $model->id])->execute();

                } else {

                  $db->createCommand()->insert('questionAnswerPhoto', [
                     'id' => $modelAnswerPhoto->id,
                     'answerPhoto1' => $modelAnswerPhoto->answerPhoto1,
                     'answerPhoto2' => $modelAnswerPhoto->answerPhoto2,
                     'answerPhoto3' => $modelAnswerPhoto->answerPhoto3,
                     'answerPhoto4' => $modelAnswerPhoto->answerPhoto4,
                     'answerPhoto5' => $modelAnswerPhoto->answerPhoto5,
                     'answerPhoto6' => $modelAnswerPhoto->answerPhoto6,
                     'answerPhoto7' => $modelAnswerPhoto->answerPhoto7,
                     'answerPhoto8' => $modelAnswerPhoto->answerPhoto8,
                     'right_answer' => $modelAnswerPhoto->right_answer
                  ])->execute();

                }

                $innerTransaction->commit();


            } catch (\Exception $e) {
              $innerTransaction->rollBack();
              return false;
            } catch (\Throwable $e) {
              $innerTransaction->rollBack();
              return false;
              //throw $e;
            }

            $outerTransaction->commit();

            //Удаляем существующий записи из других таблиц
            if ($modelAnswerMap->id && $modelAnswerMap->id == $model->id) {
              QuestionAnswerMap::deleteAll(['id' => $model->id]);
            }

            if ($modelAnswerString->id && $modelAnswerString->id == $model->id) {
              QuestionAnswerString::deleteAll(['id' => $model->id]);
            }


            //Удаляем файл который можетпринадлежать модели QuestionAnswerString
            $folderByAnswer = 
                  Yii::$app->params['path_frontend'].'/img/tournament/answer_string';

            $filesByAnswer = $this->dir_tree($folderByAnswer);

            foreach ($filesByAnswer as $file) {

              //выризаем сам файл из адреса
              $strFile = substr($file, strripos($file, '/'), strlen($file));

              if (stripos($strFile, 'q_'.$model->id."_1")) {
                  unlink ($file);
              }

            }

            return $model->id;
            

        } catch (\Exception $e) {
          $outerTransaction->rollBack();
          return false;
        } catch (\Throwable $e) {
          $innerTransaction->rollBack();
          return false;
          //throw $e;
        }

    }


    //ОБновляем модель QuestionAnswerMap
    public function UpdateQuestionAnswerMap($model, $modelAnswerString, $modelAnswerPhoto, $modelAnswerMap)
    {

        //print '<pre>';
        //print_r(Yii::$app->request->post());
        $modelAnswerMap->load(Yii::$app->request->post());

        //Заносим в переменную id для проверки есть ли запись в таблицы или нет
        $isId = $modelAnswerMap->id;

        $db = Yii::$app->db;

        $outerTransaction = $db->beginTransaction();

        try {

            $db->createCommand()->update('tournamentQuestion', [
                         'question' => $model->question,
                         'type' => $model->type,
                         'type_age' => $model->type_age
                      ], 
                      ['id' => $model->id])->execute();

            $innerTransaction = $db->beginTransaction();

            try {

                $modelAnswerMap->id = $model->id;

                if (!$modelAnswerMap->validate()) {
                    throw new \Exception();
                }

                if ($isId && $isId == $model->id) {

                  $db->createCommand()->update('questionAnswerMap', [
                    'id_map' => $modelAnswerMap->id_map
                  ], 
                  ['id' => $model->id])->execute();

                } else {

                  $db->createCommand()->insert('questionAnswerMap', [
                     'id' => $modelAnswerMap->id,
                     'id_map' => $modelAnswerMap->id_map
                  ])->execute();

                }

                $innerTransaction->commit();


            } catch (\Exception $e) {
              $innerTransaction->rollBack();
              return false;
            } catch (\Throwable $e) {
              $innerTransaction->rollBack();
              return false;
              //throw $e;
            }

            $outerTransaction->commit();

            //Удаляем существующий записи из других таблиц
            if ($modelAnswerString->id && $modelAnswerString->id == $model->id) {
              QuestionAnswerString::deleteAll(['id' => $model->id]);
            }

            if ($modelAnswerPhoto->id && $modelAnswerPhoto->id == $model->id) {

              QuestionAnswerPhoto::deleteAll(['id' => $model->id]);

              //Удаляем картинки если он есть
              $folderByAnswer = Yii::$app->params['path_frontend'].'/img/tournament/answer';

              $filesByAnswer = $this->dir_tree($folderByAnswer);

              foreach ($filesByAnswer as $file) {

                  //выризаем сам файл из адреса
                  $strFile = substr($file, strripos($file, '/'), strlen($file));

                  if (stripos($strFile, 'q_'.$model->id)) {
                      unlink ($file);
                  }
              }

            }


            //Удаляем файл который может принадлежать модели QuestionAnswerString
            $folderByAnswer = 
                  Yii::$app->params['path_frontend'].'/img/tournament/answer_string';

            $filesByAnswer = $this->dir_tree($folderByAnswer);

            foreach ($filesByAnswer as $file) {

              //выризаем сам файл из адреса
              $strFile = substr($file, strripos($file, '/'), strlen($file));

              if (stripos($strFile, 'q_'.$model->id."_1")) {
                  unlink ($file);
              }

            }

            return $model->id;
            

        } catch (\Exception $e) {
          $outerTransaction->rollBack();
          return false;
        } catch (\Throwable $e) {
          $innerTransaction->rollBack();
          return false;
          //throw $e;
        }

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
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionAnswerMaps()
    {
        return $this->hasMany(QuestionAnswerMap::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaps()
    {
        return $this->hasMany(Map::className(), ['id_map' => 'id_map'])->viaTable('questionAnswerMap', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionAnswerPhoto()
    {
        return $this->hasOne(QuestionAnswerPhoto::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionAnswerString()
    {
        return $this->hasOne(QuestionAnswerString::className(), ['id' => 'id']);
    }


}
