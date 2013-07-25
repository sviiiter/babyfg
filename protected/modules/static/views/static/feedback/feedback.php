<?php
$this->breadcrumbs=array(
	'Задать вопрос',
);
?>
<h1>Задать вопрос</h1>
<?php
if(Yii::app()->user->hasFlash('feed saved')):
{
    ?>
<br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('feed saved');?></div>
<?php
}
else :
{
?> 

<div class="span4">
    <?php echo CHtml::beginForm(); ?>
    <div class="span5">         
    <?php if(Yii::app()->user->isGuest) :?>        
    <div class="row">
    <?php echo CHtml::activeLabel($model,'name'); ?>
    <?php echo CHtml::activeTextField($model,'name',array('class'=>'input-xlarge')); ?>
    </div>   
        
    <div class="row">
    <?php echo CHtml::activeLabel($model,'email'); ?>
    <?php echo CHtml::activeTextField($model,'email',array('class'=>'input-xlarge')); ?>
    </div>         
        
    <div class="row">
    <?php echo CHtml::activeLabel($model,'phone'); ?>
    <?php echo CHtml::activeTextField($model,'phone',array('class'=>'input-xlarge')); ?>
    </div>     
    <?php endif; ?> 
        
    <div class="row">
    <?php echo CHtml::activeLabel($model,'text'); ?> 
    <?php echo CHtml::activeTextArea($model,'text', array('rows'=>5, 'class'=>'input-xlarge')); ?>
    </div>    
    <div class="row">
    <?php echo CHtml::submitButton('Отправить', array('class'=>'btn btn-small btn-inverse')); ?>
    </div>  
    <br/>
    <?php echo CHtml::errorSummary($model,'<div class="alert alert-error span4">','</div>'); ?>
            
    <?php echo CHtml::endForm(); ?>
    </div>
</div>
<?php } endif; ?>
<?php
if(Yii::app()->getModule('user')->isAdmin())
    {
        echo CHtml::link('Все', '/static/static/allfeedback', array('class'=>'btn btn-info', 'style' => 'margin-top: 20px;'));
    }
?>