<?php

class SiteController extends Controller
{
    public $breadcrumbs = array();
    
    public function actionIndex()
    {
        $this->pageTitle = '"'.Yii::app()->name.'"-магазин детской одежды';        
        $model = new Tovar;
        $result = $model->findAll(array('order' => 'id DESC', 'limit'=>9));
        $this->render('application.views.site.title', array('model'=>$result));                   
    }
    
    
    /*public function actionImgconvert()
    {
        ini_set("max_execution_time", "12000000");  // установлено большое время выполнения скрипта
        ini_set('memory_limit', '1000000000000M');
        $pathtoimg = $_SERVER['DOCUMENT_ROOT'].'src';
        $savepath = $_SERVER['DOCUMENT_ROOT'] .'baners';
        $files = scandir($pathtoimg);
        foreach ($files as $value) {
            echo $pathtoimg.'/'.$value;
            if(is_file($pathtoimg.'/'.$value))
            {
            Yii::app()->ih
            ->load($pathtoimg.'/'.$value)
            ->thumb(100, 100)
            ->save($_SERVER['DOCUMENT_ROOT'] . 'baners/thumbs/'.$value)
            ->reload($pathtoimg.'/'.$value)
            ->thumb(200, 200)
            ->save($_SERVER['DOCUMENT_ROOT'] . 'baners/'.$value);
            }
        }     
    }*/

  /**
  * This is the action to handle external exceptions.
  */
	public function actionError()
	{
        $this->layout='application.views.layouts.main';
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}    
}
