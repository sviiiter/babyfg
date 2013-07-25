<div id="sl_wrap" itemscope itemtype="http://schema.org/ImageObject">
    <ul id="slider1">
    <?php $central = $this->widget('application.modules.static.widgets.Central'); ?>
    </ul>
</div>

<div id="sl_wrap2">
    <ul id="slider2">
    <?php foreach ($model as $item) :?>
    <div itemscope itemtype="http://schema.org/ImageObject">
    <li>
    <?php          
        $picture = '/baners/thumbs/'.$item->pic_name;               
        if(strlen($item->pic_name)<=0 || !file_exists(Yii::getPathOfAlias('webroot').$picture))
            $picture = '/images/nofoto.png';       
    ?>  
    
    <a href="/store/<?=$item->id?>" itemprop="url" style="text-decoration:none; color: black"><img itemprop="contentURL" height="60px" width="50px" src="<?=$picture;?>" /><p><?=$item->price1?> р</p></a>
    </li>
    </div>
    <?php endforeach; ?>    
    </ul>
</div>    
    
<script>
  $('#slider1').bxSlider({
  mode: 'horizontal',
  controls: false,
  auto: true,
  autoControls: false,
  pause: 7000
});

  $('#slider2').bxSlider({
  mode: 'horizontal',
  minSlides: 4,
  maxSlides: 5,
  slideWidth: 20,
  slideMargin: 0  
});
</script>