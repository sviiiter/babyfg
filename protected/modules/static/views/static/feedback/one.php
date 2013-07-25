<div class="span6">
<?php
$this->breadcrumbs=array(
	'Все сообщения'=>array('/static/static/allfeedback'),
        'Сообщение'
);
?>
<h1>Сообщение</h1>    
<?php
if(Yii::app()->user->hasFlash('mess deleted')) :
{ ?>
   <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('mess deleted');?></div>
<?php }
else :
?> 
<?php 
$date = explode(' ', $model->date);
$newdmy = array_reverse(explode('-', $date[0]));
echo implode('.', $newdmy).' '.$date[1];
unset($date, $newdmy);
?>
<br />
<p>
&nbsp;&nbsp;&nbsp;&nbsp;<?=$model->name;?>&nbsp;(<?=$model->email;?>,&nbsp;<?=$model->phone;?>)
    <p>
    <?=$model->text;?>
    </p>   
</p>
<?php 
   echo CHtml::link('Удалить',array('/static/static/deletefeed/id/'.$model->id), array('class' => 'btn btn-small btn-danger'));    
?> 
<?php endif; ?>
</div>