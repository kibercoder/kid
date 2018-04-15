<?php
namespace common\components\validators;

use yii\validators\Validator;

class MembersValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Минимальное колличество игроков для командного турнира - 10';
    }

    protected function validateMembers($model) {

        if (($model->type == 'team') && ($model->max_member >= 10)) {
            return true;
        } else if ($model->type != 'team' && ($model->max_member > 0)) {
            return true;
        } else if ($model->type != 'team' && ($model->max_member <= 0)) {
            return false;
        }else if ($model->type == 'team') {
            return false;
        }

    }    
    
    public function validateAttribute($model, $attribute)
    {

        if ($model->type != 'team' && $model->max_member <= 0) {
            $this->message = 'Мнмальное колличество игроков - 1';
        }

        if (!$this->validateMembers($model)) {
            $model->addError($attribute, $message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = $this->message;


        return <<<JS
        
        type = $("#tournament-type").val();
        max_member = parseInt($("#tournament-max_member").val());

        if ((type == 'team') && (max_member >= 10)) {
            return true;
        } else if (type != 'team' && (max_member > 0)) {
            return true;
        } else if (type != 'team' && (max_member <= 0)) {
            messages.push('Мнмальное колличество игроков - 1');
        }else if (type == 'team') {
            messages.push('{$message}');
        }
JS;




    }
}