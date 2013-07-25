<?php

class Articles extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
        if(isset(Yii::app()->session['tovartype']) && Yii::app()->session['tovartype'])
           $model = Tovartype::model()->findByPk(Yii::app()->session['tovartype']);
       else 
           $model = Tovartype::model()->findByPk(rand(1, 12)); 
       
       if(strlen($model->description)>700){
           $model->description = mb_substr($model->description, 0 , 800,'utf-8').'...<br/>'.CHtml::link('читать далее>>',array('/article/'.$model->id));
       }
       
        CWidget::render('articles', array('model' => $model));
    }    
}