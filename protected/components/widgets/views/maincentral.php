<ul id="slider1">
  <?php foreach ($model as $img): ?>
    <li>
      <?php echo CHtml::image( '/image/maincentral/' . $img->image, null, array('width' => '100%')); ?>
    </li>		
  <?php endforeach; ?>
</ul>
<?php Yii::app()->clientscript->registerScript('maincentral','
      $(\'#slider1\').bxSlider({
			  mode: \'horizontal\',
			  controls: false,
			  auto: true,
			  autoControls: false,
			  pause: 7000,
        infiniteLoop: true
			});	  
'); ?>