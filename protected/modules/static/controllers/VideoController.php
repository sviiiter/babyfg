<?php
class VideoController extends Controller
{
    public function init(){
        if(!Yii::app()->getModule('user')->isAdmin())
            throw new CHttpException(403, 'Forbidden');
    }


    public function actionLoad(){
        $this->pageTitle = '"'.Yii::app()->name.'" - Загрузить видео';
        $video = new Video;
        if(isset($_GET['id'])) $model = $video->findByPk($_GET['id']);
        if(isset($_POST['Video'])){                
            $uploaded_file = $_FILES['Video']['tmp_name'];
            $uploaded_filename = $_FILES['Video']['name'];
            if($uploaded_filename['imglink']){
                $filename = md5($uploaded_filename['imglink']);      
                $model->imglink = $filename.'.jpg';  
            }else 
                $model->imglink = ' ';
            
            if(isset($_POST['Video']['embedlink'])) $model->embedlink = $_POST['Video']['embedlink'];
            if($model->validate()){
                Yii::app()->ih
                ->load($uploaded_file['imglink'])
                ->watermark($_SERVER['DOCUMENT_ROOT'] . '/baners/video/watermark.jpg', 10, 20, CImageHandler::CORNER_CENTER, 0.3)
                ->save($_SERVER['DOCUMENT_ROOT'] . '/baners/video/'.$filename.'.jpg');                 
                $model->save();
                Yii::app()->user->setFlash('baner saved', 'Банер сохранен');
            }            
        }
        $this->render('load', array('model'=>$model));
    }
}