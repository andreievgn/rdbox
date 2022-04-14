<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchClient */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php if (Yii::$app->session->getFlash('error')) : ?>
        <div class="ol-md-12 alert alert-error borr-10">
            <p><?= Yii::$app->session->getFlash('error'); ?></p>
        </div>
    <?php endif; ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'phone',
            [
                'header' => 'Количество посещений',
                'attribute' => 'is_publish',
                'value' => function($data) {
                    $order = Order::find()->where(['client_id' => $data['id'],'visit' => true])->all();

                    return count($order);
                },
                'options' => ['style' => 'width:8%;'],
                'contentOptions' => ['style' => 'vertical-align:middle;']
            ],
            [
                'class' => ActionColumn::className(),
                // 'urlCreator' => function ($action, Client $model, $key, $index, $column) {
                //     return Url::toRoute([$action, 'id' => $model->id]);
                //  }
            ],
        ],
    ]); ?>


</div>