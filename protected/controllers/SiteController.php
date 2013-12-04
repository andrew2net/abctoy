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

    $product = Product::model()->discountOrder()->recommended(15);
    $product_data = new CActiveDataProvider('Product'
        , array('criteria' => $product->getDbCriteria()));

    $this->render('index', array(
      'product' => $product_data,
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
  public function actionContact() {
    $model = new ContactForm;
    if (isset($_POST['ContactForm'])) {
      $model->attributes = $_POST['ContactForm'];
      if ($model->validate()) {
        $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
        $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
        $headers = "From: $name <{$model->email}>\r\n" .
            "Reply-To: {$model->email}\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/plain; charset=UTF-8";

        mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
        Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
        $this->refresh();
      }
    }
    $this->render('contact', array('model' => $model));
  }

  /**
   * Displays the login page
   */
  public function actionLogin() {
    $model = new LoginForm;

    // if it is ajax validation request
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }

    // collect user input data
    if (isset($_POST['LoginForm'])) {
      $model->attributes = $_POST['LoginForm'];
      // validate user input and redirect to the previous page if valid
      if ($model->validate() && $model->login())
        $this->redirect(Yii::app()->user->returnUrl);
    }
    // display the login form
    $this->render('login', array('model' => $model));
  }

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
    $product = Product::model()->subCategory($id)->discountOrder();
    if ($group->level == 1)
      $product->recommended(12);
    $product_data = new CActiveDataProvider('Product'
        , array('criteria' => $product->getDbCriteria()));

    $this->render('group', array(
      'product_data' => $product_data,
      'search' => $searc,
      'giftSelection' => $giftSelection,
      'groups' => $groups,
      'group' => $group,
    ));
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
    $this->render('product', array(
      'search' => $search,
      'groups' => $groups,
      'product' => $product,
      'productForm' => $productForm,
    ));
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

//    $product->discountOrder();
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
      $product->searchByName($_GET['Search']['text']);
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
    Yii::import('application.modules.payment.models.Payment');

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

    $order = new Order;
    if (isset($_POST['CustomerProfile'])) {
      $profile->attributes = $_POST['CustomerProfile'];
      if ($profile->save()) {
        $tr = $order->dbConnection->beginTransaction();
        try {
          if (isset($_POST['Cart'])) {
            $count_product = 0;
            foreach ($_POST['Cart'] as $q)
              $count_product += $q['quantity'] > 0 ? $q['quantity'] : 0;
            if ($count_product > 0) {
              $order->attributes = $_POST['Order'];
              $order->profile_id = $profile->id;
              $order->status_id = 0;
              $order->time = date('Y-m-d H:i:s');
              if ($order->save())
                foreach ($_POST['Cart'] as $key => $value) {
                  if ($value['quantity'] > 0) {
                    $order_product = new OrderProduct;
                    $order_product->order_id = $order->id;
                    $order_product->product_id = $key;
                    $order_product->quantity = $value['quantity'];
                    $product = Product::model()->findByPk($key);
                    $discount = $product->getActualDiscount();
                    if (is_array($discount))
                      $order_product->price = $discount['price'];
                    else
                      $order_product->price = $product->price;
                    $order_product->save();
                  }
                }
            }
            foreach ($cart as $item)
              $item->delete();
            $tr->commit();
          }
          $this->redirect('/');
        } catch (Exception $e) {
          $tr->rollback();
          throw $e;
        }
      }
    }
    $order->payment_id = 1;
    $delivery = Delivery::model()->getDeliveryList($profile->city);
    if (is_array($delivery))
      $order->delivery_id = key($delivery);
    else
      $order->delivery_id = 1;

    $payment = Payment::model()->getPaymentList();

//    $payments = array();
//    foreach ($payment as $value) {
//      $payments[$value->id] = '<span class="bold">';
//    }

    $this->render('shoppingCart', array(
      'cart' => $cart,
      'profile' => $profile,
      'order' => $order,
      'delivery' => $delivery,
      'payment' => $payment,
    ));
  }

  public function actionDelivery() {
    if (!isset($_GET['city'])) {
      echo '';
      Yii::app()->end();
    }
    Yii::import('application.modules.delivery.models.Delivery');
    $order = new Order;
    $delivery = Delivery::model()->getDeliveryList($_GET['city']);
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

  private function getSession() {
    if (!Yii::app()->user->isGuest)
      return '';

    if (isset(Yii::app()->request->cookies['cart']->value))
      $session_id = Yii::app()->request->cookies['cart']->value;
    else {
      $session_id = Yii::app()->session->sessionId;
      $cookie = new CHttpCookie('cart', $session_id);
      $cookie->expire = time() + 2592000;
      $cookie->httpOnly = TRUE;
      Yii::app()->request->cookies['cart'] = $cookie;
    }
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
    if (isset($_POST['id'])) {
      $carts = Cart::model()->cartItem($this->getSession(), $_POST['id'])->findAll();
      foreach ($carts as $cart) {
        $cart->delete();
      }
    }
    Yii::app()->end();
  }

}