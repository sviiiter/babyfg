<?php

 class recentlyInterested extends CWidget
 {
   public function init()
   {
     
   }
   public function run()
   {
     $item = (Yii::app()->cache->get('item')) ? Yii::app()->cache->get('item') : array();     
     $tovar = (!empty($item)) 
       ? Tovar::model()->with(array('pictures' => array(
          'condition' =>  'is_cover=:is_cover',
          'params'  =>  array('is_cover'  =>  '1'),
          'together'  => false
         )))->findAllByPk(array_values($item)) 
       : null;       
     $this->render('recently', array('tovar' => $tovar));
   }
 }