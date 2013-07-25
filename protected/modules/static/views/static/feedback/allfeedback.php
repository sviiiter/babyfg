<?php
$this->breadcrumbs=array(
	'Все сообщения',
);
?>
<h1>Все сообщения</h1>
<div class="span6">
<?php foreach ($model as $value) : ?>
<p>
<?php 
$date = explode(' ', $value->date);
$newdmy = array_reverse(explode('-', $date[0]));
echo implode('.', $newdmy).' '.$date[1];
unset($date, $newdmy);
?>
&nbsp;&nbsp;&nbsp;&nbsp;<?=$value->name;?>&nbsp;(<?=$value->email;?>,&nbsp;<?=$value->phone;?>)
<br/>
<?php
echo CHtml::link(substr($value->text, 0 , 120).'...', '/static/static/allfeedback/id/'.$value->id);
?>
<br/>
</p>

<?php endforeach; ?>
<div class="pagintr">
<?php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
</div>
</div>