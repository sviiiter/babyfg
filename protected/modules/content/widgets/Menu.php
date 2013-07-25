<?php
class Menu extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
      // этот метод будет вызван внутри CBaseController::endWidget()
      $all = NavigationItems::model()->findAll();
      $root = SomeIterations::selectRoot($all);
      $this->render('index', array('root' => $root));      
    }    
}

?>
