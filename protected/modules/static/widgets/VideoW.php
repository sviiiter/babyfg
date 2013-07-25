<?php

class VideoW extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
        $model = Video::model()->findAll();       
        CWidget::render('video', array('model' => $model));
    }    
}