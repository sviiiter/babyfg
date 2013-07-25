<?php

class Central extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
        // этот метод будет вызван внутри CBaseController::endWidget()
    }
    
    public function central()
    {
        $last5 = Mainbanner::model()->recently()->findAll();  
        CWidget::render('central/central', array('model' => $last5));
    }       
}