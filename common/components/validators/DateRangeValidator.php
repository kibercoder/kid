<?php
namespace common\components\validators;

use yii\validators\Validator;

class DateRangeValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Начальная дата не может быть меньше чем текущая';
    }

    protected function validateRange($model) {

        $now = strtotime(date("Y-m-d H:i"));

        $validate = ($model->date_begin >= $now);

        if ($validate) {
            return true; 
        }
        return false;
    }    
    
    public function validateAttribute($model, $attribute)
    {

        $message = ($attribute == 'date_begin') ? $this->message : 'Конечная дата должна быть больше начальной!';

        if (!$this->validateRange($model)) {
            $model->addError($attribute, $message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = $this->message;

        return <<<JS
        
        startDate = new Date().getTime();
        beginDate = new Date($("#tournament-date_begin").val()).getTime();
        //console.log("{$message}");

        if (beginDate >= startDate) {
            return true;
        } else {
            messages.push('{$message}');
        }
JS;


    }
}