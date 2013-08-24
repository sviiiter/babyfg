<!--noindex-->
<?php $this->pageTitle='"'.Yii::app()->name.'" - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<h1><?php echo UserModule::t("Registration"); ?></h1>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success fontsize20">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="span8 fontsize20">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note" style="font-size: 11pt"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
  <?php if ($model->errors || $profile->errors): ?>
    <div class="alert alert-danger">
      <?php echo $form->errorSummary(array($model,$profile)); ?>
    </div>
  <?php endif; ?>	
	
	<div>  <!-- class="row"-->
	<?php echo $form->labelEx($model,'username'); ?>
	<?php echo $form->textField($model,'username'); ?>
	<?php echo $form->error($model,'username'); ?>
	</div>
		
	<div>  <!-- class="row"-->
	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email'); ?>
	<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div>  <!-- class="row"-->
	<?php echo $form->labelEx($model,'mob_phone'); ?>
	<?php echo $form->textField($model,'mob_phone'); ?>
	<?php echo $form->error($model,'mob_phone'); ?>
	</div>        
        
  <?php 
      $profileFields=$profile->getFields();
      if ($profileFields) {
        foreach($profileFields as $field) {
        ?>
          <div>   <!-- class="row"-->
            <?php echo $form->labelEx($profile,$field->varname); ?>
            <?php 
            if ($field->widgetEdit($profile)) {
              echo $field->widgetEdit($profile);
            } elseif ($field->range) {
              echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
            } elseif ($field->field_type=="TEXT") {
              echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
            } else {
              echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
            }
             ?>
            <?php echo $form->error($profile,$field->varname); ?>
          </div>	
        <?php
        }
      }
  ?>

  <p>    
    <div class="well" style="overflow:hidden"> 
      <h3>Дети:</h3>
      <p class="fontsize16"><i class="icon-info-sign"></i>&nbsp;Укажите дату рождения ваших детей.</p>
      <?php for ($i = 0; $i < 3; $i++): ?>   
        <div class="alert alert-success kids-wrapper" style="width:180px;margin-left:10px;float:left">
        <p><?php echo $i + 1; ?>.</p>
        <?php echo CHtml::activeLabel($kids, 'birth'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'name'  =>  'UserKids[birth][' . $i . ']',
          'model' => $kids,
          //'attribute' => 'birth',               
          'options'=>array(
              'showAnim'=>'fold',
              'dateFormat'=>'yy-mm-dd',
              ),
          'htmlOptions'=>array(
              'style'=>'height:15px;width:187px'
          ),
          'language' => 'ru',
          'cssFile'=>false,
        )); ?>
        <?php echo CHtml::activeLabel($kids, 'sex'); ?>
        <?php echo CHtml::radioButtonList( 'UserKids[sex][' . $i . ']', '0', array(UserKids::checkSex(UserKids::MALE), UserKids::checkSex(UserKids::LADY)), array(
          'template'  =>  '<div style="float:left;width:100px;height:80px;">{label}{input}</div>',
          'separator' => '',
          'container' =>  'div class="labels_sex" style="height:82px;width:224px"'
        )); ?>
        <?php echo CHtml::activeLabel($kids, 'name'); ?>
        <?php echo CHtml::textField('UserKids[name][' . $i . ']', null, array('placeholder' => UserKids::model()->getAttributeLabel('name'), 'style' => 'width:187px;height:15px')); ?>
        </div>
      <?php endfor; ?>
    </div>   
  </p>
	<?php if (UserModule::doCaptcha('registration')): ?>
	<div> <!-- class="row"-->
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		<?php echo $form->error($model,'verifyCode'); ?>
		
		<p class="hint" style="font-size: 10pt"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
	</div>
	<?php endif; ?>
	
	<div> <!-- class="row submit"-->
		<?php echo CHtml::submitButton(UserModule::t("Register"), array('class'=>'btn btn-inverse')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>

<?php 
Yii::app()->clientscript->registerCss('registration', 
        '
            #registration-form * {
            font-size: 20px;
            line-height: 18px;
            }
            .kids-wrapper input{}
        ');
?>
<!--/noindex-->