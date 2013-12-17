<?php

class SiteController extends Controller {

  /**
   * Declares class-based actions.
   */
  public function actions() {
    return array(
      // captcha action renders the CAPTCHA image displayed on the contact page
      'captcha' => array(
        'class' => 'CCaptchaAction',
        'backColor' => 0xFFFFFF,
      ),
      // page action renders "static" pages stored under 'protected/views/site/pages'
      // They can be accessed via: index.php?r=site/page&view=FileName
      'page' => array(
        'class' => 'CViewAction',
      ),
    );
  }

  public function actionPage($url) {
    $searc = new Search;
    Yii::import('application.modules.admin.models.Page');
    $page = new Page();
    $model = $page->findByAttributes(array('url' => $url));
    Yii::import('application.modules.catalog.models.Category');
    $groups = Category::model()->findAll('level=1');
    if (!$model)
      throw new CHttpException(404, "Страница {$url} не найдена");
    $this->setPageTitle(Yii::app()->name . ' - ' . $model->title);
    $this->render('page', array(
      'model' => $model,
      'search' => $searc,
      'groups' => $groups,
        )
    );
  }

  /**
   * This is the default 'index' action that is invoked
   * when an action is not explicitly requested by users.
   */
  public function actionIndex() {
    Yii::import('application.modules.discount.models.Discount');
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Category');

    $searc = new Search;
    $giftSelection = new GiftSelection;
    $groups = Category::model()->roots()->findAll();

    $product = Product::model(); //->discountOrder();
//    $product_data = new CActiveDataProvider('Product'
//        , array('criteria' => $product->getDbCriteria()));

    $this->render('index', array(
      'product' => $product,
      'search' => $searc,
      'giftSelection' => $giftSelection,
      'groups' => $groups,
    ));
  }

  /**
   * This is the action to handle external exceptions.
   */
//  public function actionError() {
//    if ($error = Yii::app()->errorHandler->error) {
//      if (Yii::app()->request->isAjaxRequest)
//        echo $error['message'];
//      else
//        $this->render('error', $error);
//    }
//  }

  /**
   * Displays the contact page
   */
//  public function actionContact() {
//    $model = new ContactForm;
//    if (isset($_POST['ContactForm'])) {
//      $model->attributes = $_POST['ContactForm'];
//      if ($model->validate()) {
//        $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
//        $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
//        $headers = "From: $name <{$model->email}>\r\n" .
//            "Reply-To: {$model->email}\r\n" .
//            "MIME-Version: 1.0\r\n" .
//            "Content-Type: text/plain; charset=UTF-8";
//
//        mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
//        Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
//        $this->refresh();
//      }
//    }
//    $this->render('contact', array('model' => $model));
//  }

  /**
   * Displays the login page
   */
//  public function actionLogin() {
//    $model = new LoginForm;
//
//    // if it is ajax validation request
//    if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
//      echo CActiveForm::validate($model);
//      Yii::app()->end();
//    }
//
//    // collect user input data
//    if (isset($_POST['LoginForm'])) {
//      $model->attributes = $_POST['LoginForm'];
//      // validate user input and redirect to the previous page if valid
//      if ($model->validate() && $model->login())
//        $this->redirect(Yii::app()->user->returnUrl);
//    }
//    // display the login form
//    $this->render('login', array('model' => $model));
//  }

  /**
   * Logs out the current user and redirect to homepage.
   */
//  public function actionLogout() {
//    Yii::app()->user->logout();
//    $this->redirect(Yii::app()->homeUrl);
//  }

  public function actionGroup($id) {
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Category');
    Yii::import('application.modules.discount.models.Discount');

    $groups = Category::model()->roots()->findAll();
    $group = Category::model()->findByPk($id);
    $searc = new Search;
    $giftSelection = new GiftSelection;
    $product = Product::model();

    $params = array(
      'product' => $product,
      'search' => $searc,
      'giftSelection' => $giftSelection,
      'groups' => $groups,
      'group' => $group,
    );
    if (isset($_POST['currentPage']))
      $params['page'] = $_POST['currentPage'];

    $this->render('group', $params);
  }

  public function actionProduct($id) {
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Brand');
    Yii::import('application.modules.catalog.models.Category');

    $product = Product::model()->with('brand')->findByPk($id);
    $groups = Category::model()->roots()->findAll();
    $search = new Search;
    $productForm = new ProductForm;

    if (isset($_POST['ProductForm'])) {
      $this->addToCart($_GET['id'], $_POST['ProductForm']['quantity']);
      $this->redirect('/cart');
    }

    $params = array(
      'search' => $search,
      'groups' => $groups,
      'product' => $product,
      'productForm' => $productForm,
    );
    if (isset($_POST['currentPage']))
      $params['page'] = $_POST['currentPage'];
//    if (isset($_POST['currentCategory']))
//      $params['currentCategory'] = $_POST['currentCategory'];
    if (isset($_POST['url']))
      $params['url'] = $_POST['url'];

    $this->render('product', $params);
  }

  public function actionSort() {
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Category');
    Yii::import('application.modules.discount.models.Discount');

    $search = new Search;
    $giftSelection = new GiftSelection;
    $groups = Category::model()->roots()->findAll();
    $product = Product::model();

    if (isset($_GET['GiftSelection'])) {
      $product->sort($_GET['GiftSelection']);
      $giftSelection->attributes = $_GET['GiftSelection'];
    }

    $product_data = new CActiveDataProvider($product
        , array('pagination' => array('pageSize' => 20),
    ));

    $this->render('sort', array(
      'search' => $search,
      'giftSelection' => $giftSelection,
      'groups' => $groups,
      'product' => $product_data,
    ));
  }

  public function actionSearch() {
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Category');
    Yii::import('application.modules.discount.models.Discount');

    $search = new Search;
    $giftSelection = new GiftSelection;
    $groups = Category::model()->roots()->findAll();
    $product = Product::model();

    if (isset($_GET['Search'])) {
      $search->text = $_GET['Search']['text'];
      $product->searchByName($_GET['Search']['text']);
    }

    $product->discountOrder();
    $product_data = new CActiveDataProvider('Product'
        , array('criteria' => $product->getDbCriteria(),
      'pagination' => array('pageSize' => 20),
    ));

    $this->render('search', array(
      'search' => $search,
      'giftSelection' => $giftSelection,
      'groups' => $groups,
      'product' => $product_data,
    ));
  }

  public function actionBrand($id) {
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Category');
    Yii::import('application.modules.catalog.models.Brand');
    Yii::import('application.modules.discount.models.Discount');

    $search = new Search;
    $barnd = Brand::model()->findByPk($id);
    if (is_null($barnd))
      throw new CHttpException(404, "Страница " . Yii::app()->request->url . " не найдена");

    $giftSelection = new GiftSelection;
    $groups = Category::model()->roots()->findAll();
    $product = Product::model();
    $product->brandFilter($id)->discountOrder();
    $product_data = new CActiveDataProvider('Product'
        , array('criteria' => $product->getDbCriteria(),
      'pagination' => array('pageSize' => 20),
    ));

    $this->render('search', array(
      'search' => $search,
      'brand' => $barnd,
      'giftSelection' => $giftSelection,
      'groups' => $groups,
      'product' => $product_data,
    ));
  }

  public function actionAddToCart() {

    $this->addToCart($_POST['id'], $_POST['quantity']);
    echo $this->cartLabel();
    Yii::app()->end();
  }

  public function actionChangeCart() {

    $this->addToCart($_POST['id'], $_POST['quantity'], TRUE);
    echo ' ';
    Yii::app()->end();
  }

  private function addToCart($id, $quantity, $change = FALSE) {

    if (!is_numeric($quantity))
      return;

    if ($quantity < 0)
      return;

    $session_id = $this->getSession();

    $carts = Cart::model()->cartItem($session_id, $id)->findAll();
    if (isset($carts[0]))
      $cart = $carts[0];
    else {
      $cart = new Cart;
      if (Yii::app()->user->isGuest)
        $cart->session_id = $session_id;
      else
        $cart->user_id = Yii::app()->user->id;
      $cart->product_id = $id;
    }

    if ($change)
      $cart->quantity = $quantity;
    else
      $cart->quantity += $quantity;

    $cart->time = date('Y-m-d H:i:s');
    $cart->save();
  }

  public function cartLabel() {
    $quantity = Cart::model()->countProduct($this->getSession())->findAll();
    if (!$quantity[0]->quantity)
      return 'Козина пуста';

    $tovar = array(1, 21, 31, 41);
    $tovara = array(2, 3, 4, 22, 23, 24, 32, 33, 34, 42, 43, 44);
    $tovarSuffix = ' товаров';
    if (array_search($quantity[0]->quantity, $tovar) !== FALSE)
      $tovarSuffix = ' товар';
    elseif (array_search($quantity[0]->quantity, $tovara) !== FALSE)
      $tovarSuffix = ' товара';

    return 'В корзине ' . $quantity[0]->quantity . $tovarSuffix;
  }

  public function actionCart() {
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Brand');
    Yii::import('application.modules.delivery.models.Delivery');
    Yii::import('application.modules.delivery.models.CityDelivery');
    Yii::import('application.modules.delivery.models.City');
    Yii::import('application.modules.payment.models.Payment');
    Yii::import('application.modules.discount.models.Coupon');

    if (Yii::app()->user->isGuest)
      $profile = CustomerProfile::model()->findByAttributes(array(
        'session_id' => $this->getSession()));
    else
      $profile = CustomerProfile::model()->findByAttributes(array(
        'user_id' => Yii::app()->user->id));

    if (is_null($profile)) {
      $profile = new CustomerProfile;
      if (Yii::app()->user->isGuest)
        $profile->session_id = $this->getSession();
      else
        $profile->user_id = Yii::app()->user->id;
    }

    $cart = Cart::model()->shoppingCart($this->getSession())
            ->with('product.brand')->findAll();

    $coupon_data = array('code' => '', 'type' => '', 'value' => '');
    if (isset($_POST['coupon'])) {
      $coupon = Coupon::model()->findByAttributes(array(
        'code' => $_POST['coupon']), 'used_id<>2');
      if (!is_null($coupon))
        $coupon_data = array(
          'code' => $coupon->code,
          'type' => $coupon->type_id,
          'value' => $coupon->value
        );
    }

    $has_err = '';
    $order = new Order;
    if (isset($_POST['CustomerProfile'])) {
      $profile->attributes = $_POST['CustomerProfile'];
      if ($profile->save()) {
        $tr = $order->dbConnection->beginTransaction();
        if (isset($_POST['Cart'])) {
          $count_products = $this->countProducts();
          $coupon_discount = 0;
          if (!is_null($coupon)) {
            switch ($coupon->type_id) {
              case 0:
                $coupon_discount = $count_products['noDiscount'] > $coupon->value ?
                    $coupon->value : $count_products['noDiscount'];
                break;
              case 1:
                $coupon_discount = $count_products['noDiscount'] * $coupon->value / 100;
                break;
            }
            $count_products['summ'] -= $coupon_discount;
          }

          $fl = FALSE;
          if ($count_products['summ'] >= 1500) {
            try {
              if (count($cart) > 0) {
                $this->saveOrderProducts($order, $profile, $coupon);

                foreach ($cart as $item)
                  $item->delete();

                $this->sendConfirmOrderMessage($order, $profile, $coupon_discount);
              }
              $fl = TRUE;
              $tr->commit();
            } catch (Exception $e) {
              $tr->rollback();
              throw $e;
            }
            if ($fl) {
              if (Yii::app()->user->isGuest) {
                $user = User::model()->findByAttributes(array(
                  'email' => $profile->email));
                if (is_null($user)) {
                  $this->registerUser($profile);
                }
              }
              $this->redirect('orderSent');
            }
          }
        }
      }
      else
        $has_err = 'prof';
    }
    $order->payment_id = 1;
    $delivery = Delivery::model()->getDeliveryList($profile->city);
    if (is_array($delivery))
      $order->delivery_id = key($delivery);
    else
      $order->delivery_id = 1;

    $payment = Payment::model()->getPaymentList();

    $this->render('shoppingCart', array(
      'cart' => $cart,
      'profile' => $profile,
      'order' => $order,
      'delivery' => $delivery,
      'payment' => $payment,
      'coupon' => $coupon_data,
      'has_err' => $has_err,
    ));
  }

  private function countProducts() {
    $result = array('count' => 0, 'summ' => 0, 'noDiscount' => 0);
    foreach ($_POST['Cart'] as $k => $q) {
      $quantity = $q['quantity'] > 0 ? $q['quantity'] : 0;
      $result['count'] += $quantity;
      $product = Product::model()->findByPk($k);
      $discount = $product->getActualDiscount();
      if (is_array($discount))
        $price = $discount['price'];
      else {
        $price = $product->price;
        $result['noDiscount'] += $product->price * $quantity;
      }
      $result['summ'] += $quantity * $price;
    }
    return $result;
  }

  private function saveOrderProducts($order, $profile, $coupon) {
    $delivery = CityDelivery::model()->with('city')->findByAttributes(array(
      'delivery_id' => $_POST['Order']['delivery_id'])
        , 'city.name=:city', array(':city' => $profile->city));
    $delivery_summ = is_null($delivery) ? 0 : $delivery->price;

    $order->attributes = $_POST['Order'];
    $order->delivery_summ = $delivery_summ;
    $order->payment_id = 1;
    $order->profile_id = $profile->id;
    $order->fio = $profile->fio;
    $order->email = $profile->email;
    $order->phone = $profile->phone;
    $order->city = $profile->city;
    $order->address = $profile->address;
    $order->status_id = 0;
    $order->time = date('Y-m-d H:i:s');

    if (!is_null($coupon))
      $order->coupon_id = $coupon->id;

    if ($order->save()) {
      foreach ($_POST['Cart'] as $key => $value) {
        if ($value['quantity'] > 0) {
          $order_product = new OrderProduct;
          $order_product->order_id = $order->id;
          $order_product->product_id = $key;
          $order_product->quantity = $value['quantity'];
          $product = Product::model()->findByPk($key);
          $discount = $product->getActualDiscount();
          if (is_array($discount)) {
            $order_product->price = $discount['price'];
            $order_product->discount = $discount['discount'];
          }
          else {
            $order_product->price = $product->price;
            $order_product->discount = 0;
          }
          $order_product->save();
        }
      }
      if (!is_null($coupon)) {
        if ($coupon->used_id == 0) {
          $coupon->used_id = 2;
          $coupon->time_used = date('Y-m-d H:i:s');
          $coupon->update(array('used_id', 'time_used'));
        }
      }
    }
  }

  private function registerUser($profile) {
    $user = new User;
    $user->email = $profile->email;
    $user->usernameGenerator();
    $sourcePassword = $this->generate_password();
    $user->activkey = UserModule::encrypting(microtime() . $sourcePassword);
    $user->password = UserModule::encrypting($sourcePassword);
    $user->superuser = 0;
    $user->status = User::STATUS_ACTIVE;
    if ($user->save()) {
      $identity = new UserIdentity($user->username, $sourcePassword);
      if ($identity->authenticate()) {
        Yii::app()->user->login($identity, 3600 * 24 * 7);

        $profile->session_id = null;
        $profile->user_id = $user->id;
        $profile->update(array(
          'session_id',
          'user_id',
        ));

        $params = array(
          'profile' => $profile,
          'login' => $user->username,
          'passw' => $sourcePassword,
        );
        $message = new YiiMailMessage('Личный кабинет');
        $message->view = 'registrInfo';
        $message->setBody($params, 'text/html');
        $message->setFrom(Yii::app()->params['infoEmail']);
        $message->setTo(array($profile->email => $profile->fio));
        Yii::app()->mail->send($message);
      }
    }
  }

  private function sendConfirmOrderMessage($order, $profile, $coupon_discount = NULL) {
    $message = new YiiMailMessage('Ваш заказ');
    $message->view = 'confirmOrder';
    $params = array(
      'profile' => $profile,
      'order' => $order,
    );
    if ($coupon_discount > 0)
      $params['coupon_discount'] = $coupon_discount;
    $message->setBody($params, 'text/html');
    $message->setFrom(Yii::app()->params['infoEmail']);
    $message->setTo(array($profile->email => $profile->fio));
//              Yii::app()->mail->send($message);

    $message->setSubject('Оповещение о заказе');
    $message->view = 'notifyOrder';
    $message->setBody($params, 'text/html');
    $message->setTo(array(Yii::app()->params['adminEmail']));
//              Yii::app()->mail->send($message);
  }

  public function actionCheckEmail() {
    if (isset($_POST['email'])) {
      $user = User::model()->findByAttributes(array('email' => $_POST['email']));
      if (Yii::app()->user->isGuest) {
        if (is_null($user)) { //new user
          echo 'ok';
          Yii::app()->end();
        }
        else {                //need sign up
          echo '';
          Yii::app()->end();
        }
      }
      else {
        if (is_null($user)) { //new email
          Yii::app()->user->update(array('email' => $_POST['email']));
          echo 'ok';
          Yii::app()->end();
        }
        else if ($user->id != Yii::app()->user->id) { //there is user with same email
          echo '';
          Yii::app()->end();
        }
        else {               //signed up
          echo 'ok';
          Yii::app()->end();
        }
      }
    }
    Yii::app()->end();
  }

  public function actionCartLogin() {
    if (isset($_POST['email']) && isset($_POST['passw'])) {
      $user = User::model()->findByAttributes(array('email' => $_POST['email']));
      if (!is_null($user)) {
        $identity = new UserIdentity($user->username, $_POST['passw']);
        if ($identity->authenticate()) {
          $session_id = self::getSession();
          Yii::app()->user->login($identity, 3600 * 24 * 7);
          $cart = Cart::model()->findAllByAttributes(array(
            'session_id' => $session_id));
          foreach ($cart as $item) {
            $item->session_id = null;
            $item->user_id = $user->id;
            $item->update(array('session_id', 'user_id'));
          }
          echo 'ok';
          Yii::app()->end();
        }
      }
    }
    echo '';
    Yii::app()->end();
  }

  public function actionDelivery() {
    if (!isset($_GET['city'])) {
      echo '';
      Yii::app()->end();
    }
    Yii::import('application.modules.delivery.models.Delivery');
    $order = new Order;
    $delivery = Delivery::model()->getDeliveryList(trim($_GET['city']));
    if (is_array($delivery))
      $order->delivery_id = key($delivery);
    else
      $order->delivery_id = 1;

    echo $this->renderPartial('_delivery', array(
      'order' => $order,
      'delivery' => $delivery,
        ), TRUE);
    Yii::app()->end();
  }

  public static function getSession() {
    if (!Yii::app()->user->isGuest)
      return '';

    if (isset(Yii::app()->request->cookies['cart']->value))
      $session_id = Yii::app()->request->cookies['cart']->value;
    else {
      $session_id = Yii::app()->session->sessionId;
    }
    $cookie = new CHttpCookie('cart', $session_id);
    $cookie->expire = time() + 60 * 60 * 24 * 30;
    $cookie->httpOnly = TRUE;
    Yii::app()->request->cookies['cart'] = $cookie;
    return $session_id;
  }

  public function actionSuggestCity($term) {

    function formatArray($element) {
      return $element['name_ru'];
    }

    $city = strtr($term, array('%' => '\%', '_' => '\_'));
    $suggest_cities = Yii::app()->db->createCommand()
        ->select('name_ru')->from('net_city')
        ->where('name_ru LIKE :data', array(':data' => '%' . $term . '%'))->limit(20)
        ->group('name_ru')
        ->queryAll();
    if (is_array($suggest_cities))
      $suggest = array_map('formatArray', $suggest_cities);
    else
      $suggest = array();

    echo CJSON::encode($suggest);
    Yii::app()->end();
  }

  public function actionDelItemCart() {
    Yii::import('application.modules.catalog.models.Product');
    Yii::import('application.modules.catalog.models.Brand');

    if (isset($_POST['id'])) {
      $carts = Cart::model()->cartItem($this->getSession(), $_POST['id'])->findAll();
      foreach ($carts as $item) {
        $item->delete();
      }
      $cart = Cart::model()->shoppingCart($this->getSession())
              ->with('product.brand')->findAll();
      echo $this->renderPartial('_cartItems', array('cart' => $cart), TRUE);
    }
    Yii::app()->end();
  }

  public function actionOrderSent() {
    $this->render('orderSent');
  }

  public function actionCoupon() {
    if (isset($_GET['coupon'])) {
      Yii::import('application.modules.discount.models.Coupon');
      $coupon = Coupon::model()->findByAttributes(array(
        'code' => $_GET['coupon']), 'used_id<>2');
      if (is_null($coupon))
        $data = array('type' => 3, 'discount' => 0);
      else
        $data = array('type' => $coupon->type_id, 'discount' => $coupon->value);
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  private function generate_password($length = '') {
    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_0123456789';
    $max = strlen($str);
    $length = @round($length);
    if (empty($length)) {
      $length = rand(6, 8);
    }
    $password = '';
    for ($i = 0; $i < $length; $i++) {
      $password.=$str{rand(0, $max - 1)};
    }
    return $password;
  }

}