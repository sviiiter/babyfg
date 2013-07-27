<?php

class GraficMenu extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
      // этот метод будет вызван внутри CBaseController::endWidget()
      $model = NavigationItems::model()->findAll('parent_id = :parent_id', array(':parent_id' => 0));
      $this->render('graficmenu', array('menuitems' => $model));      
    }         
}