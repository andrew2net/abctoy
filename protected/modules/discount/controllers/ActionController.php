<?php

class ActionController extends Controller {

  /**
   * @return array action filters
   */
  public function filters() {
    return array(
      array('auth.filters.AuthFilter'), // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
    );
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id) {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    $model = new Action;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['Action'])) {
      $this->saveAction($model);
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

    if (isset($_POST['Action'])) {
      $this->saveAction($model);
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  private function saveAction(Action &$model) {

    $model->name = $_POST['Action']['name'];
    $old_file = Yii::getPathOfAlias('webroot') . $model->img;
    if ($_POST['Action']['img'] != $model->img) {
      if (strlen($_POST['Action']['img']) > 0) {
        $uploaded_file = Yii::getPathOfAlias('webroot') . $_POST['Action']['img'];
        if (file_exists($uploaded_file)) {
          if ($model->isNewRecord)
            $model->save();
          $ext = substr($_POST['Action']['img'], strrpos($_POST['Action']['img'], '.'));
          $file_name = Yii::getPathOfAlias('webroot') . '/images/action/' . $model->id . $ext;
          rename(Yii::getPathOfAlias('webroot') . $_POST['Action']['img'], $file_name);
        }
      }
      if (strlen($model->img) > 0 && file_exists($old_file))
        unlink($old_file);
      if (isset($file_name))
        $model->img = '/images/action/' . basename($file_name);
      else
        $model->img = '';
    }
    else
      $model->attributes = $_POST['Action'];
    if ($model->save())
      $this->redirect(array('index'));
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
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
    $dataProvider = new CActiveDataProvider('Action');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin() {
    $model = new Action('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Action'])) {
      $model->attributes = $_GET['Action'];
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Action the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = Action::model()->findByPk($id);
    if ($model === null) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Action $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'action-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionUpload() {
    $uploaddir = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
    $uploadfile = $uploaddir . Yii::app()->user->id . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
      echo '/uploads/temp/' . Yii::app()->user->id . $_FILES['file']['name'];
    }
    else {
      echo "Possible file upload attack!\n";
    }
  }

}