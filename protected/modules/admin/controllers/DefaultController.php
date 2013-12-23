<?php

class DefaultController extends Controller {

  public function filters() {
    return array(
      array('auth.filters.AuthFilter'),
    );
  }

  public function actionIndex() {
    $model = new Order('search');
    $model->unsetAttributes();

    if (isset($_GET['Order']))
      $model->attributes = $_GET['Order'];

    $this->render('index', array('model' => $model));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id) {
    Yii::import('application.modules.delivery.models.Delivery');
    Yii::import('application.modules.payment.models.Payment');
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.discount.models.Coupon');

    $model = $this->loadModel($id);
    $product = OrderProduct::model()->with(array('product'))
        ->findAllByAttributes(array('order_id' => $model->id));

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['Order'])) {
      $old_status = $model->status_id;
      $model->attributes = $_POST['Order'];
      $tr = Yii::app()->db->beginTransaction();
      try {
        if ($model->save()) {
          foreach ($_POST['OrderProduct'] as $id => $value) {
            $order_product = OrderProduct::model()->findByPk(array(
              'order_id' => $model->id,
              'product_id' => $id));
            if (!is_null($order_product)) {
              $order_product->quantity = $value['quantity'] > 0 ? $value['quantity'] : 0;
              $order_product->price = $value['price'] > 0 ? $value['price'] : 0;
              $order_product->save();
            }
          }
          if ($old_status != $model->status_id) {
            $profile = CustomerProfile::model()->findByPk($model->profile_id);
            $message = new YiiMailMessage;
            $message->view = 'processOrder';
            $message->setFrom(Yii::app()->params['infoEmail']);
            $message->setTo(array($profile->email => $profile->fio));
            $params = array(
              'profile' => $profile,
              'order' => $model,
            );
            switch ($model->status_id) {
              case 5:
                $message->setSubject("Отмена заказа");
                $params['text'] = 'отменен';
                $message->setBody($params, 'text/html');
                Yii::app()->mail->send($message);
                break;
            }
          }
          $tr->commit();
          $this->redirect(array('index'));
        }
      } catch (Exception $e) {
        $tr->rollback();
        throw $e;
      }
    }

    if ($model->status_id == 0)
      $model->status_id = 1;

    $this->render('update', array(
      'model' => $model,
      'product' => $product,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Order the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    Yii::import('application.modules.discount.models.Coupon');
    $model = Order::model()->with(array('coupon'))->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

}