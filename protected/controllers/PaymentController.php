<?php

/**
 * Description of PaymentController
 *
 * @author 
 */
class PaymentController extends Controller {

  public $defaultAction = 'order';

  public function actionOrder($id) {
    if (Yii::app()->user->isGuest)
      $this->redirect('/profile');
    $order = Order::model()->with('profile')->findByPk($id, 'profile.user_id=:uid'
        , array(':uid' => Yii::app()->user->id));
  }

}
