<?php
class ManageController extends Controller
{
  public function init()
  {
    parent::init(); 
    $user = Yii::app()->getModule('user');
      if(Yii::app()->user->isGuest || $user->user()->status != 1)
          throw new CHttpException(403, 'Forbidden');       
  }

  public function actionEditcustom()
  {
      $this->pageTitle = '"' . Yii::app()->name . '" - Редактировать товар';
      if ( isset($_GET['id'])) {
          $model = new Customfield;
            if (!isset($_GET['custom'])) 
              throw new CHttpException(500, 'Доступ запрещен');             
            if (isset($_POST['Customfield'])) {             
              $model->attributes = $_POST['Customfield'];
              $model->tovar_id = $_GET['id'];
              $model->custom_id = $_GET['custom'];
              if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash('item saved successufuly', 'Вкус "' . $_POST['Customfield']['name'] . '" сохранен');
              }
            }
        $tovar = Tovar::model()->findbyPk($_GET['id']);
        $this->render('edit_custom',array('tovar' =>  $tovar, 'model' => $model,'g_id' => $_GET['id'], 'custom_id' => $_GET['custom']));
      }
  }

  public function actionDeletecustom()
  {
      $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать товар';
       if(isset($_GET['id']))
          {
           $model = new Customfield;   
           $result = $model->findByPk($_GET['id']);
              if($result)
              {
                  $result->delete();
              }
           $this->render('edit_custom',array('model'=>$model,'g_id'=>$_GET['tovid']));
          }
  }

  public function actionEditItem($id = false)
  {
    $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать товар';
    $tovar = new Tovar;
    $pictures = new TovarPics;
    if ($id) {
      $item = $tovar->with('pictures')->findByPk($id);   
    } else {
      $item = $tovar;
      if (!isset($_POST['Tovar'])) {
         $item->name = ''; 
      }                    
    }
    if (isset($_POST['Tovar'])) {
      $item->attributes = $_POST['Tovar'];
      if ($item->validate()) {
        $item->save();
        if (isset($_POST['TovarPics'])) { 
          $uploader = CUploadedFile::getInstance($pictures, 'picname');
          $pictures->tovar_id = $item->id;
          if (!$pictures->find('tovar_id=:tovar_id', array(':tovar_id' => $item->id) ) ) {
            $pictures->is_cover = 1;
          }
          if ( ($uploader instanceof CUploadedFile) && $pictures->validate()) {
            $pictures->picname = md5($uploader->name) . '.jpg';            
            if ($pictures->save()) { 
                $uploader->saveAs($_SERVER['DOCUMENT_ROOT'] . '/image/' . $pictures->picname);
                Yii::app()->ih
                  ->load($_SERVER['DOCUMENT_ROOT'] . '/image/' . $pictures->picname)
                  ->thumb(100, 100)                  
                  ->save($_SERVER['DOCUMENT_ROOT'] . '/image/thumbs/' . $pictures->picname)
                  ->reload($_SERVER['DOCUMENT_ROOT'] . '/image/' . $pictures->picname)
                  ->thumb(160, 160)
                  ->save($_SERVER['DOCUMENT_ROOT'] . '/image/thumbs_middle/' . $pictures->picname);
                Yii::app()->user->setFlash('item saved successufuly', 'Товар сохранен');
                $this->redirect($this->createUrl('/manage/manage/edititem', array('id' => $item->id)));
            }                     
          }            
        }
        if (!$item->errors && !$pictures->errors) {
          Yii::app()->user->setFlash('item saved successufuly', 'Товар сохранен');
        }
      }
    }   
    $this->render('index', array('model'  =>  $item, 'pictures' =>  $pictures));
  }
  
  public function actionRemoveItemFoto($item_id, $num_foto) 
  {
    if (!$item_id || !$num_foto) 
      throw new CHttpException(500, 'Доступ запрещен'); 
    TovarPics::model()->deleteByPk($num_foto);
    $this->redirect($this->createUrl('/manage/manage/edititem', array('id' => $item_id)));
  }
  
  public function actionCover($item_id, $num_foto) 
  {
    if (!$item_id || !$num_foto) 
      throw new CHttpException(500, 'Доступ запрещен'); 
    $model = new TovarPics;
    $criteria = new CDbCriteria();
    $criteria->condition = 'tovar_id = :tovar_id AND is_cover = :is_cover';
    $criteria->params = array(':tovar_id' => $item_id, ':is_cover'  =>  '1');
    $toDel = $model->find($criteria);
    $transaction = Yii::app()->db->beginTransaction();
    try 
    {
      if ($toDel) {
        $toDel->is_cover = 0;    
        $toDel->save();
      }
      $newCover = $model->findByPk($num_foto);
      $newCover->is_cover = 1;
      $newCover->save();
      $transaction->commit();
    }
    catch (Exception $e) {
      $transaction->rollback();
    }
    $this->redirect($this->createUrl('/manage/manage/edititem', array('id' => $item_id)));
  }

  public function actionDelete()
  {
    if (!Yii::app()->user->isGuest) { 
      $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать товар';
      $tovar = new Tovar;
      $item = $tovar->findByPk($_GET['id']); 
      $id = $item->menu_id_item;
      if($item->pic_name){
          $file = 'baners/'.$item->pic_name;
          $thumb = 'baners/thumbs/'.$item->pic_name;
          if(file_exists($file)) unlink($file);
          if(file_exists($thumb)) unlink($thumb);
      }
      $item->delete();
      Customfield::model()->deleteAll('tovar_id=:tovar_id', array(':tovar_id'=>$_GET['id']));
      $this->redirect("/store?menu=" . $id);                
    }
  }

  public function actionAddbrand()
  {
      // status == 1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!
      $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать производителя';
      $model = new Brands;
      if(isset($_POST['Brands']))
      {
          $model->attributes = $_POST['Brands'];
          if($model->validate())
          {
              $model->save();
              Yii::app()->user->setFlash('item saved successufuly', 'Производитель сохранен.');
          }
      }
      $this->render('addbrand', array('model'=>$model));
  }

      public function actionDeletebrand(){
          if(!Yii::app()->user->isGuest){    
              $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать производителя';
              $model = new Brands;
              if(isset($_POST['Brands'])){
                      $model->attributes = $_POST['Brands'];
                      if($model->validate()){
                          $model->deleteByPk($_POST['Brands']['brand']);                        
                          Tovar::model()->deleteAll('brand=:brand', array(':brand'=>$_POST['Brands']['brand']));
                          Yii::app()->user->setFlash('no brand', 'Производитель удален.');
                      }
                  }            
              $this->render('deletebrand', array('model' => $model));
          }
          else
              $this->redirect("/index.php");            
      }

      public function actionEditbrand(){
          if(!Yii::app()->user->isGuest){ 
              $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать производителя';
              $model = new Brands;
              if(isset($_POST['Brands'])){
                  if(preg_match('|^[\d]+$|',$_POST['Brands']['brand']))
                      $onebrand = Brands::model()->findByPk($_POST['Brands']['brand']);                    
                  else{
                      if(isset($_GET['id'])){
                          $onebrand = $model->findByPk($_GET['id']);
                          $onebrand->brand = $_POST['Brands']['brand'];
                          $onebrand->update();
                          Yii::app()->user->setFlash('no brand', 'Производитель сохранен.');
                      }
                  }
              } else $onebrand = null;

              $this->render('editbrand', array('model' => $model, 'onebrand'=>$onebrand));
          }
          else
              $this->redirect("/index.php");              
      }        

      public function actionOrders()
      {                                         
          if(!Yii::app()->user->isGuest)
          {                
              $criteria=new CDbCriteria;
              if(isset($_GET['id']))
              {
                  $criteria->condition = 'user_id='.$_GET['id'];
                  $this->breadcrumbs=array(
                          'Заказы пользователя',
                  );      
                  $this->pageTitle = '"'.Yii::app()->name.'" - Заказы пользователя';
              }elseif(isset($_GET['all']))
              {
                  $this->breadcrumbs=array(
                          'Все заказы',
                  );   
                  $this->pageTitle = '"'.Yii::app()->name.'" - Все заказы';
                  $criteria->order ='time DESC';
              }
              else
              {
                  $criteria->condition = 'user_id='.Yii::app()->user->id;
                  $this->breadcrumbs=array(
                  'Мои заказы',
                  );
                  $this->pageTitle = '"'.Yii::app()->name.'" - Мои заказы';
              }

              $criteria->with=array(
                  'orderitems.tovars'
              );
              $pages=new CPagination(Order::model()->count($criteria));
              $pages->pageSize = 6;
              $pages->applyLimit($criteria);                
              $orders = Order::model()->findAll($criteria);
              //$orders = Order::model()->with('orderitems.tovars')->findAll('user_id=:user_id', array(':user_id' => Yii::app()->user->id));
              if(!$orders)
              {
                  Yii::app()->user->setFlash('no orders', 'Пока нет заказов.');
              }
              $this->render('orders_title', array('orders'=>$orders,'pages' => $pages));
          }  
          else
              $this->redirect("/index.php");
    }

  public function actionOrderById()
  {
      if(strpos(Yii::app()->request->urlReferrer,'orders/id/')==true)
      {
          $this->breadcrumbs=array(
                  'Заказы пользователя'=>Yii::app()->request->urlReferrer,
                  'Заказ' 
          );              
          $this->pageTitle = '"'.Yii::app()->name.'" - Заказы пользователя';
      }
      else
      {
          $this->breadcrumbs=array(
                  'Мои заказы'=>'/manage/manage/orders',
                  'Заказ' 
          );
          $this->pageTitle = '"'.Yii::app()->name.'" - Мои заказы';
      }

      if(!Yii::app()->user->isGuest)
      {
          $criteria=new CDbCriteria;
          $criteria->condition = 'order_id = '.$_GET['id'];
          $criteria->with=array(
              'tovars'
          );
          $pages=new CPagination(Orderitems::model()->count($criteria));
          $pages->pageSize = 3;
          $pages->applyLimit($criteria);
          $order = Orderitems::model()->findAll($criteria);
          $this->render('orderview', array('model' => $order,'pages' => $pages));
      }  
      else
          $this->redirect("/index.php");            
  }
  
  /**
   *  Создает,редактирует левое меню
   */
  public function actionCreateMenuItem() 
  {
    // Удаление
    if ( isset($_POST['deleteitem']) ) {   
      NavigationItems::model()->deleteByPk((int) $_POST['deleteitem']);
      Yii::app()->user->setFlash('Success', 'Успешно');
    }     
    $model = new NavigationItems;
    // Редактирование
    if ( isset($_GET['edit']) && isset($_GET['id'])) {
      $editmodel = NavigationItems::model()->findByPk((int) Yii::app()->request->getParam('id'));   
      $uploader = CUploadedFile::getInstance($model, 'picture');      
      if ( (isset($_POST['NavigationItems']['name']) && strlen($_POST['NavigationItems']['name']) > 0) || ($uploader instanceof CUploadedFile)) {        
        $editmodel->attributes = $_POST['NavigationItems'];
        if ( $editmodel->validate()) {
          if ($uploader instanceof CUploadedFile) {
            $editmodel->picture = md5($uploader->name) . '.jpg';            
            $uploader->saveAs($_SERVER['DOCUMENT_ROOT'] . '/image/menu/big/' . $editmodel->picture);
            Yii::app()->ih
              ->load($_SERVER['DOCUMENT_ROOT'] . '/image/menu/big/' . $editmodel->picture)
              ->thumb(213, 213)                  
              ->save($_SERVER['DOCUMENT_ROOT'] . '/image/menu/' . $editmodel->picture);             
          }
          $editmodel->save();
          Yii::app()->user->setFlash('Success', 'Успешно');
        }
        
      }           
    }     
           
    
    if ( isset($_POST['NavItems_create']) ) {   
      $model->attributes = $_POST['NavItems_create'];
        if ($model->validate()) {
          $model->save();
          Yii::app()->user->setFlash('Success', 'Успешно');
        }
    }      
    $all = NavigationItems::model()->findAll();
    $root = SomeIterations::selectRoot($all);
      foreach ($all as $a) {
        if ((int)$a->parent_id === 0) {
          $onlyRoots[$a->id] = $a->name;
        }
      }
    // Меню
    $menu = SomeIterations::menuItems($root);
    $this->render('createmenu', array(
      'root' => $onlyRoots,
      'model' => $model,
      'items' => $menu['items'],
      'disabled' => $menu['disabled'],
      'editmodel' => (isset($editmodel)) ? $editmodel : $model
    ));
  }
}