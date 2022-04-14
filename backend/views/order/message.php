<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use backend\models\Order;

/* @var $this yii\web\View */
/* @var $order backend\models\Order */

$this->title = 'Сообщение';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="order-view">
    <?php if($message == Order::MESSAGE_ACTIVATED) : ?>
    	Клиент уже был
   	<?php endif ?>

   	<?php if($message == Order::MESSAGE_ACTIVATE) : ?>
    	Посещение успешно добавлено
   	<?php endif ?>

   	<?php if($message == Order::MESSAGE_NOQR) : ?>
    	Неправильная ссылка
   	<?php endif ?>

   	<?php if($message == Order::MESSAGE_NOPRICE) : ?>
    	Цена не может быть равна нулю
   	<?php endif ?>

</div>