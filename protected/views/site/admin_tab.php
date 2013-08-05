<?php 
  if (!Yii::app()->user->isGuest && Yii::app()->getModule('user')->isAdmin()) {
    $this->widget('bootstrap.widgets.TbNavbar', array(
      'type'  =>  null, // null or 'inverse'
      'brand' =>  Yii::app()->name,
      'brandUrl'  =>  $this->createUrl('/'),
      'collapse'  =>  true, // requires bootstrap-responsive.css
      'items' =>  array(
        array(
          'class' =>  'bootstrap.widgets.TbMenu',
          'items' =>  array(
            array('label' =>  'Главная', 'url'=>"#", 
              'items'=>array(
                array('label' =>  'Редактировать нижний текст', 'url'=>array('/static/proposals/maintext')),
                array('label' =>  'Центральный баннер', 'url'=>array('/static/proposals/centerprop')),
            )),            
            array('label' =>  'Левая колонка', 'url'=>"#", 
              'items' => array(
                array('label' =>  'Левое меню', 'url'=>array('/manage/manage/CreateMenuItem')),    
                array('label' =>  'Баннеры слева,под меню', 'url'=>array('/static/proposals/leftprop')),                  
            )), 
            array('label' =>  'Каталог', 'url'=>"#", 
              'items'=>array(
                array('label' =>  'Добавить товар', 'url'=>array('/manage/manage/edititem')),
            )),     
            array('label' =>  'Новости', 'url'=>"#", 
              'items'=>array(
                array('label' =>  'Добавить новость', 'url'=>array('/static/static/addnews')),
            )),             
          ),
        ),
        array(
          'class' =>  'bootstrap.widgets.TbMenu',
          'htmlOptions' =>  array('class' =>  'pull-right'),
          'items' =>  array(
            array('label' =>  'Последние заказы', 'url'=>array('/manage/manage/orders/all/all')),   
            array('label' =>  'Личный кабинет', 'url'=>array('/user/profile')),   
            array('label' =>  'Управление пользователями', 'url'=>array('/user/admin')),   
            array('label' =>  'Выйти', 'url'=>array('/logout'))        
          )
        )
      ),
    )); 
  }