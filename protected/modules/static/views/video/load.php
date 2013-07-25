<?php
$this->breadcrumbs=array(
        'Загрузить видео'
);
?>
<h1><?=$this->pageTitle?></h1>
<?php if(Yii::app()->user->hasFlash('baner saved')) :
         echo Yii::app()->user->getFlash('baner saved');
      else :
 echo CHtml::beginForm('', 'post',array('enctype'=>'multipart/form-data'));?>
<div class="span7">  
<?php echo CHtml::errorSummary($model,'<div class="alert alert-error span4">','</div>'); ?>
    <br/>
<div class="row">
<?php echo CHtml::activeLabel($model,'embedlink'); ?>
<?php echo CHtml::activeTextField($model,'embedlink', array('rows'=>'23', 'class'=>'input-xxlarge')); ?>
</div>          
<br/>  
<br/>
<div class="row">
        <?php echo CHtml::activeLabel($model,'imglink'); ?>
        <?php echo CHtml::activeFileField($model,'imglink',array('size'=>60,'maxlength'=>128)); ?>        
</div> 
<br/>
<div class="row">
<?php echo CHtml::submitButton('Сохранить', array('class'=>'btn btn-small btn-inverse')); ?>
</div>            
</div> 
<?php echo CHtml::endForm(); ?>
<?php endif; ?>