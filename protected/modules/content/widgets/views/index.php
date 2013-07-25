<?php 
  $i = 0;
  foreach ($root as $r_k => $root_item) {
    $split_key = explode('_', $r_k);
    //if ($root_item !== 0) {
    //  $split_value = explode('_', $root_item);
    //}
    $items_t[$i] = array(
        'label'=> mb_strtoupper($split_key[1], 'UTF8'), 
        'url' => ($root_item !== 0 ) ? '' : array('/store/listbymenu', 'menu' => $split_key[0]),
        'linkOptions' => array(
          'onclick' => 'show(this)',
          //'rel' => 'nofollow'
        ), 
        'itemOptions' =>  array(
          'style' =>  'list-style-type:none;',          
          'class' => 'parent'
        ),
        'submenuOptions' => array('class' => 'newborn submenus')
    );    
    if ($root_item !== 0 ) {
      $arI = array();
      foreach ($root_item as $c) {
        $split_value = explode('_', $c);
        $arI[] = array('label' => '- ' . $split_value[1], 'url' => array('/store/listbymenu', 'menu' => $split_value[0]));
      }
      $items_t[$i]['items'] = $arI;
      unset($arI);
    }
    $i++;
  }
$this->widget('zii.widgets.CMenu',array(
  'items'=>$items_t,
  'htmlOptions' => array('class' => 'menu')
)); 
