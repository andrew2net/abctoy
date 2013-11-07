<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form TbActiveForm */
?>
<div id="category-tree">
  <?php echo $model->categoryTree; ?>
</div>
<?php
$jstree_data = <<<EOD
$("#category-tree").jstree({
    "core" : {"load_open" : true},
    "checkbox" : {
      "two_state" : true,
      "real_checkboxes" : true,
      "real_checkboxes_names" : function(n){
        var id = n[0].id.replace(/node_/, "");
        return ["Categories[" + id +"]"];
          }
        },
    "plugins" : ["themes", "html_data", "checkbox"]
    
 }).bind("loaded.jstree", function(event, data){
   $(this).jstree("open_all");
     });
EOD;
$dir = Yii::getPathOfAlias('ext.jstree') . DIRECTORY_SEPARATOR . 'assets';
$assets = Yii::app()->getAssetManager()->publish($dir);
$cs = Yii::app()->getClientScript();
$cs->registerScript(__CLASS__ . 'jstree_category', $jstree_data, CClientScript::POS_END);
$cs->registerCssFile($assets . '/themes/default/style.css');
$cs->registerScriptFile($assets . '/jquery.jstree.js', CClientScript::POS_END);
?>
