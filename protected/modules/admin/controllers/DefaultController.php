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
    $order_product = $model->orderProducts;
    $product = array();
    foreach ($order_product as $key => $value)
      $product[$key] = $value->product;
    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['Order'])) {
      $old_status = $model->status_id;
      $model->attributes = $_POST['Order'];
      $valid = $model->validate();
      $order_product = array();
      $product = array();
      foreach ($_POST['OrderProduct'] as $key => $value) {
        $order_product[$key] = new OrderProduct;
        $order_product[$key]->attributes = $value;
        $order_product[$key]->order_id = $id;
        $product[$key] = Product::model()->findByAttributes(array(
          'article' => $_POST['Product'][$key]['article']));
        if ($product[$key])
          $order_product[$key]->product_id = $product[$key]->id;
        else
          $product[$key] = new Product;
        $valid = $order_product[$key]->validate() && $valid;
        $valid = $product[$key] && $valid;
//              if ($order_product) {
//                $order_product->quantity = $value['quantity'] > 0 ? $value['quantity'] : 0;
//                $order_product->price = $value['price'] > 0 ? $value['price'] : 0;
//                $order_product->save();
//              }
//          }
//          else {
//            Yii::app()->user->setFlash('error', 'Товар не найден');
//          }
      }
      if ($valid) {
        $tr = Yii::app()->db->beginTransaction();
        try {
          if ($model->save()) {
//        foreach ($model->orderProducts as $value)
            OrderProduct::model()->deleteAllByAttributes(array('order_id' => $model->id));
            foreach ($order_product as $value) {
              $item = new OrderProduct;
              $item->attributes = $value->attributes;
              $disc = $item->product->getActualDiscount();
              if ($disc)
                $item->discount = $disc['discount'];
              else
                $item->discount = 0;
              $item->save();
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
          }
          $tr->commit();
          $this->redirect(array('index'));
        } catch (Exception $e) {
          $tr->rollback();
          throw $e;
        }
      }
    }

    if ($model->status_id == 0)
      $model->status_id = 1;

    $this->render('update', array(
      'model' => $model,
      'order_product' => $order_product,
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

  public function actionOrderProduct($term) {
    Yii::import('application.modules.catalog.models.Product');
    $product = strtr($term, array('%' => '\%', '_' => '\_'));
    $criteria = new CDbCriteria(array(
      'select' => 'id, name, article, price',
      'condition' => 'name LIKE :data OR article LIKE :data',
      'params' => array(':data' => '%' . $product . '%'),
      'limit' => 20,
    ));
    $suggest = Product::model()->findAll($criteria);

    $products = array();
    foreach ($suggest as $value) {
      $discount = $value->getActualDiscount();
      if ($discount) {
        $price = $discount['price'];
        $disc = $discount['discount'];
      }
      else {
        $price = $value->price;
        $disc = 0;
      }
      $products[] = array(
        'article' => $value->article,
        'value' => $value->name,
        'price' => $price,
        'disc' => $disc,
      );
    }
    echo CJSON::encode($products);
    Yii::app()->end();
  }

}