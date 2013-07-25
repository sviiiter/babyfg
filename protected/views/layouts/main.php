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
  <meta name="description" lang="ru" content="<?=(isset($this->description)) ? $this->description : 'Спортивный магазин питания в Москве, м. Преображенская площадь. Доставка по всей России.'?>" />
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
              <div class="sl_menu"><?php $this->widget('application.modules.content.widgets.Menu');?></div>				
              <div class="banners">
                <img src="img/left1.jpg" />
                <img src="img/left2.jpg" />
                <img src="img/left1.jpg" />
                <img src="img/left2.jpg" />
                <img src="img/left1.jpg" />
                <img src="img/left2.jpg" />					
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
			<ul class="navigate">
				<li>
					<a href="#2">ГЛАВНАЯ</a>
				</li>
				<li>
					<a href="#2">НОВОСТИ</a>
				</li>	
				<li>
					<a href="#2">КАТАЛОГ</a>
				</li>
				<li>
					<a href="#2">РАЗМЕРЫ</a>
				</li>
				<li>
					<a href="#2">ОПЛАТА И ДОСТАВКА</a>
				</li>
				<li>
					<a href="#2">КОНТАКТЫ</a>
				</li>					
			</ul>
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
		<div class="development clear">Разработка сайта <a href="#">freakmark</a></div>
    </div>
    <!--Header-->
    <div id="header">
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
          array('label' =>  'Левое меню', 'url'=>array('/manage/manage/CreateMenuItem')),
          array('label' =>  'Каталог', 'url'=>"#", 
            'items'=>array(
              array('label' =>  'Добавить товар', 'url'=>array('/manage/manage/edititem')),
        )),        
        ),
      ),
      array(
        'class' =>  'bootstrap.widgets.TbMenu',
        'htmlOptions' =>  array('class' =>  'pull-right'),
        'items' =>  array(
          array('label' =>  'Выйти', 'url'=>array('/logout'))        
        )
      )
    ),
  )); 
}
?>        
        <div class="wrap clear">
          <!--Logo-->
          <div class="phones">
            <p><span>+7</span> 495 777 33 22</p><br/>
            <p><span>+7</span> 926 444 55 33</p>
          </div>
          <!--Links-->
          <div class="links clear">
            <div class="right clear">
              <!--a href="#" class="enter"><span class="point-left">Войти</span> <span class="point">.</span> <span class="point-right">Регистрация</span></a-->
              <?php echo CHtml::link('Личный кабинет', array('/user/admin'), array('class' => 'enter')); ?>
              <!--a href="#" class="enter">Личный кабинет</a-->
              <div class="link"><a id="cart" href="#22"><div class="quan">2</div></a></div>
            </div>
          </div>
          <div class="lenta">
            <?php $this->widget('zii.widgets.CMenu',array(
              'htmlOptions' => array('class' => 'navigate'),
              'items'=>array(
                array('label'=>'ГЛАВНАЯ', 'url'=>array('/site/index'),'itemOptions' => array('id'=>'m1')),
                array('label'=>'НОВОСТИ', 'url'=>array('/news'), 'itemOptions' => array('id'=>'m2')),
                array('label'=>'КАТАЛОГ', 'url'=>array('/store'),'itemOptions' => array('id'=>'m3')),
                array('label'=>'РАЗМЕРЫ', 'url'=>array('/static/static/razmeri'),'itemOptions' => array('id'=>'m4')),
                array('label'=>'ОПЛАТА И ДОСТАВКА', 'url'=>array('/static/static/payment'),'itemOptions' => array('id'=>'m4')),
                array('label'=>'КОНТАКТЫ', 'url'=>array('/static/static/contacts'),'itemOptions' => array('id'=>'m4')),
              ),
            )); ?>
          </div>		  
        </div>
    </div>
	<script>
	jQuery(document).ready(function() {
		  $('#slider1').bxSlider({
			  mode: 'horizontal',
			  controls: false,
			  auto: true,
			  autoControls: false,
			  pause: 7000
			});	
		  $('#slider2').bxSlider({
			  mode: 'horizontal',
			  minSlides: 3,
			  maxSlides: 3,
			  slideWidth: 150,
			  slideMargin: 20,
			  moveSlides: 1,
			  auto: true,
			  autoControls: false,
			  pause: 7000			  
			  /*nextText: '&nbsp',
			  prevText: '&nbsp',
			  nextSelector: '#tops-slider-next',
			  prevSelector: '#tops-slider-prev',	*/		  
			  //prevSelector: 'hui'
			});		
	});
	</script>
</body>
</html>