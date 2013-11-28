<?php
Yii::import('zii.widgets.CListView');
class ListView extends CListView
{
    public function renderSizer()
    {
        $links = array();
        foreach (array(10, 20, 30) as $count)
        {        
            $params = array_replace($_GET, array('size'=>$count));
            if (isset($params['page']))
                unset($params['page']);
 
            $links[] = CHtml::link($count, Yii::app()->controller->createUrl('', $params));
        }        
        echo '<p>Показывать: ' . implode(', ', $links) . '</p>';
    }
}