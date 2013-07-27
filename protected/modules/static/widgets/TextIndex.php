<?php

class TextIndex extends CWidget
{
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {
        $model = Proposals::model()->findByPk(1); 
        if(Yii::app()->getModule('user')->isAdmin()) echo CHtml::link('>>править',array('/static/proposals/maintext')); 
        echo $model->indextext;
    }    
}