<h1>Загрузить баннер</h1>
<?php
if(Yii::app()->user->hasFlash('baner saved')) :
{ ?>
     <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('baner saved');?></div>
<?php }
else :
?>


<?php echo CHtml::beginForm('', 'post',array('enctype'=>'multipart/form-data')); ?>
<br/>
<span style="color:yellow"><?php echo '* '.Yii::app()->user->getFlash('set W H');?></span>
<br/>
<br/>
<div>    
<?php echo CHtml::errorSummary($model,'<div class="alert alert-error span4">','</div>'); ?>
<br/>
  <?php echo CHtml::activeLabel($model,'image'); ?>
  <?php echo CHtml::activeFileField($model,'image',array('size'=>60,'maxlength'=>128)); ?>        
</div> 

<div> <!--class="row buttons"-->
        <?php echo CHtml::submitButton('Загрузить', array('class' => 'btn btn-inverse')); ?>
</div>
<?php echo CHtml::endForm();  ?>
<?php endif;?>