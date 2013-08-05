<?php $this->breadcrumbs=array('Магазин'=>'/store', 'Корзина',); ?>
<h1>Корзина</h1>
<div id="notificate" class="alert-success"></div>
<?php if (Yii::app()->user->hasFlash('empty items')): ?>
  <div class="alert alert-block span5"><?=Yii::app()->user->getFlash('empty items');?></div> 
<?php elseif ( Yii::app()->user->hasFlash('Order saved')): ?>
  <div class="alert alert-block span5"><?=Yii::app()->user->getFlash('Order saved');?></div>
<?php else: ?>
  <?php foreach ($model as $item): ?>    
    <div class="tovar_cart border-radiused">  
      <?php echo CHtml::link(RenderPieces::createImg( (isset($item->cover[0]->picname)) ? $item->cover[0]->picname : false ), '/store/' . $item->id); ?>
      <div class="textd">
        <p>Наименование : <?=$item->name;?></p>
        <p>Цена : <?=$item->price;?></p>                
      </div>
      <?php foreach ($items[$item->id] as $p_k => $properties): ?>
        <b><?php echo ($properties['param1']) ? $item->custom1 . ':' . $item->customfield1[ $properties['param1']]->name : ''; ?></b>
        <b><?php echo ($properties['param2']) ? $item->custom2 . ':' . $item->customfield2[ $properties['param2']]->name : ''; ?></b>
        <p>Количество: <?php echo CHtml::textField('quantity', $properties['quantity'], array(
          'class' => 'input-mini',
          'onchange' =>  '
            $q = $(this).val();
            js: $.get(\'/store/saveitem\',{item: \'' . $item->id . '\', subitem: \'' . $p_k . '\', quantity: $q,  },function(data){
              var data = JSON.parse(data);
              $(\'#notificate\').html(data.message).show(700).hide(700);
            });                
          '  
        )) ?>
        <!--?php echo CHtml::button('Сохранить', array('id' => 'b' . $item->id, 'class'=>'btn btn-small btn-inverse')); ?-->     
        <?php echo CHtml::link('Удалить из корзины', array('/store/deleteorderitem/', 'item' => $item->id, 'subitem' => $p_k), array(
          'class'=>'deletecart'
        )); ?></p>        
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
  <div class="row span1 alert alert-block" style="position:fixed; right: 0px; top: 250px;z-index:4242">Суммарная стоимость: <div id="sumprice"><span style="font-size: 22px;"><?=$sumprice?>&nbsp;р</span></div></div>
  <div class="pagintr">
  <?php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
  </div>
  <div class="orderlink">
    <?php
      if ( isset(Yii::app()->session['id']) && Yii::app()->session['id'])
        echo CHtml::link('Оформить', '/store/saveorder', array('class' => 'btn btn-large btn-info'));       
    ?>
  </div>
<?php endif;?>
<?php Yii::app()->clientscript->registerCssFile('/css/cart.css'); ?>
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru"
 data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

></div> 