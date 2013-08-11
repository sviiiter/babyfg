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
      <?php if ($value->pictures): ?>
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
      <?php else: ?>
        <?php echo CHtml::image( '/image/pattern/nofotobig.png', null, array('style' => 'display:block; margin:0 auto;')); ?>
      <?php endif; ?>
    </div>
    <div class="description">
      <h1><?=$subject?></h1>
      <span class="fontsize26">
        <p>Артикул: <?=$value->artikul; ?></p>
        <p>Коллекция: <?=$value->country; ?></p>
        <p style="margin-top:0px;">Описание</p>
        <?=$value->description; ?>
      </span>		        
      <?php echo CHtml::beginForm('', 'post', array('id' => 'item-params')); ?>
      <?php echo CHtml::dropDownList('first_param', null, CHtml::listData( ($value['cus1_values']) ? $value['cus1_values'] : new Customfield, 'id', 'name'),
        array('empty' => 'Выбрать ' . $value->custom1, 'class'  =>  'border-radiused-wout-sh')
      ); ?>
      <?php echo CHtml::dropDownList('second_param', null, CHtml::listData( ($value['cus2_values']) ? $value['cus2_values'] : new Customfield, 'id', 'name'),
        array('empty' => 'Выбрать ' . $value->custom2, 'class'  =>  'border-radiused-wout-sh')
      ); ?>
      <?php echo CHtml::dropDownList('quantity', null, array(
          '1'  =>  '1',
          '2'  =>  '2',
          '3'  =>  '3',
          '4'  =>  '4',
          '5'  =>  '5',
        ),
        array('empty' => 'Выбрать количество', 'class'  =>  'border-radiused-wout-sh')
      ); ?>      
      <?php echo CHtml::endForm(); ?>
      <div class="tovar-price row">
        <div class="fontsize26 span1 prices-top">Цена:</div>
        <div class="prices span2 prices-top">
          <?php echo $value->blockprice; ?>
        </div>
      </div>
    </div>
  </div>  
  <div class="row">
    <div class="availability span4">
      <!-- if ((int)$value->instore === 0): >
        <div class="alert alert-error border-radiused-wout-sh"><br/>Нет в наличии</div>
      < endif; ?-->
    </div>
    <div class="buy-large span2">
      <?php $rand = rand(); 
        echo ((int)$value->instore === 1) 
          ? CHtml::ajaxLink('<img src="/css/buy_large.png" />',array('/store/Addtovartocart', 'id'=>$value->id), 
              array(
                'type' => 'GET',
                'cache' => true,
                'data'  =>  'js: $(\'#item-params\').serialize()',
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
            )) 
          : CHtml::image('/css/not_in_store.png');       
      ?>       
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
<div class="horizontal-root">
  <?php $this->widget('HorizontalSlider', array(
    'widgettheme' => 'recommended',
    'sliderId'  =>  'slider_w4'
  )); ?>
</div>
<div class="fontsize39">Хиты продаж:</div>
<div class="horizontal-root">
  <?php $this->widget('HorizontalSlider', array(
    'caption' => 'Хиты продаж:',
    'fontclass' => 'fontsize39',
    'widgettheme' => 'hits',
    'sliderId'  =>  'slider_w5'
  )); ?>
</div>

<?php 
  Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/js/fancybox/source/jquery.fancybox.css', 'screen, projection'); 
  Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/css/tovar.css', 'screen, projection');
  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancybox/source/jquery.fancybox.pack.js');
  Yii::app()->clientscript->registerScript('bxsl','
    $(".fancybox").fancybox({
				openEffect:"fade" 
    });

    $(".item-pic").bxSlider({
      pagerCustom: "#bx-pager"
    });    
  ');  
?>

