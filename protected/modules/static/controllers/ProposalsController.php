<?php

class ProposalsController extends Controller
{
    public function init(){
        parent::init();
        if(Yii::app()->user->role != User::ADMIN)
            throw new CHttpException(403, 'Forbidden');
    }
    
    public function actionCenterprop()
    {
        $this->pageTitle = Yii::app()->name.' - Центральный баннер';
        $this->breadcrumbs=array(
                'Добавить центральный баннер',
        );              
        $model =  new Mainbanner;    
            Yii::app()->user->setFlash('set W H', 'Загружайте картинку размером ширины 772px и высотой 383px.');
            if(isset($_POST['Mainbanner']))
            {                
                $uploader=CUploadedFile::getInstance($model,'image');
                if($model->validate())
                {
                    $model->image = md5($uploader->name).'.jpg';
                    if($model->save()){ 
                        $uploader->saveAs($_SERVER['DOCUMENT_ROOT'] . '/image/maincentral/'.$model->image);
                    }                     
                    Yii::app()->user->setFlash('baner saved', 'Банер сохранен');
                }                                 
            }        
        $this->render('form', array('model' => $model));
    }
    
    public function actionLeftprop($id = null)
    {
        $this->pageTitle = Yii::app()->name.' - Баннер левого меню';
        $this->breadcrumbs=array(
                'Добавить левый баннер',
        );
        if ( isset($_GET['delete'])) {
          Bannerleft::model()->deleteByPk($id);
          $id = null;
        }
        $model = ($id) ? Bannerleft::model()->findByPk($id) : new Bannerleft;
        Yii::app()->user->setFlash('set W H', 'Загружайте картинку размером ширины 227px. Высота не принципиальна.');
        if ( isset($_POST['Bannerleft'])) {                
          $model->attributes = $_POST['Bannerleft'];
          $uploader=CUploadedFile::getInstance($model,'image');
            if($model->validate())
            {
                if ($uploader instanceof CUploadedFile) { $model->image = md5($uploader->name).'.jpg'; }
                if($model->save()){ 
                    if ($uploader instanceof CUploadedFile) { $uploader->saveAs($_SERVER['DOCUMENT_ROOT'] . '/image/leftcolumn/'.$model->image); }
                }                     
                Yii::app()->user->setFlash('baner saved', 'Банер сохранен');
            }                                
        }        
        $this->render('form', array('model' => $model));
    }    
    
    public function actionDownprop()
    {        
        $this->pageTitle = Yii::app()->name.' - Нижний баннер';
        $this->breadcrumbs=array(
                'Добавить нижний баннер',
        );               
        $model =  Bannerleft::model()->findByPk(2); 
            Yii::app()->user->setFlash('set W H', 'Загружайте картинку размером ширины 578px и высотой 83px.');
            if(isset($_POST['Bannerleft']))
            {                              
                $uploader=CUploadedFile::getInstance($model,'image');
                if($model->validate())
                {
                    $model->image = md5($uploader->name).'.jpg';
                    if($model->update()){ 
                        $uploader->saveAs($_SERVER['DOCUMENT_ROOT'] . '/baners/downbanner/'.$model->image);
                    }                     
                    Yii::app()->user->setFlash('baner saved', 'Банер сохранен');
                }
            }        
        $this->render('form', array('model' => $model));
    }       
    
    public function actionMainText(){
        $this->pageTitle = Yii::app()->name.' - Общая информация';
        $this->breadcrumbs=array(
                'Добавить текст на главную',
        );           
        $model = new Proposals;
        $field = $model->findByPk(1);
        if(isset($_POST['Proposals'])){
            $field->scenario = 'indexpage';
            $field->indextext = $_POST['Proposals']['indextext'];  
            if($field->validate()){
                $field->save();
                Yii::app()->user->setFlash('text saved', 'Текст сохранен');
            }
        }        
        $this->render('textindexview',array('model'=>$field));
    }
    
}
