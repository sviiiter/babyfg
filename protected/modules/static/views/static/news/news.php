<h1>Новости</h1>
<div class="span6">
<?php foreach ($model as $value) : ?>
<p>
<?php 
$date = explode(' ', $value->date);
$newdmy = array_reverse(explode('-', $date[0]));
echo implode('.', $newdmy);
unset($date, $newdmy);
?>
<br/>
<div>
    <?php
    echo CHtml::link(substr($value->text, 0 , 120).'...', '/news/' . $value->id, array('style' => 'color: gray','itemprop' => 'url'));
    ?>
</div>
<br/>
</p>

<?php endforeach; ?>
<div class="pagintr">
<?php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
</div>
</div>