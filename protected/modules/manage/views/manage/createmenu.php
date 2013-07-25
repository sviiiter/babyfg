<h1>Левое меню</h1>
<?= ($model->errors) 
  ? '<div class="alert alert-error">' . CHtml::errorSummary($model) . "</div>" 
  : ((Yii::app()->user->hasFlash('Success')) ? '<div class="alert alert-success">' . Yii::app()->user->getFlash('Success') . "</div>" : ''); ?>
<h2>Создать</h2>
<p>
<?= CHtml::beginForm(); ?>
<p><?=  CHtml::dropDownList('NavItems_create[parent_id]', null, $root, array('empty' => 'Выберите корневой разел')); ?></p>
<p><?=  CHtml::textField('NavItems_create[name]', '',array('class' => 'input-xxlarge', 'placeholder' => 'Введите название категории')); ?></p>
<p><?=  CHtml::button('Сохранить', array('type' => 'submit'))?></p>
<?= CHtml::endForm(); ?>
</p>

<h2>Редактировать</h2>
<p>
<?= CHtml::beginForm(); ?>
<?= ($model->errors) 
  ? '<div class="alert alert-error">' . CHtml::errorSummary($model) . "</div>" 
  : ((Yii::app()->user->hasFlash('Success')) ? '<div class="alert alert-success">' . Yii::app()->user->getFlash('Success') . "</div>" : ''); ?>
<p><?=  CHtml::dropDownList('item', null, $items, array('id' => 'editselect','empty' => 'Выберите пункт меню для редактирования','options' => null)); ?></p>
<p><?=  CHtml::textField('NavItems_edit[name]', '',array('class' => 'input-xxlarge', 'placeholder' => 'Введите название категории')); ?></p>
<p><?=  CHtml::button('Сохранить', array('type' => 'submit'))?></p>
<?= CHtml::endForm(); ?>
</p>

<h2>Удалить</h2>
<p>
<?= CHtml::beginForm(); ?>
<?= ($model->errors) 
  ? '<div class="alert alert-error">' . CHtml::errorSummary($model) . "</div>" 
  : ((Yii::app()->user->hasFlash('Success')) ? '<div class="alert alert-success">' . Yii::app()->user->getFlash('Success') . "</div>" : ''); ?>
<p><?=  CHtml::dropDownList('deleteitem', null, $items, array('id' => 'deleteselect','empty' => 'Выберите пункт меню для редактирования','options' => $disabled)); ?></p>
<p><?=  CHtml::button('Удалить', array('type' => 'submit'))?></p>
<?= CHtml::endForm(); ?>
</p>

<?php
  Yii::app()->clientscript->registerScript('createmenu', '
      $("#editselect").change(function(){
      var selected = $(this).find("option:selected").text();
      var toset = selected.replace("----","");
      $(this).parents("form").find("#NavItems_edit_name").val(toset);
    })
  ');
?>

