<?php
/**
 * DynaTree is a Yii Framework wrapper class for jQuery Dynatree extension {@link http://wwwendt.de/tech/dynatree/index.html)
 * also it handles with setting selected items and form submit in hidden fields.
 *
 * @author Murat Kutluer <muratkutluer@yahoo.com>
 * @copyright Copyright &copy; Murat Kutluer 2012
 * @link http://www.yiiframework.com/extension/dynatree/
 * @link http://wwwendt.de/tech/dynatree/index.html
 * @access public
 * @version 0.1
 */
class DynaTree extends CWidget
{
    /**
    * data for displaying items
    *
    * @var mixed
    */
    public $data=array();

    /**
    * form selector to attach selected items
    *
    * @var mixed
    */
    public $form='form';

    /**
    * attribute name for selected items to bind on form submit
    *
    * @var mixed
    */
    public $attribute;

    /**
    * selection to set selected items
    * format: (2,3,6,7)
    *
    * @var mixed
    */
    public $selection=array();

    /**
    * html options for container div tag
    *
    * @var mixed
    */
    public $htmlOptions=array();

    /**
    * options for dynatree initialization
    *
    * @var mixed
    */
    public $options=array();

    /**
    * default options
    *
    * @var mixed
    */
    protected $defaultOptions=array('debugLevel'=>1,'checkbox'=>true,'selectMode'=>2);

    /**
    * initialize widget
    *
    */
    public function init()
    {
        //get widget id
        if(isset($this->htmlOptions['id']))
            $this->id=$this->htmlOptions['id'];
        else
            $this->htmlOptions['id']=$this->getId();

        //container div
        echo CHtml::tag('div',$this->htmlOptions,true,true);

        //set selection
        if($this->selection){
            $this->data=$this->setSelection($this->data);
        }

        //encode data and options
        $options=CJavaScript::encode(array_merge($this->defaultOptions,$this->options,array('children'=>$this->data)));

        //publish files
        $path=Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');

        //register script and css files, then initialize with data and options
        Yii::app()->getClientScript()
            ->registerCoreScript('jquery')
            ->registerCoreScript('jquery.ui')
            ->registerScriptFile($path.'/jquery.dynatree.min.js')
            ->registerCssFile($path.'/skin/ui.dynatree.css')
            ->registerScript(__CLASS__.$this->id,'
                $("#'.$this->id.'").dynatree('.$options.');
                $("'.$this->form.'").submit(function(){
                    $.each($("#'.$this->id.'").dynatree("getSelectedNodes"),function(){
                        $("<input>").attr({"type":"hidden","name":"'.$this->attribute.'[]","value":this.data.id}).appendTo("'.$this->form.'");
                    })
                });
            ');
    }

    /**
    * set selected items
    *
    * @param mixed $data
    */
    protected function setSelection($data=array())
    {
        foreach($data as $i=>$child){
            if(in_array($child['id'],$this->selection))
                $data[$i]['select']=true;
            if(!empty($child['children']))
                $data[$i]['children']=$this->setSelection($child['children']);
        }
        return $data;
    }

    /**
    * run widget
    *
    */
    public function run()
    {
        //nothing happens here
    }
}
?>
