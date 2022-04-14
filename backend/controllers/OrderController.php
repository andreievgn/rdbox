<?php

namespace backend\controllers;

use Yii;
use backend\models\Order;
use backend\models\SearchOrder;
use backend\models\OrderForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
             $this->layout = 'blank';
             return $this->redirect('site/login');
        }

        if (!\Yii::$app->user->can('indexOrder')) {
            throw new ForbiddenHttpException('Access denied');
        }

        $searchModel = new SearchOrder();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if (!\Yii::$app->user->can('viewOrder')) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionQrcode($url)
    {

        if (Yii::$app->user->isGuest) {
             $this->layout = 'blank';
        }

        $model = Order::find()->where(['url_qrcode' => $url])->one();

        return $this->render('qrcode', [
            'model' => $model,
        ]);
    }

    public function actionActivate($url)
    {

        if (!\Yii::$app->user->can('activateOrder')) {
            throw new ForbiddenHttpException('Access denied');
        }

        $order = Order::find()->where(['url_activate' => $url])->one();

        $orders = Order::find()->where(['client_id' => $order->client_id, 'visit' => true])->all();

        $form = new OrderForm();

        if($order){

            $form->getDiscount($orders);

            if($order->visit == true){
                return $this->render('message', [
                    'message' => Order::MESSAGE_ACTIVATED,
                ]);
            }

            if ($this->request->isPost) {
                $form->load($this->request->post());
                if($form->validate()){
                    $order->price = $form->finally_price;
                    $order->discount_price = $form->discount;
                    $order->visit = true;
                    $order->save();
                    return $this->render('message', [
                        'message' => Order::MESSAGE_ACTIVATE,
                    ]);
                } else{
                    return $this->render('activate', [
                        'order' => $order,
                        'model' => $form,
                    ]);
                }

                
            } 

            return $this->render('activate', [
                    'order' => $order,
                    'model' => $form,
                ]);           
        }

        return $this->render('message', [
                    'message' => Order::MESSAGE_NOQR,
                ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        if (!\Yii::$app->user->can('createOrder')) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = new Order();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (!\Yii::$app->user->can('updateOrder')) {
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
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        if (!\Yii::$app->user->can('deleteOrder')) {
            throw new ForbiddenHttpException('Access denied');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
