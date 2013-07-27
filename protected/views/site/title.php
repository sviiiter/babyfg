<div id="slider_w1">
  <?php $this->widget('MainCentral'); ?>
</div>
<div class="horizontal-root">
  <?php $this->widget('HorizontalSlider', array(
    'widgettheme' => '',
    'sliderId'  =>  'slider_main'
  )); ?>
</div>
<div class="grafic-menu row">
  <?php $this->widget('GraficMenu'); ?>
</div>
<div class="news">
  <?php $this->widget('application.modules.static.widgets.NewsBlock'); ?>
  <h3>О нашем магазине</h3>
  <p><?php $widget = $this->widget('application.modules.static.widgets.TextIndex'); ?></p>
</div>