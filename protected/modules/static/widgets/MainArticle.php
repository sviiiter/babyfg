<?php

class MainArticle extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
       $model = Proposals::model()->findByPk(2);
       //if(strlen($model->indextext)>700){
       //    $model->indextext = mb_substr($model->indextext, 0 , 850,'utf-8').'...';
       //}
       
        CWidget::render('mainarticle', array('model' => $model));
    }    
}