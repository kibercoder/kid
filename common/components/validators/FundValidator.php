<?php
namespace common\components\validators;

use yii\validators\Validator;

class FundValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Призовой фонд должен быть равен 3 местам';
    }

    protected function validateFund($model) {

        $sumOfPlaces = (int)$model->first_place + (int)$model->second_place + (int)$model->third_place;

        return (int)$sumOfPlaces == (int)$model->fund;
    }    
    
    public function validateAttribute($model, $attribute)
    {
        if (!$this->validateFund($model)) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message);
        return <<<JS
        var sumOfPlaces = parseInt($('input#tournament-first_place').val()) 
                        + parseInt($('input#tournament-second_place').val())
                        + parseInt($('input#tournament-third_place').val());

        $('.addplace').each(function(){
            value = parseInt($(this).val());
            if (!isNaN(value) && value > 0 ) sumOfPlaces+= value;
        });


        //console.log(sumOfPlaces);

        if (sumOfPlaces == parseInt($('input#tournament-fund').val())) {
            //console.log('true');
            return true;
        }else {
            //console.log('false');
            messages.push('Призовой фонд должен быть равен сумме всех призовых мест - ' + sumOfPlaces);
        }
JS;
    }
}