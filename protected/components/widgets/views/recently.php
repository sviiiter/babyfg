<?php if ($tovar): ?>
  <?php foreach ($tovar as $value): ?>
    <li>
      <a href="/store/<?php echo $value->id; ?>"><?=CHtml::image((isset($value->pictures[0]->picname)) ? '/image/thumbs_middle/' . $value->pictures[0]->picname : '/images/nofoto.png', '', array('class' => 'border-radiused')); ?></a>
    </li>
  <?php endforeach; ?>   
<?php endif; 
 Yii::app()->clientscript->registerScript('vertical','
    $(\'#slider_vertical\').bxSlider({
      mode: \'vertical\',
      minSlides: 15,
      maxSlides: 15,
      slideWidth: 150,
      slideMargin: 10,
      moveSlides: 1,
      nextText: \'\',
      prevText: \'\',
      nextSelector: \'#vertical-slider-next\',
      prevSelector: \'#vertical-slider-prev\',
    });	
');?>