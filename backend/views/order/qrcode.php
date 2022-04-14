<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = 'Qr код';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$url = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://'.$_SERVER['HTTP_HOST'].'/activate/'.$model->url_activate;

echo Text::widget([
    'outputDir' => '@webroot/upload/qrcode',
    'outputDirWeb' => '@web/upload/qrcode',
    'ecLevel' => QRcode::QR_ECLEVEL_L,
    'text' => $url,
    'size' => 6,
    'margin' => 4
]);
?>