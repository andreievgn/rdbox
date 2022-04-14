<?php

namespace backend\controllers;

use Yii;
use backend\models\Client;
use backend\models\SearchClient;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Order;
use yii\web\ForbiddenHttpException;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Client models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
             $this->layout = 'blank';
             return $this->redirect('site/login');
        }

        if (!\Yii::$app->user->can('indexClient')) {
            if(Yii::$app->user->can('indexOrder')){
                return $this->redirect('order');
            }
            throw new ForbiddenHttpException('Access denied');
        }

        $searchModel = new SearchClient();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if (!\Yii::$app->user->can('viewClient')) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!\Yii::$app->user->can('createClient')) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = new Client();
        $sms = Yii::$app->sms;

        if ($this->request->isPost) {

            if ($model->load($this->request->post())){
                $client = Client::find()->where(['phone'=>$model->phone])->one();
                if(!$client){
                    if($model->save()){
                        $order = new Order();
                        $order->client_id = $model->id;
                        $order->url_qrcode = strtoupper(substr(sha1(microtime(true)), 0, 16));
                        $order->url_activate = strtoupper(substr(sha1(microtime(true)), 0, 18));
                        $order->save();
                        $url = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://'.$_SERVER['HTTP_HOST'].'/qrcode/'.$order->url_qrcode;
                        $phone = str_replace([' ', '-', '(', ')', '+'], '', $model->phone);
                        $result = $sms->send_sms($phone, "$url\n", 0, 0, 0, 0, false, "maxsms=3");
                        if (!$sms->isSuccess($result)) {
                            Yii::$app->session->setFlash('error', "Возникла ошибка при отправке SMS сообщения на номер $model->phone : ".$sms->getError($result));
                        } 
                    }
                } else {
                    $order = new Order();
                    $order->client_id = $client->id;
                    $order->url_qrcode = strtoupper(substr(sha1(microtime(true)), 0, 16));
                    $order->url_activate = strtoupper(substr(sha1(microtime(true)), 0, 18));
                    $order->save();
                    $url = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http' . '://'.$_SERVER['HTTP_HOST'].'/qrcode/'.$order->url_qrcode;
                    $phone = str_replace([' ', '-', '(', ')', '+'], '', $model->phone);
                    $result = $sms->send_sms($phone, "$url\n", 0, 0, 0, 0, false, "maxsms=3");
                    if (!$sms->isSuccess($result)) {
                        Yii::$app->session->setFlash('error', "Возникла ошибка при отправке SMS сообщения на номер $model->phone : ".$sms->getError($result));
                    } 
                }
                return $this->redirect(['index']);
            }

        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!\Yii::$app->user->can('updateClient')) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        if (!\Yii::$app->user->can('deleteClient')) {
            throw new ForbiddenHttpException('Access denied');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
