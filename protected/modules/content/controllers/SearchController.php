<?php

class SearchController extends Controller
{
    public function init() {
        parent::init();
    }
    
    public function actionIndex(){
        $this->pageTitle = '"'.Yii::app()->name.'" - Поиск';
        $model = new Tovar;
        $model->scenario = 'search';
        if(isset($_POST['attr'])){ 
            $attr = Yii::app()->session['attr'];
            $attr = $_POST['attr'];
            Yii::app()->session['attr'] = $attr;
        }    
        $model->name = Yii::app()->session['attr'];
        $model->quantity = Yii::app()->session['attr'];
        $model->description = Yii::app()->session['attr'];
        $model->extended = Yii::app()->session['attr'];
        $model->custom = Yii::app()->session['attr'];
                     
        $this->render('searchindex', array('model'=>$model));
    }
    
}
