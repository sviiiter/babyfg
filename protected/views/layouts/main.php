<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!--link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="css/main.css" /-->	
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=PT+Sans|PT+Sans+Narrow:400,700&amp;subset=cyrillic,latin" />
    <!--[if lt IE 7]>
        <link rel="stylesheet" type="text/css" href="css/ie.css">
    <![endif]-->
  <style>
  </style>
  <!--link rel="stylesheet" type="text/css" href="bxslider/jquery.bxslider.css" media="screen, projection" />
  <link rel="stylesheet" type="text/css" href="css/bx_s.css" media="screen, projection" /-->
  <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script-->
  <!--script src="cssglobe/main.js"></script-->	
  <!--script type="text/javascript" src="bxslider/jquery.bxslider.min.js"></script>	
  <script type="text/javascript" src="js/bootstrap.js"></script-->    
  <?php Yii::app()->bootstrap; ?>  
  <meta name="keywords" lang="ru" content="<?php echo Yii::app()->controller->addwords_start;?>" /> 
  <meta name="description" lang="ru" content="<?=(isset($this->description)) ? $this->description : 'Магазин детской одежды. Доставка по всей России.'?>" />
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">  
  <!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script-->
  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/bxslider/jquery.bxslider.min.js'); ?>
  <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/tinymce/jscripts/tiny_mce/tiny_mce.js'); ?>
  <?php Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/bxslider/jquery.bxslider.css', 'screen, projection'); ?> 
  <?php Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css', 'screen, projection'); ?>
  <?php Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/css/bx_s.css', 'screen, projection'); ?>     
	<script>
		function show (el) {
			if ($(el).parent().children('ul').css('display') == 'block') {
				$(el).parent().children('ul').hide();
			} else {
				$(el).parent().children('ul').show();
			}
		}
  </script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>                              
</head>
<body  itemscope itemtype="http://schema.org/WebPage">
    <!--Content-->
    <div id="content">
        <div class="clear">
            <!--Content center-->
            <div class="center">
                <div class="in">
                    <?php echo $content; ?>
                </div>
            </div>			
            <!--Content left-->
            <div class="sidebar_left">
              <div class="sl_menu"><?php $this->widget('application.modules.content.widgets.Menu', array('category' => $this->category));?></div>				
              <div class="banners">
                <?php $this->widget('leftBanners'); ?>
              </div>
            </div>
            <!--Content right-->
            <div class="sidebar_right">
				<span class="caption">
				Недавно просматривали:
				</span>
				<div class="vertical-sl-wrap">
					<div class="my-right my-controls">
						<div id="vertical-slider-next"></div>
						<div id="vertical-slider-prev"></div>
					</div>
					<div class="my-right">						
						<ul id="slider_vertical" class="photo">
              <?php $this->widget('recentlyInterested'); ?> 
						</ul>
					</div>
				</div>
			</div>
        </div>
        <div class="empty"></div>
	</div>
    <!--Footer-->
	<div id="footer">
		<div class="lenta">
      <?php $this->widget('zii.widgets.CMenu',array(
        'htmlOptions' => array('class' => 'navigate'),
        'items'=>array(
          array('label'=>'ГЛАВНАЯ', 'url'=>array('/site/index') , 'itemOptions' => array('id'=>'m1')),
          array('label'=>'НОВОСТИ', 'url'=>array('/static/static/news'), 'itemOptions' => array('id'=>'m2')),
          array('label'=>'КАТАЛОГ', 'url'=>array('/content/store/listbymenu'),'itemOptions' => array('id'=>'m3')),
          array('label'=>'РАЗМЕРЫ', 'url'=>array('/static/static/measurement'),'itemOptions' => array('id'=>'m4')),
          array('label'=>'ОПЛАТА И ДОСТАВКА', 'url'=>array('/static/static/payment'),'itemOptions' => array('id'=>'m4')),
          array('label'=>'КОНТАКТЫ', 'url'=>array('/static/static/contacts'),'itemOptions' => array('id'=>'m4')),
        ),
      )); ?>
		</div>		
        <!--List
        <div class="list">
            <div class="in">
                <ul>
                </ul>
            </div>
        </div-->
        <!--Copyright-->
        <div class="copyright">
            <div class="in">BABY FASHION GALLERY, 2013</div>
        </div>
		<div class="development clear">Разработка сайта <a href="mailto:Николай%20Сергеев%20&lt;freakmarkt@gmail.com&gt;">freakmark</a></div>
    </div>
    <!--Header-->
    <div id="header">
      <?php $this->renderPartial('//site/admin_tab'); ?>
        <div class="wrap clear">
          <!--Logo-->
          <div class="phones">
            <p><span>+7</span> 495 761 76 98</p><br/>
            <p><span>+7</span> 985 761 76 98</p>
          </div>
          <!--Links-->
          <div class="links clear">
            <div class="right clear">
              <!--a href="#" class="enter"><span class="point-left">Войти</span> <span class="point">.</span> <span class="point-right">Регистрация</span></a-->
              <?php echo CHtml::link('Личный кабинет', array('/user/profile'), array('class' => 'enter')); ?>
              <?php if (!Yii::app()->user->isGuest): ?>
              Вы зашли как:&nbsp;<?php echo Yii::app()->user->name; ?>&nbsp;<p>Статус: <?php echo Yii::app()->user->rolename[Yii::app()->user->role]; ?></p>
              <?php echo CHtml::link('Выйти', '/logout'); ?>
              <?php endif; ?>
              <!--a href="#" class="enter">Личный кабинет</a-->
              <div class="link"><a id="cart" href="/store/cart"><div class="quan">&nbsp;<?php echo sizeof(Yii::app()->session['id']);?></div></a></div>
            </div>
          </div>
          <div class="lenta">
            <?php $this->widget('zii.widgets.CMenu',array(
              'htmlOptions' => array('class' => 'navigate'),
              'items'=>array(
                array('label'=>'ГЛАВНАЯ', 'url'=>array('/site/index') , 'itemOptions' => array('id'=>'m1')),
                array('label'=>'НОВОСТИ', 'url'=>array('/static/static/news'), 'itemOptions' => array('id'=>'m2')),
                array('label'=>'КАТАЛОГ', 'url'=>array('/content/store/listbymenu'),'itemOptions' => array('id'=>'m3')),
                array('label'=>'РАЗМЕРЫ', 'url'=>array('/static/static/measurement'),'itemOptions' => array('id'=>'m4')),
                array('label'=>'ОПЛАТА И ДОСТАВКА', 'url'=>array('/static/static/payment'),'itemOptions' => array('id'=>'m4')),
                array('label'=>'КОНТАКТЫ', 'url'=>array('/static/static/contacts'),'itemOptions' => array('id'=>'m4')),
              ),
            )); ?>
          </div>		  
        </div>
    </div>
</body>
</html>