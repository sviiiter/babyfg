<?php
$this->breadcrumbs=array(
        'Магазин'=>'/store/listbybrand',
	'Добавить производителя',
);
?>
<h1>Добавить производителя</h1>
<div class="span6">
    <div>
<?php
    if(Yii::app()->user->hasFlash('item saved successufuly')):
    { ?>
<br/>
<div class="alert alert-block"><?=Yii::app()->user->getFlash('item saved successufuly');?></div>
  <?php  }
    else :
?>

<div class="form">
<?php echo CHtml::beginForm('', 'post',array('enctype'=>'multipart/form-data')); ?>
   
<div class="row">
<?php echo CHtml::activeLabel($model,'brand'); ?>
<?php echo CHtml::activeTextField($model,'brand',array('class'=>'input-xlarge')); ?>
</div>
    
 
<div class="row submit">
<?php echo CHtml::submitButton('Сохранить', array('class'=>'btn')); ?>
</div>
  <br/>
 <?php echo CHtml::errorSummary($model,'<div class="alert alert-error span4">','</div>'); ?>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>
</div>
</div>