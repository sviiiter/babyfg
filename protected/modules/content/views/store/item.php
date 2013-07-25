<?php     
  $subject = '';
  $subject .= $value->name;
  $this->breadcrumbs=array(
    'Магазин'=>'/store',
    $subject,
  );    
?>
<div class="tovar-wrap">
  <div class="row">
    <div class="mypreview">
      <ul class="item-pic">
        <?php foreach ($value->pictures as $pic): ?>
          <a class="fancybox" rel="group" href="<?='/image/' . $pic->picname?>"><li><?=Sender::Imgrenderer('/image/' . $pic->picname, $subject)?></li></a>
        <?php endforeach; ?>
      </ul>
      <div id = "bx-pager">
        <?php $i = 0; foreach ($value->pictures as $pic): ?>           
          <a data-slide-index="<?=$i; ?>" href=""><?=Sender::Imgrenderer('/image/thumbs/' . $pic->picname, $subject)?></a>
        <?php $i++; endforeach; ?>
      </div>               
      <div id="empty-sel1"></div>
      <div id="empty-sel2"></div>
    </div>
    <div class="description">
      <h1><?=$subject?></h1>
      <span class="fontsize26">
        <p>Артикул: <?=$value->artikul; ?></p>
        <p>Производитель: <?=$value->country; ?></p>
      </span>
      <span class="desc">
        <span class="fontsize26">
          Описание
        </span>		
        <?=$value->description; ?>
      </span>
      <?php echo CHtml::dropDownList('first_param', null, CHtml::listData( ($value['cus1_values']) ? $value['cus1_values'] : new Customfield, 'id', 'name'),
        array('empty' => 'Выбрать ' . $value->custom1, 'class'  =>  'border-radiused-wout-sh')
      );?>
      <?php echo CHtml::dropDownList('first_param', null, CHtml::listData( ($value['cus2_values']) ? $value['cus2_values'] : new Customfield, 'id', 'name'),
        array('empty' => 'Выбрать ' . $value->custom2, 'class'  =>  'border-radiused-wout-sh')
      );?>      
      <div class="tovar-price row">
        <div class="fontsize26 span1 prices-top">Цена:</div>
        <div class="prices span2 prices-top">
          <div class="oldprice"><?= intval($value->price1); ?> р</div>
          <div class="newprice"><?= intval($value->price2); ?> р</div>
        </div>
      </div>
    </div>
  </div>  
  <div class="row">
    <div class="availability span4">
      <?php if ((int)$value->instore === 1): ?>
        <div class="alert alert-error border-radiused-wout-sh"><br/>Нет в наличии</div>
      <?php endif; ?>
    </div>
    <div class="buy-large span2">
      <?php $rand = rand(); 
        echo CHtml::ajaxLink('<img src="/css/buy_large.png" />',array('/store/Addtovartocart', 'id'=>$value->id), 
          array(
            'type' => 'GET',
            'cache' => true,                                    
            'success' => '
              function(data)
              {
                data = JSON.parse(data);
                $("#' . $rand . '").html(data.myimg);
                $(".quan").html(data.session_count);
              }
              '
            ),
            array(
                'id' => $rand,
                'class'=>'alink'                
        )); ?>       
    </div>
  </div>
  <p>
    <div class="row">
      <?php
        if(Yii::app()->getModule('user')->isAdmin())
            echo CHtml::link('править', '/index.php/manage/manage/edititem/id/'.$value->id, $htmlOptions=array('class'=>'editlink btn btn-small btn-danger'));
      ?>       
    </div>
  </p>
</div>
     
<div class="fontsize26">Мы рекомендуем:</div>
<div id="slider_w2" class="horizontal-root">
  <ul id="slider2" class="horizontal">
    <li>
      <a href="#2">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/1.jpg" class="preview"><img class="img-item" src="pics/1.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>
    <li>
      <a href="#3">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/2.jpg" class="preview"><img class="img-item" src="pics/2.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>	
    <li>
      <a href="#2">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/1.jpg" class="preview"><img class="img-item" src="pics/1.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>
    <li>
      <a href="#3">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/2.jpg" class="preview"><img class="img-item" src="pics/2.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>		
    <li>
      <a href="#2">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/1.jpg" class="preview"><img class="img-item" src="pics/1.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>
    <li>
      <a href="#3">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/2.jpg" class="preview"><img class="img-item" src="pics/2.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>						
  </ul>
</div>	
<div class="fontsize39">Хиты продаж:</div>
<div id="slider_w2" class="horizontal-root">
  <ul id="slider3" class="horizontal">
    <li>
      <a href="#2">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/1.jpg" class="preview"><img class="img-item" src="pics/1.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>
    <li>
      <a href="#3">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/2.jpg" class="preview"><img class="img-item" src="pics/2.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>	
    <li>
      <a href="#2">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/1.jpg" class="preview"><img class="img-item" src="pics/1.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>
    <li>
      <a href="#3">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/2.jpg" class="preview"><img class="img-item" src="pics/2.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>		
    <li>
      <a href="#2">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/1.jpg" class="preview"><img class="img-item" src="pics/1.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>
    <li>
      <a href="#3">
        <div class="sl2_item border-radiused">
          <span class="cap-img-item">Шарф и шапка обыкновенные</span>
          <div data="pics/2.jpg" class="preview"><img class="img-item" src="pics/2.jpg" alt="" /></div>
          <div class="price">5000 р</div>
          <img class="buy-button" src="css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>							
  </ul>
</div>			
<?php 
  Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/js/fancybox/source/jquery.fancybox.css', 'screen, projection'); 
  Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/css/tovar.css', 'screen, projection');
  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancybox/source/jquery.fancybox.pack.js');
  Yii::app()->clientscript->registerScript('bxsl','
		  $(\'#slider3\').bxSlider({
			  mode: \'horizontal\',
			  minSlides: 3,
			  maxSlides: 3,
			  slideWidth: 150,
			  slideMargin: 0,
			  moveSlides: 1,
			});	    

    $(".fancybox").fancybox({
				openEffect:"fade" 
    });

    $(".item-pic").bxSlider({
      pagerCustom: "#bx-pager"
    });    
  ');  
?>
