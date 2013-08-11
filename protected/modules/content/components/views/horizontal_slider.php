<ul id="<?php echo $this->sliderId; ?>" class="horizontal">
  <?php foreach ($model as $item): ?>
    <li>
      <a href="/store/<?php echo $item->id; ?>">
        <div class="sl2_item border-radiused">
          <div data="<?php echo ((isset($filename)) ? '/image/' . $item->cover[0]->picname : '/image/pattern/nofoto.png') ?>" class="preview">
            <?php echo RenderPieces::createImg( ( ($item->cover) ? $item->cover[0]->picname : false), false, false, array('class' => 'img-item')); ?>
          </div>
          <div class="row down-horizontal">
            <div class="price"><?php echo $item->blockprice; ?></div>
            <img class="buy-button horizontal-buy" src="/css/but-kupit.jpg" alt="" />
          </div>
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
			  //auto: true,
			  autoControls: false,
			  //pause: 7000        
			});	      
  '); 
  Yii::app()->clientscript->registerCss('catalog','
    .newprice{float:left; margin-left:3px;color:red}
    .oldprice{float:left;text-decoration:line-through}
    .price{width:56%; height:17%;margin-top:10px;float:left}  
    .horizontal-buy{margin:0px auto auto 54% !important; float:left}
    .down-horizontal{margin-left:0px;height:59px}
  ');  
?>