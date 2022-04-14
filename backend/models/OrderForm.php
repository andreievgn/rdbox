<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class OrderForm extends Model
{
    public $price;
    public $client_id;
    public $discount;
    public $finally_price;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'price'], 'required'],
            ['price', 'priceFilter'],
            [['finally_price', 'price','discount'], 'string', 'max' => 255],
        ];
    }

    public function getDiscount($orders)
    {
        $this->discount = 0;
        if(count($orders) >= 3){
            $this->discount = 5;
        }

        if(count($orders) >= 3){
            $this->discount = 10;
        }

        if(count($orders) >= 8){
            $this->discount = 5;
        }

        if(count($orders) >= 10){
            $this->discount = 10;
        }
    }

    public function priceFilter($attribute)
    {
        if($this->price == 0){
            $this->addError($attribute,'Цена не может равняться нулю');
        }
    }

    
}
