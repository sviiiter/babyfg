<h1>Править новость</h1>
<?php
if(Yii::app()->user->hasFlash('news saved')) :
{ ?>
   <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('news saved');?></div>
<?php }
else :
?> 

<div class="span4">
    <?php echo CHtml::beginForm(); ?>
    <div class="span5">  
  
    <?php echo CHtml::errorSummary($model,'<div class="alert alert-error span4">','</div>'); ?>
        <br/>
    <div class="row">
    <?php echo CHtml::activeLabel($model,'caption'); ?>
    <?php echo CHtml::activeTextField($model,'caption',array('class'=>'input-xlarge')); ?>
    </div>        

        
    <div class="row">
    <?php echo CHtml::activeLabel($model,'text'); ?> 
    <?php echo CHtml::activeTextArea($model,'text', array('rows'=>5, 'class'=>'input-xlarge')); ?>
    </div>    
    <div class="row">
    <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn btn-small btn-inverse')); ?>
    </div>            
        
    <?php echo CHtml::endForm(); ?>
    </div>
</div>
<?php endif; ?>