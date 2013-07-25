<?php
  $this->breadcrumbs=array(
    'Магазин'=>'/store/listbybrand',
    'Редактировать товар'=>'/manage/manage/edititem/id/' . $g_id,
    'Редактировать дополнительный параметр'
  );
  $fieldname = ((int)$custom_id === Customfield::CUSTOM1) ? $tovar->custom1 : $tovar->custom2;
?>
<h1>Редактировать <?= $fieldname; ?></h1>
<div class="span6">
  <div class="form">
    <?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?> 
      <div class="span6"><?php echo CHtml::errorSummary($model, '<div class="alert alert-error span4">', '</div>'); ?></div>
      <br/>
      <div class="row">
        <?php echo CHtml::activeLabel($model, 'name'); ?> 
        <?php echo CHtml::activeTextField($model, 'name', array('class'=>'input-xlarge','placeholder'=>'Например: банановый, клубничный')); ?>
      </div>
      <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn btn-inverse offset1')); ?>
    <?php echo CHtml::endForm(); ?>
  </div>
<br/>
<?php if (Yii::app()->user->hasFlash('item saved successufuly')): ?>
  <br/><div class="alert alert-block span5"><?=Yii::app()->user->getFlash('item saved successufuly'); ?></div>         
<?php endif; ?>

</div>

<?php
if($g_id)
echo '&nbsp;' . CHtml::link('<<&nbsp;Вернуться', '/manage/manage/edititem/id/' . $g_id, array('style'=>'text-decoration:none;color: #942a25;'));
?>
<br/>
<br/>
<br/>
<?php
$titems = Customfield::model()->findAll('tovar_id = :tovar_id AND custom_id = :custom_id', array('tovar_id' => $g_id, 'custom_id' => $custom_id));
    if ($titems) :
    {
        foreach ($titems as $value) : ?>
          <div class="row">
            <div class="alert alert-info span3" style="margin-left: 0">Параметр:&nbsp;<?=$value->name;?></div>
            &nbsp;
            <div class="span1">
            <?php echo CHtml::link('удалить', '/manage/manage/deletecustom/id/' . $value->id . '/tovid/' . $g_id,array('class'=>'btn btn-small btn-danger')); ?>
            </div>
          </div><br/><br/>          
<?php endforeach;?>
<?php } endif; ?>
        
    
