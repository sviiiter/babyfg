<?php

class StoreController extends Controller
{       
    public function init() {
        parent::init();
    }

    public function actionShowall()
    { 
        $result = Tovar::model()->with('pictures')->findAll(array('order' => 'id DESC'));
        $this->render('index', array('model'=>$result));
    }
    
    public function actionItem($id=null)
    {                
        if(!$id)
           throw new CHttpException('404', 'Страница не найдена');
        
        // кэшируем
        $item = (Yii::app()->cache->get('item')) ? Yii::app()->cache->get('item') : array();
        if (!(sizeof($item) < 16)) {
          array_shift($item);
        }
        if (!array_search($id, $item)) {
          $item[] = $id;
        }
        Yii::app()->cache->set('item', $item);
        
        $tovar = Tovar::model()->with(array(
          'pictures' => array('order' => 'is_cover DESC'),
          'customfields'
        ))->findByPk($id);
        $this->category = $tovar->menu_id_item;
        $custom1 = array();
        $custom2 = array();
        foreach ($tovar->customfields as $cusfield) {
          ((int)$cusfield->custom_id === 1) ? $custom1[] = $cusfield : $custom2[] = $cusfield;
        }
        $tovar->cus1_values = $custom1;
        $tovar->cus2_values = $custom2;
        $this->render('item',array('value'=>$tovar));
    }

    public function actionListbytype(){
        if(!isset($_GET['type']))
            throw new CHttpException('404', 'Страница не найдена');
        $typeparam = Yii::app()->request->getParam('type');
        $pagetitletext = '';
        $type = Tovartype::model()->findByPk($typeparam);
            if($type){
                preg_match("/^.*?\..*?\./", $type->description, $matches);
                $this->description = (isset($matches[0]) && strlen($matches[0]) < 145) 
                    ? str_replace(array('&nbsp;','&mdash;'), ' ', strip_tags($matches[0]))
                    : str_replace(array('&nbsp;','&mdash;'), ' ', strip_tags(substr($type->description, 0, strpos($type->description, '.'))));               
                $this->description = $type->type . "." . $this->description . ". Магазин детской одежды " . Yii::app()->name . ".";                    
                $this->description = str_replace('  ', ' ', $this->description); 
                $pagetitletext = $pagetitletext . $type->type;
                if ($type->type == 'BCAA') 
                    $pagetitletext = $pagetitletext . '-купить аминокислоты ';
                else
                    $pagetitletext = $pagetitletext . '-купить ';

                $pagetitletext = $pagetitletext . 'в магазине спортивного питания "' . Yii::app()->name . '"';  

                $this->addwords_start = 
                    mb_convert_case($type->type , MB_CASE_LOWER, "UTF-8")
                    . ',купить ' . mb_convert_case($type->type , MB_CASE_LOWER, "UTF-8") . ',' 
                    . (($type->type == 'BCAA') 
                        ?   ('Аминокислоты ' . mb_convert_case($type->type , MB_CASE_LOWER, "UTF-8") . ',купить аминокислоты,' . ',купить аминокислоты ' . mb_convert_case($type->type , MB_CASE_LOWER, "UTF-8") . ',')
                        : '')
                    . (($type->type == 'Витамины и минералы')
                        ? (implode(',', explode(' и ', mb_convert_case($type->type , MB_CASE_LOWER, "UTF-8"))) . ','
                          . 'купить ' . implode(',купить ', explode(' и ', mb_convert_case($type->type , MB_CASE_LOWER, "UTF-8")))) . ',' 
                        : '')
                    . 'магазин спортивного питания, спортивное питание, спортпит'; 
            }
        if(isset($_GET['page']))
            $pagetitletext = $pagetitletext . ' - Страница '.$_GET['page'];
        Yii::app()->session['tovartype'] = $typeparam;
        $this->pageTitle = $pagetitletext;
        if(!Yii::app()->user->isGuest)
            $user = User::model()->findByPk(Yii::app()->user->id);        
        else
            $user = null;  
        $criteria=new CDbCriteria;
        $criteria->condition = 'types.id = '.$typeparam; 
        $with_option = 'types';
        $pages=new CPagination(Tovar::model()->with($with_option)->count($criteria));
        $pages->pageSize = 12;
        $pages->applyLimit($criteria);        
        $tovar = Tovar::model()->with($with_option)->findAll($criteria);
        if(!$tovar) Yii::app()->user->setFlash('no result', 'Нет товаров.');        
        $this->render('index', array('model'=>$tovar, 'pages' => $pages, 'user' => $user));  
        unset(Yii::app()->session['tovartype']);        
    }    
    
    public function actionListbymenu(){
        $pagetitletext = '';
        $menuItem = isset($_GET['menu'])  ?   $_GET['menu'] : false;
        $menu = ($menuItem) ? NavigationItems::model()->findAll( new CDbCriteria(array(
          'index' =>  'id',
          'condition' =>  'parent_id = :parent_id',
          'params'  =>  array(':parent_id' => $menuItem)
        ))) : false;
        //Yii::app()->session['tovartype'] = $typeparam;
        //$this->pageTitle = $pagetitletext;
        if(!Yii::app()->user->isGuest)
            $user = User::model()->findByPk(Yii::app()->user->id);        
        else
            $user = null;  
        $criteria=new CDbCriteria;
        if ($menuItem) {
          if ($menu) {
            $criteria->addInCondition( 'menu_id_item', array_keys($menu));
          } else {
            $criteria->condition = 'menu_id_item = :menu_id_item';
            $criteria->params = array(':menu_id_item' => $menuItem);
          }
        }
        $pages=new CPagination(Tovar::model()->count($criteria));
        $pages->pageSize = 18;
        $pages->applyLimit($criteria);        
        $tovar = Tovar::model()->with(array('menu','pictures' => array(
          'condition' =>  'is_cover=:is_cover',
          'params'  =>  array('is_cover'  =>  '1')
        )))->findAll($criteria);
        if (!$tovar) Yii::app()->user->setFlash('no result', 'Нет товаров.');        
        $this->render('index', array('model'=>$tovar, 'pages' => $pages, 'user' => $user));  
    }      
    
    public function actionListbybrand()
    { 
        $pagetitletext = '';
        $brandparam = isset($_GET['brand'])  ?   $_GET['brand'] : false;
        
        if($brandparam){
            $brand = Brands::model()->findByPk($brandparam);             
            $pagetitletext = $pagetitletext . $brand->brand;              
            $this->addwords_start = 
                mb_convert_case($brand->brand , MB_CASE_LOWER, "UTF-8")
                . ',купить ' . mb_convert_case($brand->brand , MB_CASE_LOWER, "UTF-8") . ',' 
                . (($brand->brand == 'TWINLAB') 
                    ?   mb_convert_case($brand->brand , MB_CASE_LOWER, "UTF-8") . ' Amino,'
                    : '')
                . (($brand->brand == 'BioTech')
                    ? $brand->brand . ' Brutal,'
                    : '')
                . 'жиросжигатели, магазин спортивного питания, спортивное питание, спортпит';                               
        } else {
            $pagetitletext = 'Спортивное питание - Каталог';
        }                        
	
        $this->description = $pagetitletext . ".Магазин спортивного питания " . Yii::app()->name . "."; 
        
        $pagetitletext = $pagetitletext . '-купить в магазине спортивного питания "' . Yii::app()->name . '"';
		
        if(isset($_GET['page']))
            $pagetitletext = $pagetitletext.' - Страница '.$_GET['page'];             
        $this->pageTitle = $pagetitletext;
        if(!Yii::app()->user->isGuest)
            $user = User::model()->findByPk(Yii::app()->user->id);        
        else
            $user = null;
        $criteria=new CDbCriteria;
        if($brandparam)
            $criteria->condition = 'brands.id = '.$brandparam;
        $with_option = 'brands';
        $pages=new CPagination(Tovar::model()->with($with_option)->count($criteria));
        $pages->pageSize = 12;
        $pages->applyLimit($criteria);

        $tovar = Tovar::model()->with($with_option)->findAll($criteria);  
        if(!$tovar)
        {
            Yii::app()->user->setFlash('no result', 'У производителя нет товаров.');
        }
        $this->render('index', array('model'=>$tovar, 'pages' => $pages, 'user' => $user));
    }
    
    public function actionAddtovartocart()
    {
      if ( !isset($_GET['id']) || !Yii::app()->request->isAjaxRequest)
        throw new CHttpException(403, 'Доступ запрещен');
        $cart = Yii::app()->session['id'];
        $arTemp = array(
          'id' => $_GET['id'],
          'param1'  =>  $_GET['first_param'],
          'param2'  =>   $_GET['second_param'],
          'quantity'  =>  $_GET['quantity'],          
        );
        $cart[ $_GET['id'] ][ $_GET['first_param'] . '_' . $_GET['second_param'] ] = $arTemp;
        Yii::app()->session['id'] = $cart;    
        echo '{ "session_count": ' . sizeof(Yii::app()->session['id']) . ', "myimg" : "<img src=\'/css/incart.png\' />" }';           
    }
    
    public function actionCart()  //Переделать на правильные условия!!!
    {
      $items = null;
      $pages = null;
      $sumprice = null;        
      $this->pageTitle = '"'.Yii::app()->name.'" - Корзина';        
        if ( isset(Yii::app()->session['id']) && Yii::app()->session['id'] ) {
          $items = Yii::app()->session['id'];
          $criteria=new CDbCriteria;
          $criteria->index = 'id';
          $criteria->addInCondition('id',  array_keys($items)); 
          $pages = new CPagination(Tovar::model()->count($criteria));
          $pages->pageSize = 4;
          $pages->applyLimit($criteria);        
          $tovars = Tovar::model()->with('customfield1', 'customfield2', 'cover')->findAll($criteria); 
          $sumprice = ContentModule::sumprice();           
        } 
        
        if ($tovars === null) {
          $tovars = null;
          $pages = null;
          $sumprice = null;
          Yii::app()->user->setFlash('empty items', "В корзине нет товаров.");             
        }
        
        $this->render('cart', array(
          'model'=>$tovars,
          'pages' => $pages,
          'sumprice' => $sumprice,
          'items' =>  $items
        ));        
    }
    
    public function actionSaveitem()
    {
      if ( !isset($_GET['item']) || !isset($_GET['subitem']) || !isset($_GET['quantity']) )
        throw new CHttpException(403, 'Доступ запрещен');
       $item = $_GET['item'];
       $subitem = $_GET['subitem'];
       $quantity = $_GET['quantity'];
       $items = Yii::app()->session['id'];
       $current = $items[$item][$subitem];
       $current['quantity'] = $_GET['quantity'];
       $items[$item][$subitem] = $current;
       Yii::app()->session['id'] = $items;
       echo '{"message": "Изменения сохранены"}';
    } 
   
    /**
     * Что это?
     */
    public function actionDeletecustomfield(){
        $custom = Yii::app()->session['id'];
        unset($custom[$_GET['id']][$_GET['field']]);
        if(empty($custom[$_GET['id']]))
            $custom[$_GET['id']] = 1;
        Yii::app()->session['id'] = $custom;
        $this->_rendercart();              
    }

    private function _rendercart(){
        
        $session = Yii::app()->session['id'];
        ksort($session);
        $criteria=new CDbCriteria;
        $criteria->addInCondition('id',array_keys($session)); 
        $pages=new CPagination(Tovar::model()->count($criteria));
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);        
        $items = Tovar::model()->with('customfield')->findAll($criteria); 
        $sumprice = ContentModule::sumprice();        
        $this->renderPartial('cart', array('model'=>$items, 'pages' => $pages, 'sumprice' => $sumprice),false,true);          
    }            
    

    public function actionSaveorder(){        
        $this->pageTitle = '"'.Yii::app()->name.'" - Корзина';
        $order = new Order;
        if (!Yii::app()->user->isGuest) { 
            $user = User::model()->findByPk(Yii::app()->user->id);
            $profile = $user->profile;            
            $order->person = $profile->firstname;
            $order->email = $user->email;
            $order->phone = $user->mob_phone;    
        }         
        if (isset($_POST['Order'])) {
            $order->attributes = $_POST['Order'];
            if($order->validate()){
                $items = Yii::app()->session['id'];
                if(Yii::app()->user->isGuest){
                  $order->user_id = 0;
                  $flashmessage = "Ваш заказ отправлен нам.<br/>Спасибо, что заказали у нас.<br/>Мы свяжемся с вами в самое ближайшее время.";
                }else{        
                  $order->user_id = Yii::app()->user->id;
                  $flashmessage = "Ваш заказ сохранен и отправлен нам.<br/>Спасибо, что с нами.<br/>Мы свяжемся с вами в самое ближайшее время.";
                }        
                Sender::sendCartbyMailtoAdmin($items, $order);
                Sender::sendCartbyMailtoUser($order->email, $items);
                Sender::sendSMS(Yii::app()->params['phonenumber'], 'Вы получили заказ на сумму: '.ContentModule::sumprice().' р', Yii::app()->name);
                $order->save();
                Yii::app()->user->setFlash('Order saved', $flashmessage);
                $order->saveOrder($items, $order);                
                unset(Yii::app()->session['id']);  
            }
        }
        $this->render('contactform', array('model' => $order));
    }  
    
    public function actionContactform()
    {
        $order = new Order;
        if(isset(Yii::app()->db->lastInsertID))
        {
            var_dump(Yii::app()->db->lastInsertID);die();
            $model = $order->findByPk(Yii::app()->db->lastInsertID);        
        }
        else  $model = $order;            
    }
    
    public function actionDeleteorderitem()
    {
      if ( !isset($_GET['item']) || !isset($_GET['subitem']) )
        throw new CHttpException(403, 'Доступ запрещен');   
      
      if(isset(Yii::app()->session['id'])){
        $session =  Yii::app()->session['id'];
        unset( $session [ $_GET['item']][ $_GET['subitem']]);
        $this->redirect("/store/cart");
      }
    }
}

?>
