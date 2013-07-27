<?php foreach ($menuitems as $menu): ?>
  <a href="/store/listbymenu/menu/<?php echo $menu->id; ?>">
    <div class="item">
      <?php echo CHtml::image('/image/menu/' . $menu->picture, '', array('class' => 'border-radiused')); ?>
    </div>
  </a>
<?php endforeach; ?>