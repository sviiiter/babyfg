<h1>Левое меню</h1>
<?= (isset($model->errors) && $model->errors) 
  ? '<div class="alert alert-error">' . CHtml::errorSummary($model) . "</div>" 
  : ((Yii::app()->user->hasFlash('Success')) ? '<div class="alert alert-success">' . Yii::app()->user->getFlash('Success') . "</div>" : ''); ?>
<h2>Создать</h2>
<p>
<?= CHtml::beginForm($this->createUrl('CreateMenuItem')); ?>
<p><?=  CHtml::dropDownList('NavItems_create[parent_id]', null, $root, array('empty' => 'Выберите корневой разел')); ?></p>
<p><?=  CHtml::textField('NavItems_create[name]', '',array('class' => 'input-xxlarge', 'placeholder' => 'Введите название категории')); ?></p>
<p><?=  CHtml::button('Сохранить', array('type' => 'submit'))?></p>
<?= CHtml::endForm(); ?>
</p>

<h2>Редактировать</h2>
<p>
<?= CHtml::beginForm('', 'post',array('id' => 'edit','enctype'=>'multipart/form-data')); ?>
<?= (isset($editmodel->errors) && $editmodel->errors)  
  ? '<div class="alert alert-error">' . CHtml::errorSummary($editmodel) . "</div>" 
  : ((Yii::app()->user->hasFlash('Success')) ? '<div class="alert alert-success">' . Yii::app()->user->getFlash('Success') . "</div>" : ''); ?>
  <p><?=  CHtml::activeDropDownList($editmodel, 'id', $items, array(
    'id' => 'editselect',
    'empty' => 'Выберите пункт меню для редактирования',
    'options' => null,
    'onchange'  => 'js: var val = $(this).val(); window.location.href = \'' . $this->createUrl('CreateMenuItem', array('edit' => 'true')) . '/id/\' +  val; '
  )); ?></p>
  <p><?=  CHtml::activeTextField($editmodel, 'name',array('class' => 'input-xxlarge', 'placeholder' => 'Введите название категории')); ?></p>
  <p><?= CHtml::activeFileField($editmodel,'picture',array('size'=>60,'maxlength'=>128)); ?> </p>
  <i class="icon-info-sign"></i>&nbsp;Файл должен быть размером: ширина 213px, высота: 209px. 
  <?php echo CHtml::image('/image/menu/' . $editmodel->picture); ?>
  <p><?=  CHtml::button('Сохранить', array('type' => 'submit'))?></p>
<?= CHtml::endForm(); ?>
</p>

<h2>Удалить</h2>
<p>
<?= CHtml::beginForm($this->createUrl('CreateMenuItem')); ?>
<?= (isset($model->errors) && $model->errors)  
  ? '<div class="alert alert-error">' . CHtml::errorSummary($model) . "</div>" 
  : ((Yii::app()->user->hasFlash('Success')) ? '<div class="alert alert-success">' . Yii::app()->user->getFlash('Success') . "</div>" : ''); ?>
<p><?=  CHtml::dropDownList('deleteitem', null, $items, array('id' => 'deleteselect','empty' => 'Выберите пункт меню для редактирования','options' => $disabled)); ?></p>
<p><?=  CHtml::button('Удалить', array('type' => 'submit'))?></p>
<?= CHtml::endForm(); ?>
</p>

<?php
/*
 *       $("#editselect").change(function(){
      var selected = $(this).find("option:selected").text();
      var toset = selected.replace("----","");
      $(this).parents("form").find("#NavItems_edit_name").val(toset);
    })
 */
  /*Yii::app()->clientscript->registerScript('createmenu', '
    $("#editselect").change(function(){
      $(\'#edit\').submit();
    });
  ');*/
?>

