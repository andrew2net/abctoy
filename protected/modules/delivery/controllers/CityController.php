<?php

class CityController extends Controller {

  /**
   * @return array action filters
   */
  public function filters() {
    return array(
      array('auth.filters.AuthFilter'),
      'postOnly + delete', // we only allow deletion via POST request
    );
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    $model = new City;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['City'])) {
      $model->attributes = $_POST['City'];
      if ($model->save()) {
        $this->saveCityDelivery($model);
        $this->redirect(array('index'));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id) {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['City'])) {
      $model->attributes = $_POST['City'];
      if ($model->save()) {
        $this->saveCityDelivery($model);
        $this->redirect(array('index'));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  private function saveCityDelivery($model) {
    Yii::app()->db->createCommand()
        ->delete('store_city_delivery', 'city_id=:id', array(':id' => $model->id));
    if (isset($_POST['delivery']) && is_array($_POST['delivery']))
      foreach ($_POST['delivery'] as $key => $value) {
        $cityDelivery = new CityDelivery;
        $cityDelivery->city_id = $model->id;
        $cityDelivery->delivery_id = $key;
        $cityDelivery->price = $_POST['price'][$key];
        $cityDelivery->summ = $_POST['summ'][$key];
        $cityDelivery->save();
      }
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id) {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax'])) {
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      }
    }
    else {
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
  }

  /**
   * Lists all models.
   */
  public function actionIndex() {
    $dataProvider = new CActiveDataProvider('City');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    $model = new City('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['City'])) {
      $model->attributes = $_GET['City'];
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return City the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = City::model()->findByPk($id);
    if ($model === null) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param City $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'city-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionSuggestCity($term) {

    function formatArray($element) {
      return $element['name_ru'];
    }
    $city = strtr($term, array('%'=>'\%', '_'=>'\_'));
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

}