<?php

class HorizontalSlider extends CWidget
{
  public $caption;
  public $fontclass;
  public $widgettheme;
  public $sliderId;
  
  public function init()
  {
      // этот метод будет вызван внутри CBaseController::beginWidget()
  }

  public function run()
  {
    $criteria = new CDbCriteria;
    if ($this->widgettheme === 'hits') {
      $orderitems = Orderitems::model()->findAll( new CDbCriteria(array(
        'group' => 'tovar_id',
        'select'  =>  'tovar_id',
        'index'  =>  'tovar_id',
        'limit' => 10,
        'order' => 'count(*) DESC'
      )));      
      $criteria->addInCondition('t.id', array_keys($orderitems));
    } elseif ($this->widgettheme === 'recommended') {
      $criteria->limit = 10;
      $criteria->order = 'rand()';
    } else {
      $criteria->limit = 10;
      $criteria->order = 'id DESC';
    }
    $model = Tovar::model()->with('cover')->findAll($criteria);
    // этот метод будет вызван внутри CBaseController::endWidget()
    $this->render('horizontal_slider', array('model' => $model));
  }      
}