<?php

class MainCentral extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
      // этот метод будет вызван внутри CBaseController::endWidget()
      $last5 = Mainbanner::model()->recently()->findAll();  
      $this->render('maincentral', array('model' => $last5));      
    }         
}