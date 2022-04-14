<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $client_id
 * @property string|null $price
 * @property string|null $discount_price
 * @property string|null $url_qrcode
 * @property string|null $url_activate
 * @property int|null $visit
 * @property int $created_at
 */
class Order extends \yii\db\ActiveRecord
{

    CONST MESSAGE_ACTIVATE       = 1;    //только что активированна
    CONST MESSAGE_ACTIVATED      = 2;    //была актвированна раньше
    CONST MESSAGE_NOQR           = 3;    //нету qr кода
    CONST MESSAGE_NOPRICE        = 4;    //цена не может быть нулю

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'created_at'], 'integer'],
            [['visit'], 'boolean'],
            [['created_at','url_activate'], 'safe'],
            [['price', 'discount_price', 'url_qrcode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'price' => 'Price',
            'discount_price' => 'Discount Price',
            'url_qrcode' => 'Url Qrcode',
            'visit' => 'Visit',
            'created_at' => 'Created At',
        ];
    }

}
