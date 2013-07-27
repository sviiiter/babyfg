<ul id="<?php echo $this->sliderId; ?>" class="horizontal">
  <?php foreach ($model as $item): ?>
    <li>
      <a href="#">
        <div class="sl2_item border-radiused">
          <div data="<?php echo ((isset($filename)) ? '/image/' . $item->cover[0]->picname : '/images/nofoto.png') ?>" class="preview">
            <?php echo RenderPieces::createImg( ( ($item->cover) ? $item->cover[0]->picname : false), false, false, array('class' => 'img-item')); ?>
          </div>
          <div class="price"><?php echo $item->price1; ?></div>
          <img class="buy-button" src="/css/but-kupit.jpg" alt="" />
        </div>
      </a>
    </li>		      
  <?php endforeach; ?>		
</ul>
<?php
  Yii::app()->clientscript->registerScript($this->sliderId,'
		  $(\'#' . $this->sliderId . '\').bxSlider({
			  mode: \'horizontal\',
			  minSlides: 3,
			  maxSlides: 3,
			  slideWidth: 150,
			  slideMargin: 0,
			  moveSlides: 1,
			});	      
  '); 
?>