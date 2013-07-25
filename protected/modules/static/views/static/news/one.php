<div class="span6" itemscope itemtype="http://schema.org/Article">
<?php
$this->breadcrumbs=array(
	'Новости'=>array('/static/static/news'),
);
?>
<?php
if(Yii::app()->user->hasFlash('news saved')) :
{ ?>
   <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('news saved');?></div>
<?php }
else :
?> 
<?php 
$date = explode(' ', $model->date);
$newdmy = array_reverse(explode('-', $date[0]));
echo implode('.', $newdmy);
unset($date, $newdmy);
?>
<br />
<p>
<h1><span itemprop="name"><?=$model->caption;?></span></h1>
    <span itemprop="articleBody">
        <?=$model->text;?>
    </span>
</p>
<?php 
    if(Yii::app()->getModule('user')->isAdmin())
            echo CHtml::link('Редактировать',array('/static/static/editnews/id/'.$model->id), array('class' => 'btn btn-small btn-inverse'));
    
?> 
<?php endif; ?>
</div>