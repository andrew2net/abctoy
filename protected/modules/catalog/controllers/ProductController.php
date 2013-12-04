<?php

class ProductController extends Controller {

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
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    $model = new Product;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['Product'])) {
      $this->saveProduct($model);
    }

    $model->gender_id = 0;
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

    if (isset($_POST['Product'])) {
      $this->saveProduct($model);
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  private function saveProduct(Product &$model) {

    $model->attributes = $_POST['Product'];

    $this->moveImg($model, 'img');
    $this->moveImg($model, 'small_img');

    if ($model->save()) {
      $command = Yii::app()->db->createCommand();
      $command->delete('store_product_category', 'product_id=:id'
          , array(':id' => $model->id));
      if (isset($_POST['Categories']))
        foreach ($_POST['Categories'] as $key => $value) {
          $command->insert('store_product_category', array(
            'product_id' => $model->id,
            'category_id' => $key,
              )
          );
        }
      $this->redirect(array('index'));
    }
  }

  private function moveImg(Product $model, $img) {
    $old_file = Yii::getPathOfAlias('webroot') . $model->$img;
    $old_img = $model->$img;
    $model->$img = $_POST['Product'][$img];
    if ($_POST['Product'][$img] != $old_img) {
      if (strlen($_POST['Product'][$img]) > 0) {
        $uploaded_file = Yii::getPathOfAlias('webroot') . $_POST['Product'][$img];
        if (file_exists($uploaded_file)) {
          if ($model->isNewRecord)
            if (!$model->save())
              return;
          $ext = substr($_POST['Product'][$img], strrpos($_POST['Product'][$img], '.'));
          $img_name = $model->id . ($img == 'img' ? '' : 's') . $ext;
          $file_name = Yii::getPathOfAlias('webroot') . '/productimages/' . $img_name;
          rename(Yii::getPathOfAlias('webroot') . $_POST['Product'][$img], $file_name);
        }
      }
      if (strlen($old_img) > 0 && file_exists($old_file))
        unlink($old_file);
      if (isset($file_name))
        $model->$img = '/productimages/' . basename($file_name);
      else
        $model->$img = '';
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
    $importData = new ImportFile;
    $model = new Product('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['Product'])) {
      $model->attributes = $_GET['Product'];
    }
    if (isset($_POST['ImportFile']) && !empty($_POST['ImportFile']['importFile'])) {
      Yii::import('application.Excel.reader');
      $importData->attributes = $_POST['ImportFile'];
      $importData->importFile = CUploadedFile::getInstance($importData, 'importFile');
      $importData->importFile->saveAs('uploads/temp/product.xls');
      $data = new Spreadsheet_Excel_Reader();
      $data->setOutputEncoding('CP1251');
      $data->read('uploads/temp/product.xls');
    }
    $this->render('index', array(
      'model' => $model,
      'importData' => $importData,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer $id the ID of the model to be loaded
   * @return Product the loaded model
   * @throws CHttpException
   */
  public function loadModel($id) {
    $model = Product::model()->findByPk($id);
    if ($model === null) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param Product $model the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionUpload() {
    if (isset($_FILES['file'])) {
      $file = $_FILES['file'];
      $prefix = Yii::app()->user->id;
    }
    elseif (isset($_FILES['fileMini'])) {
      $file = $_FILES['fileMini'];
      $prefix = Yii::app()->user->id . 's';
    }
    else {
      echo "Possible file upload attack!\n";
      Yii::app()->end();
    }
    $uploaddir = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'uploads'
        . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
    $uploadfile = $uploaddir . $prefix . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
      echo '/uploads/temp/' . $prefix . $file['name'];
    }
    else {
      echo "Possible file upload attack!\n";
    }
    Yii::app()->end();
  }

  public function actionProductUpload() {
    $importData = new ImportFile;
    if (isset($_POST['ImportFile'])) {
      require_once (Yii::getPathOfAlias('ext.Excel') . '/excel_reader2.php');
      $importData->attributes = $_POST['ImportFile'];
      $importData->productFile = CUploadedFile::getInstance($importData, 'productFile');
      $importFilePath = Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR .
          $_FILES['ImportFile']['name']['productFile'];
      $importData->productFile->saveAs($importFilePath);
      $data = new Spreadsheet_Excel_Reader($importFilePath, FALSE);
      $sheet = 0;
      $rows = $data->rowcount($sheet);
      $rows = 2091;
      $productImagePath = Yii::getPathOfAlias('webroot.productimages') .
          DIRECTORY_SEPARATOR;
      $quotes = array(
        "\xC2\xAB" => '"', // « (U+00AB) in UTF-8
        "\xC2\xBB" => '"', // » (U+00BB) in UTF-8
        "\xE2\x80\x98" => "'", // ‘ (U+2018) in UTF-8
        "\xE2\x80\x99" => "'", // ’ (U+2019) in UTF-8
        "\xE2\x80\x9A" => "'", // ‚ (U+201A) in UTF-8
        "\xE2\x80\x9B" => "'", // ‛ (U+201B) in UTF-8
        "\xE2\x80\x9C" => '"', // “ (U+201C) in UTF-8
        "\xE2\x80\x9D" => '"', // ” (U+201D) in UTF-8
        "\xE2\x80\x9E" => '"', // „ (U+201E) in UTF-8
        "\xE2\x80\x9F" => '"', // ‟ (U+201F) in UTF-8
        "\xE2\x80\xB9" => "'", // ‹ (U+2039) in UTF-8
        "\xE2\x80\xBA" => "'", // › (U+203A) in UTF-8
        "\xe2\x80\x93" => "-",
        "\xe2\x80\x94" => "-",
        "\xe2\x82\x09" => "-",
        "\xe2\x82\x11" => "-",
        "\xe2\x82\x12" => "-",
      );
      
      for ($index = 2090; $index < $rows; $index++) {
        $brand_name = strtr($data->val($index, 'B', $sheet), $quotes);
        $brand = Brand::model()->findByAttributes(array('name' => $brand_name));
        if (is_null($brand)) {
          $brand = new Brand;
          $brand->name = $brand_name;
          $brand->save();
        }
        $group_name = strtr($data->val($index, 'H', $sheet), $quotes);
        $group = Category::model()->findByAttributes(array(
          'name' => $group_name), 'level=1');
        if (is_null($group)) {
          $group = new Category;
          $group->name = $group_name;
          $group->saveNode();
        }

        $category_name = strtr($data->val($index, 'G', $sheet), $quotes);
        $category = Category::model()->findByAttributes(array(
          'name' => $category_name), 'level=2');
        if (is_null($category)) {
          $category = new Category;
          $category->name = $category_name;
          $category->appendTo($group);
        }
        $subcategory_name = strtr($data->val($index, 'F', $sheet), $quotes);
        $subcategory = Category::model()->findByAttributes(array(
          'name' => $subcategory_name), 'level=3');
        if (is_null($subcategory)) {
          $subcategory = new Category;
          $subcategory->name = $subcategory_name;
          $subcategory->appendTo($category);
        }
        $name = strtr($data->val($index, 'A', $sheet), $quotes);
        $age = (string) $data->val($index, 'K', $sheet);
        $ages = split(' ', $age);
        $productData = array(
          'name' => $name,
          'article' => (string) $data->val($index, 'C', $sheet),
          'brand_id' => (int) $brand->id,
          'gender_id' => $data->val($index, 'L', $sheet),
          'remainder' => (int) $data->val($index, 'I', $sheet),
          'description' => $data->val($index, 'M', $sheet),
          'price' => (float) $data->val($index, 'J', $sheet),
          'age' => $ages[0],
          'age_to' => $ages[1],
          'show_me' => 1,
        );
        $product = Product::model()->findByAttributes(array(
          'article' => $productData['article']));
        if (is_null($product)) {
          $product = new Product;
          $product->attributes = $productData;
          $product->save(FALSE);
        }
        $product_category = ProductCategory::model()->findByAttributes(array(
          'product_id' => $product->id, 'category_id' => $subcategory->id));
        if (is_null($product_category)) {
          $product_category = new ProductCategory;
          $product_category->category_id = $subcategory->id;
          $product_category->product_id = $product->id;
          $product_category->save();
        }

        try {
          $imageUrl = $data->val($index, 'D', $sheet);
          $ext = substr(basename($imageUrl), strrpos($imageUrl, '.', -1));
          $productData['img'] = '/productimages/' . $product->id . $ext;
          $ch = curl_init($imageUrl);
          $fp = fopen($productImagePath . $product->id . $ext, 'w+');
          curl_setopt($ch, CURLOPT_FILE, $fp);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_exec($ch);
          fclose($fp);

          $smallImgUrl = $data->val($index, 'E', $sheet);
          $small_ext = substr($smallImgUrl, strrpos($smallImgUrl, '.', -1));
          $productData['small_img'] = '/productimages/'
              . $product->id . 's' . $small_ext;
          $sfp = fopen($productImagePath . $product->id . 's' . $small_ext, 'w+');
          curl_setopt($ch, CURLOPT_URL, $smallImgUrl);
          curl_setopt($ch, CURLOPT_FILE, $sfp);
          curl_exec($ch);
          curl_close($ch);
          fclose($sfp);
        } catch (Exception $e) {
          Yii::trace($product->article . '; ' . $product->name, 'error');
        }
        $product->attributes = $productData;
        $product->img = $productData['img'];
        $product->small_img = $productData['small_img'];
        $product->save(FALSE);
      }
    }
    $this->redirect('index');
  }

}
