<?php
namespace common\components\validators;

use yii\validators\Validator;

class TicketsValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Билетов на платные турниры должно быть от 3 до 15';
    }

    protected function validateTickets($model) {

        if ($model->free && (count($model->tickets) < 3 || count($model->tickets) > 15)) {
            return false;
        }

        return true;
    }    
    
    public function validateAttribute($model, $attribute)
    {
        if (!$this->validateTickets($model)) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message);
        return <<<JS

        tickets = $("#tournament-tickets").val().length;
        free = $("#tournament-free").val();

        //console.log(free);

        if (free && (tickets < 3 || tickets > 15)) {
            messages.push({$message});
        } else {
            return true;
        }

JS;
    }
}