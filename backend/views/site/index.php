<?php
$this->title = 'Клиенты';
$this->params['breadcrumbs'] = [['label' => $this->title]];
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;
use backend\models\Order;
 

?>
<div class="client-form">
<?php if (Yii::$app->session->getFlash('success')) : ?>
   <div class="ol-md-12 alert alert-success borr-10">
        <p><?= Yii::$app->session->getFlash('success'); ?></p>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->getFlash('error')) : ?>
    <div class="ol-md-12 alert alert-success borr-10">
        <p><?= Yii::$app->session->getFlash('error'); ?></p>
    </div>
<?php endif; ?>
  

</div>

<div class="client-index">




</div>
