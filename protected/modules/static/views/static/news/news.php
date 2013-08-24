<h1>Новости</h1>
<div class="span6">
<?php $i = 0;foreach ($model as $value) : ?>
<p>
<div style="word-wrap:break-word;">
    <h3><?php echo Yii::app()->dateFormatter->formatDateTime($value->date, 'short', null); ?></h3>
	  <?php echo CHtml::link($value->text, '/news/' . $value->id, array('style' => 'color:gray;font-size: 20px;','itemprop' => 'url')); ?>
</div>
<br/>
</p>

<?php endforeach; ?>
<div class="pagintr">
<?php //$this->widget('CLinkPager', array( 'pages'=>$pages));
?>
</div>
</div>