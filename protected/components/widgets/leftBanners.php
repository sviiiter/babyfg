<?php

class leftBanners extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
      // этот метод будет вызван внутри CBaseController::endWidget()
      $criteria = new CDbCriteria;
      $criteria->limit = 5;
      $criteria->order = 'id DESC';      
      $last5 = Bannerleft::model()->findAll($criteria);  
      $this->render('leftbanners', array('model' => $last5));      
    }         
}