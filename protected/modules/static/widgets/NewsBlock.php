<?php

class NewsBlock extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
        // этот метод будет вызван внутри CBaseController::endWidget()
    }
    
    public function last2news()
    {
        $last2 = News::model()->recently()->findAll();        
        CWidget::render('index', array('model' => $last2));
    }    
}
?>
