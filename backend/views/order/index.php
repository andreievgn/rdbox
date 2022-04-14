<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderhClient */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'client_id',
            'price',
            'discount_price',
            [
                'attribute' => 'url_qrcode',
                'format' => 'html',
                'value' => function($data) {
                    $url = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://'.$_SERVER['HTTP_HOST'].'/qrcode/'.$data['url_qrcode'];
                    return Html::a($data['url_qrcode'], $url);
                },
                'options' => ['style' => 'width:8%;'],
                'contentOptions' => ['style' => 'vertical-align:middle;']
            ],
            [
                'attribute' => 'url_activate',
                'format' => 'html',
                'value' => function($data) {
                    $url = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://'.$_SERVER['HTTP_HOST'].'/activate/'.$data['url_activate'];
                    return Html::a($data['url_activate'], $url);
                },
                'options' => ['style' => 'width:8%;'],
                'contentOptions' => ['style' => 'vertical-align:middle;']
            ],
            'visit',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                // 'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                //     return Url::toRoute([$action, 'id' => $model->id]);
                //  }
            ],
        ],
    ]); ?>


</div>
