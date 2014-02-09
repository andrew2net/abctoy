<?php

class SiteController extends Controller {

  /**
   * Declares class-based actions.
   */
//  public function actions() {
//    return array(
//      // captcha action renders the CAPTCHA image displayed on the contact page
//      'captcha' => array(
//        'class' => 'CCaptchaAction',
//        'backColor' => 0xFFFFFF,
//      ),
//      // page action renders "static" pages stored under 'protected/views/site/pages'
//      // They can be accessed via: index.php?r=site/page&view=FileName
//      'page' => array(
//        'class' => 'CViewAction',
//      ),
//    );
//  }

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

    if (!Yii::app()->user->isGuest)
      Yii::app()->request->cookies['popup'] = new CHttpCookie('popup', '2', array(
        'expire' => time() + 2592000,
        'path' => '/',
      ));

    $searc = new Search;
    $giftSelection = new GiftSelection;
    $groups = Category::model()->roots()->findAll();

    $product = Product::model();

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
  public function actionError() {
    if ($error = Yii::app()->errorHandler->error) {
      if (Yii::app()->request->isAjaxRequest)
        echo $error['message'];
      else
        $this->render('error', $error);
    }
  }

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
  public function actionLogout() {
    Yii::app()->user->logout();
    $this->redirect(Yii::app()->homeUrl);
  }

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

  /**
   * Add or update shopping cart
   * @param type $id
   * @param type $quantity
   * @param type $change true if it's update, not add new item
   * @return type
   */
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

  /**
   * Return text for shoppingcart link label
   * @return string
   */
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
    Yii::import('application.modules.payments.models.Payment');
    Yii::import('application.modules.discount.models.Coupon');

    $profile = $this->getProfile();
    $cart = Cart::model()->shoppingCart($this->getSession())
            ->with('product.brand')->findAll();

    $coupon_data = array('code' => '', 'type' => '', 'value' => '');
    if (isset($_POST['coupon'])) {
      $coupon = Coupon::model()->findByAttributes(array(
        'code' => $_POST['coupon'])
          , "used_id<>2 AND (date_limit>=:date OR date_limit IS NULL OR date_limit='0000-00-00')"
          , array(':date' => date('Y-m-d')));
      if ($coupon)
        $coupon_data = array(
          'code' => $coupon->code,
          'type' => $coupon->type_id,
          'value' => $coupon->value
        );
    }

    $has_err = '';
    $order = new Order;

    $order->payment_id = 1;
    $delivery = Delivery::model()->getDeliveryList($profile->city);
    if (is_array($delivery))
      $order->delivery_id = key($delivery);
    else
      $order->delivery_id = 1;

    $payment = Payment::model()->getPaymentList();

    if (isset($_POST['CustomerProfile'])) {
      $profile->attributes = $_POST['CustomerProfile'];
      if (isset($_POST['Order']))
        $order->attributes = $_POST['Order'];
      if ($profile->save()) {
        if (Yii::app()->user->isGuest) {
          $user = User::model()->findByAttributes(array(
            'email' => $profile->email));
          if (is_null($user)) {
            $this->registerUser($profile);
          }
        }
        if (isset($_POST['Cart'])) {
          $count_products = $this->countProducts($coupon);
          $count_products['summ'] -= $count_products['couponDisc'];

          $fl = FALSE;
          if ($count_products['summ'] >= 700) {
            $tr = $order->dbConnection->beginTransaction();
            try {
              if (count($cart) > 0) {
                $this->saveOrderProducts($order, $profile, $coupon, $count_products['summ']);

                foreach ($cart as $item)
                  $item->delete();
                $fl = TRUE;
              }
              $tr->commit();
            } catch (Exception $e) {
              $tr->rollback();
              throw $e;
            }
            if ($fl) {
              $this->sendConfirmOrderMessage($order, $profile, $count_products['couponDisc']);
              $this->redirect('orderSent');
            }
          }
        }
      }
      else
        $has_err = 'prof';
    }

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

  public static function getProfile() {
    if (Yii::app()->user->isGuest)
      $profile = CustomerProfile::model()->findByAttributes(array(
        'session_id' => self::getSession()));
    else
      $profile = CustomerProfile::model()->findByAttributes(array(
        'user_id' => Yii::app()->user->id));

    if (is_null($profile)) {
      $profile = new CustomerProfile;
      if (Yii::app()->user->isGuest)
        $profile->session_id = self::getSession();
      else
        $profile->user_id = Yii::app()->user->id;
    }

    if (empty($profile->city)) {
      $req = new CHttpRequest;
      $ip = $req->userHostAddress;
      $int = sprintf("%u", ip2long($ip));
      $ru_data = Yii::app()->db->createCommand("select * from (select * from net_ru where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int")->query();
      if ($row = $ru_data->read()) {
        $city_id = $row['city_id'];
        $ru_city = Yii::app()->db->createCommand("select * from net_city where id='$city_id'")->query();
        if ($city = $ru_city->read())
          $profile->city = $city['name_ru'];
      }
      if (empty($profile->city)) {
        $glob_data = Yii::app()->db->createCommand("select * from (select * from net_city_ip where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int")->query();
        if ($row = $glob_data->read()) {
          $city_id = $row['city_id'];
          $glob_city = Yii::app()->db->createCommand("select * from net_city where id='$city_id'")->query();
          if ($city = $glob_city->read())
            $profile->city = $city['name_ru'];
        }
      }
    }
    return $profile;
  }

  private function countProducts($coupon) {
    $result = array('count' => 0,
      'summ' => 0,
      'noDiscount' => 0,
      'discount' => 0,
      'couponDisc' => 0
    );
    foreach ($_POST['Cart'] as $k => $q) {
      $quantity = $q['quantity'] > 0 ? $q['quantity'] : 0;
      $result['count'] += $quantity;
      $product = Product::model()->findByPk($k);
      $discount = $product->getActualDiscount();
      if (is_array($discount)) {
        $price = $discount['price'];
        $result['discount'] += ($product->price - $price) * $quantity;
      }
      else {
        $price = $product->price;
        $result['noDiscount'] += $product->price * $quantity;
        if ($coupon) {
          if ($coupon->type_id)
            $result['couponDisc'] += $price * $quantity * $coupon->value / 100;
          else
            $result['couponDisc'] += $price * $quantity;
        }
      }
      $result['summ'] += $quantity * $price;
    }
    if ($coupon && !$coupon->type_id)
      if ($result['summ'] < 1800)
        $result['couponDisc'] = 0;
      else if ($coupon->value < $result['couponDisc'])
        $result['couponDisc'] = $coupon->value;
    return $result;
  }

  private function saveOrderProducts($order, $profile, $coupon, $product_summ) {
    $delivery = CityDelivery::model()->with('city')->findByAttributes(array(
      'delivery_id' => $_POST['Order']['delivery_id'])
        , 'city.name=:city', array(':city' => $profile->city));
    if ($delivery && $delivery->summ > $product_summ) 
      $delivery_summ = $delivery->price;
    else 
      $delivery_summ = 0;

    $order->attributes = $_POST['Order'];
    $order->delivery_summ = $delivery_summ;
    $order->profile_id = $profile->id;
    $order->fio = $profile->fio;
    $order->email = $profile->email;
    $order->phone = $profile->phone;
    $order->city = $profile->city;
    $order->address = $profile->address;
    $order->status_id = 0;
    $order->time = date('Y-m-d H:i:s');

    if ($coupon)
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
            $order_product->discount = $product->price - $discount['price'];
          }
          else {
            $order_product->price = $product->price;
            $order_product->discount = 0;
          }
          $order_product->save();
        }
      }
      if ($coupon) {
        if ($coupon->used_id == 0) {
          $command = Yii::app()->db->createCommand();
          $command->update('store_coupon', array(
            'used_id' => 2,
            'time_used' => date('Y-m-d H:i:s'),
              ), 'id=:id', array(':id' => $coupon->id));
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
    $user->lastvisit = time();
    $user->status = User::STATUS_ACTIVE;
    if ($user->save()) {
      $user_prof = new Profile;
      $user_prof->user_id = $user->id;
      $user_prof->save();
      $identity = new UserIdentity($user->username, $sourcePassword);
      if ($identity->authenticate()) {
        Yii::app()->user->login($identity, 3600 * 24 * 7);

        $cart = Cart::model()->findAllByAttributes(array('session_id' => $profile->session_id));
        foreach ($cart as $item) {
          $item->session_id = NULL;
          $item->user_id = Yii::app()->user->id;
          $item->update(array('session_id', 'user_id'));
        }

        $profile->session_id = null;
        $profile->user_id = $user->id;
        $profile->update(array(
          'session_id',
          'user_id',
        ));

        $params = array(
          'profile' => $profile,
          'login' => $user->email,
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
    Yii::app()->mail->send($message);

    $message->setSubject('Оповещение о заказе');
    $message->view = 'notifyOrder';
    $message->setBody($params, 'text/html');
    $message->setTo(array(Yii::app()->params['adminEmail']));
    Yii::app()->mail->send($message);
  }

  public function actionRegistr() {
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $user = User::model()->findByAttributes(array('email' => $_POST['email']));
      if ($user)
        echo json_encode(array('result' => false, 'msg' => 'Пользователь с таким адресом уже зарегистрирован'));
      else {
        $session_id = '';
        if (!Yii::app()->user->isGuest)
          Yii::app()->user - logOut();
        else
          $session_id = $this->getSession();

        $profile = CustomerProfile::model()->findByAttributes(array('email' => $_POST['email']));
        if (is_null($profile))
          $profile = new CustomerProfile;
        $profile->email = $_POST['email'];
        $profile->session_id = $session_id;
        $profile->save(FALSE);
        $this->registerUser($profile);
        echo json_encode(array('result' => true));
      }
    }
    else
      echo json_encode(array('result' => false, 'msg' => 'Адрес задан неверно'));
    Yii::app()->end();
  }

  public function actionCheckEmail() {
    if (isset($_POST['email'])) {
      $user = User::model()->findByAttributes(array('email' => $_POST['email']));
      if (Yii::app()->user->isGuest)
        if (is_null($user))  //new user
          echo 'ok';
        else                 //need sign up
          echo '';
      else {
        if (is_null($user)) { //new email
          Yii::app()->user->update(array('email' => $_POST['email']));
          echo 'ok';
        }
        else if ($user->id != Yii::app()->user->id)  //there is user with same email
          echo '';
        else                //signed up
          echo 'ok';
      }
    }
    else
      echo 'ok';
    Yii::app()->end();
  }

  public function actionLogin() {
    $loginForm = new LoginForm;

    if ((isset($_POST['email']) || isset($_POST['login'])) && isset($_POST['passw']) ||
        isset($_POST['LoginForm'])) {
      if (isset($_POST['email']))
        $user = User::model()->findByAttributes(array('email' => $_POST['email']));
      else if (isset($_POST['login'])) {
        $user = User::model()->findByAttributes(array('username' => $_POST['login']));
        if (is_null($user))
          $user = User::model()->findByAttributes(array('email' => $_POST['login']));
      } elseif (isset($_POST['LoginForm'])) {
        $loginForm->attributes = $_POST['LoginForm'];
        if ($loginForm->validate()) {
          $user = User::model()->findByAttributes(array(
            'username' => $_POST['LoginForm']['username']
          ));
          if (is_null($user))
            $user = User::model()->findByAttributes(array(
              'email' => $_POST['LoginForm']['username']
            ));
        }
      }
      if (isset($user) && !is_null($user)) {
        if (isset($_POST['LoginForm']))
          $password = $_POST['LoginForm']['password'];
        else
          $password = $_POST['passw'];
        $identity = new UserIdentity($user->username, $password);
        if ($identity->authenticate()) {
          $user->lastvisit = time();
          $user->save();
          $session_id = self::getSession();
          Yii::app()->user->login($identity, 3600 * 24 * 7);
          if (isset($_POST['email'])) { //if login from shopping cart move items to profile
            $old_cart = Cart::model()->findAllByAttributes(array(
              'session_id' => $session_id));
            if (count($old_cart) > 0) {
              $cart = Cart::model()->findAllByAttributes(array('user_id' => $user->id));
              foreach ($cart as $item) {
                $item->delete();
              }
              foreach ($old_cart as $item) {
                $item->session_id = null;
                $item->user_id = $user->id;
                $item->update(array('session_id', 'user_id'));
              }
            }
            echo 'ok';
          }
          elseif (isset($_POST['login'])) {
            echo json_encode(array('result' => TRUE, 'cart' => $this->cartLabel()));
          }
          else
            $this->redirect('profile');
          Yii::app()->end();
        }
      }
      //ajax return false if not login
      if (isset($_POST['login'])) { //if login was from main page
        echo json_encode(array('result' => FALSE));
        Yii::app()->end();
      }
      else if (isset($_POST['email'])) { //if login from shopping cart
        echo '';
        Yii::app()->end();
      }
    }

    $this->render('login', array('loginForm' => $loginForm));
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
        'code' => $_GET['coupon']), "used_id<>2 AND (date_limit>=:date OR date_limit IS NULL OR date_limit='0000-00-00')"
          , array(':date' => date('Y-m-d')));
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

  public function actionProfile() {
    Yii::import('application.modules.discount.models.Coupon');
    Yii::import('application.modules.payments.models.Payment');
    if (Yii::app()->user->isGuest)
      $this->redirect('/login');

    $profile = CustomerProfile::model()->findByAttributes(
        array('user_id' => Yii::app()->user->id));
    if (is_null($profile)) {
      $profile = new CustomerProfile;
      if (!Yii::app()->user->isGuest) {
        $profile->user_id = Yii::app()->user->id;
        $profile->email = User::model()->findByPk(Yii::app()->user->id)->email;
        $profile->save(false);
      }
    }

    $new_passw = new NewPassword;
    $child = new Child;

    if (isset($_POST['CustomerProfile'])) {
      $profile->attributes = $_POST['CustomerProfile'];
      $user = User::model()->findByPk(Yii::app()->user->id);
      $valid = TRUE;
      if ($user->email != $_POST['CustomerProfile']['email']) {
        $user->email = $_POST['CustomerProfile']['email'];
        if (!$user->save()) {
          Yii::app()->user->setFlash('newEmail', "Есть другой пользователь с таким E-mail");
          $valid = FALSE;
        }
      }
      if ($valid) {
        if ($profile->save())
          Yii::app()->user->setFlash('saveProfile', "Контактная информация обновлена");
      }
      if (isset($_POST['NewPassword'])) {
        $new_passw->attributes = $_POST['NewPassword'];
        if ($new_passw->validate()) {
          if (strlen($new_passw->passw1) > 0) {
            $new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
            $new_password->password = UserModule::encrypting($new_passw->passw1);
            $new_password->activkey = UserModule::encrypting(microtime() . $new_passw->passw1);
            if ($new_password->save()) {
              Yii::app()->user->setFlash('newPassw', "Новый пароль сохранен.");
              $new_passw->passw1 = '';
              $new_passw->passw2 = '';
            }
          }
        }
      }
    }

    $order = new CActiveDataProvider('Order', array(
      'criteria' => array(
        'condition' => 'profile_id = :profile_id',
        'params' => array(':profile_id' => $profile->id),
        'with' => array(
          'orderProducts' => array('alias' => 'p'),
          'coupon' => array('alias' => 'c'),
          'payment'
        ),
        'together' => TRUE,
        'select' => array(
          'id',
          'time',
          'delivery_summ',
          'SUM(p.price*p.quantity) AS summ',
          'status_id'
        ),
        'group' => 't.id, t.time, t.status_id',
        'order' => 't.time DESC'
      ),
      'pagination' => array(
        'pagesize' => 6
      )
    ));

    $this->render('profile', array(
      'profile' => $profile,
      'order' => $order,
      'new_passw' => $new_passw,
      'child' => $child,
    ));
  }

  public function actionUpdateChild() {
    if (isset($_POST['id'])) {
      $profile = CustomerProfile::model()->findByAttributes(array(
        'user_id' => Yii::app()->user->id
      ));
      $child = Child::model()->findByPk($_POST['id'], 'profile_id=:id'
          , array(':id' => $profile->id));
      if (is_null($child))
        $child = new Child;
      $child->profile_id = $profile->id;
      if (isset($_POST['gender']))
        $child->gender_id = $_POST['gender'];
      $child->birthday = $_POST['birthday'];
      $child->name = $_POST['name'];
      if ($child->save()) {
        $child->afterFind();
        echo json_encode(array(
          'result' => TRUE,
          'html' => $this->renderPartial('_childUpdate', array('child' => $child), true)
        ));
      }
      else {
        $child->refresh();
        if ($_POST['id'] == 0)
          $output = $this->renderPartial('_childAdd', array('child' => $child), TRUE);
        else
          $output = $this->renderPartial('_childUpdate', array('child' => $child), TRUE);
        echo json_encode(array(
          'result' => FALSE,
          'html' => $output,
        ));
      }
    }
    Yii::app()->end();
  }

  public function actionDelChild() {
    if (isset($_POST['id'])) {
      $child = Child::model()->with('profile')->findByPk($_POST['id']
          , array(
        'condition' => 'profile.user_id=:uid',
        'params' => array(':uid' => Yii::app()->user->id)
          )
      );
      echo ($child && $child->delete());
    }
    Yii::app()->end();
  }

  public function actionPopupWindow() {
    $children = array();
    $popup_form = new PopupForm();

    if (isset($_POST['children'])) {
      if (!Yii::app()->user->isGuest) {
        echo json_encode(array(
          'result' => 'exist',
          'html' => $this->renderPartial('_popupIsLogin', array(), TRUE),
        ));
        Yii::app()->end();
      }
      $valid = TRUE;
      if (isset($_POST['PopupForm'])) {
        $user = User::model()->findByAttributes(array(
          'email' => $_POST['PopupForm']['email']
        ));
        if ($user) {
          echo json_encode(array(
            'result' => 'exist',
            'html' => $this->renderPartial('_popupEmailExist', array(
              'email' => $_POST['PopupForm']['email'],
                ), TRUE),
          ));
          Yii::app()->end();
        }
        $popup_form->attributes = $_POST['PopupForm'];
        $valid = $popup_form->validate() && $valid;
      }
      foreach ($_POST['children'] as $id => $value) {
        $child = new Child('popup');
        $child->attributes = $value;
        $valid = $child->validate() && $valid;
        $children[] = $child;
      }
      if ($valid) {
        $tr = Yii::app()->db->beginTransaction();
        try {
          $profile = CustomerProfile::model()->findByAttributes(array(
            'email' => $_POST['PopupForm']['email']
          ));
          if (is_null($profile)) {
            $profile = new CustomerProfile;
            $profile->email = $_POST['PopupForm']['email'];
            $profile->save(FALSE);
          }
          foreach ($_POST['children'] as $id => $value) {
            $child = new Child;
            $child->attributes = $value;
            $child->profile_id = $profile->id;
            $child->save();
          }
          $this->registerUser($profile);
          $tr->commit();
          Yii::import('application.modules.discount.models.Coupon');
          $coupon = new Coupon;
          $coupon->generateCode();
          $coupon->type_id = 0;
          $coupon->value = 400;
          $coupon->used_id = 0;
          $coupon->date_limit = date('d.m.Y', strtotime('+3 days'));
          if ($coupon->save()) {
            $message = new YiiMailMessage('Купон со скидкой');
            $message->view = 'coupon';
            $params = array(
              'profile' => $profile,
              'coupon' => $coupon,
            );
            $message->setBody($params, 'text/html');
            $message->setFrom(Yii::app()->params['infoEmail']);
            $message->setTo(array($profile->email => $profile->fio));
            Yii::app()->mail->send($message);
          }
          echo json_encode(array(
            'result' => 'register',
            'html' => $this->renderPartial('_popupRegister', NULL, TRUE),
          ));
          Yii::app()->end();
        } catch (Exception $e) {
          $tr->rollback();
        }
      }
      $par = array(
        'children' => $children,
        'popup_form' => $popup_form,
      );
      if (isset($_POST['suff']) && $_POST['suff'] != 0)
        $par['suff'] = $_POST['suff'];
      echo json_encode(array(
        'result' => 'error',
        'html' => $this->renderPartial('_popupForm', $par, TRUE)));
      Yii::app()->end();
    }
    else
      $children[] = new Child('popup');

    $this->renderPartial('_popupWindow', array(
      'children' => $children,
      'popup_form' => $popup_form,
    ));
  }

  public function actionSaveCity() {
    if (isset($_POST['city'])) {
      $profile = $this->getProfile();
      $profile->city = $_POST['city'];
      $profile->save(FALSE);
    }
    Yii::app()->end();
  }

}