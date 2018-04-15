<?php
namespace common\components\validators;

use yii\validators\Validator;

class QuestionsValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Вопросов для турнира должно быть от 7 до 15';
    }

    protected function validateQuestions($model) {

        if (count($model->questions) < 7 || count($model->questions) > 15) {
            return false;
        }

        return true;
    }    
    
    public function validateAttribute($model, $attribute)
    {
        if (!$this->validateQuestions($model)) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message);
        return <<<JS

        questions = $("#tournament-questions").val().length;

        //console.log(free);

        if (questions < 7 || questions > 15) {
            messages.push({$message});
        } else {
            return true;
        }

JS;
    }
}