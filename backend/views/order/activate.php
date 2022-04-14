<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use backend\models\Order;

/* @var $this yii\web\View */
/* @var $order backend\models\Order */

$this->title = 'Добавить посещение';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true])->label('Цена') ?>

    <?= $form->field($model, 'client_id')->hiddenInput(['value'=>$order->client_id, 'maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'discount')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?php if ($model->discount > 0) :?>
    <div class="form-group">
        <span>Скидка <?=$model->discount?> руб.</span>
    </div>
    <?php endif ?>

    <?= $form->field($model, 'finally_price')->hiddenInput(['maxlength' => true])->label('Цена со скидкой')->label(false) ?>

    <div class="form-group">
        <span class="discount"></span>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Добавить посещение', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
    setInterval(function () {
        if(($('#orderform-discount').val() > 0) && ($('#orderform-price').val() > 0)){
            $('#orderform-finally_price').val($('#orderform-price').val()-$('#orderform-discount').val());
            $('.discount').html('Цена со скидкой: ' + ($('#orderform-price').val()-$('#orderform-discount').val())+' руб.');
        } else {
            if($('#orderform-price').val() > 0){
                $('#orderform-finally_price').val($('#orderform-price').val());
            } else {
                $('#orderform-finally_price').val(0);
                $('.discount').html('');
            }  
        }
    }, 200);
</script>