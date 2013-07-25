<?php
$this->breadcrumbs=array(
        'Спортивное питание'=>'/store',
	'Корзина'=>'/store/cart',
        'Контактная информация'
);
?>
<?php
if(Yii::app()->user->hasFlash('Order saved')) :
{ ?>
   <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('Order saved');?></div>
<?php }
else : ?>

<h1>Контактная информация</h1>
<div class="span5">
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($model,'<div class="alert alert-error span4">','</div>'); ?>
<br/>
<div class="row">
<?php echo CHtml::activeLabel($model,'person'); ?> 
<?php echo CHtml::activeTextField($model,'person', array('class'=>'input-xlarge')); ?>
</div>
<div class="row">
<?php echo CHtml::activeLabel($model,'phone'); ?> 
<?php echo CHtml::activeTextField($model,'phone', array('class'=>'input-xlarge')); ?>
</div>

<div class="row">
<?php echo CHtml::activeLabel($model,'adress'); ?> 
<?php echo CHtml::activeTextArea($model,'adress', array('rows'=>'4', 'class'=>'input-xlarge')); ?>
</div>    


<div class="row">
<?php echo CHtml::activeLabel($model,'email'); ?> 
<?php echo CHtml::activeTextField($model,'email', array('class'=>'input-xlarge')); ?>
</div>

<div class="row">
<?php echo CHtml::activeLabel($model,'additionalinfo'); ?> 
<?php echo CHtml::activeTextArea($model,'additionalinfo', array('rows'=>'4', 'class'=>'input-xlarge')); ?>
</div>    
<div class="row">
<?php echo CHtml::submitButton('Отправить', array('class'=>'btn btn-small btn-inverse')); ?>
</div>            
<?php echo CHtml::endForm(); ?>
</div>
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru"
 data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

></div> 

<?php endif;?>