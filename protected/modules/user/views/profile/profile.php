<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
?>
<div class="span5 fontsize20 profile-wrap">
<h2><?php echo UserModule::t('Your profile'); ?></h2>
<p>Общая сумма ваших заказов: <?php echo $model->ordersusersumprice; ?>&nbsp;р</p>
<?php echo $this->renderPartial('menu'); ?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<table class="dataGrid">
<tr>
	<th>
    <?php echo CHtml::encode($model->getAttributeLabel('username')); ?>
  </th>
  <td>
    <?php echo CHtml::encode($model->username); ?>
  </td>
</tr>
<?php 
		$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {				
			?>
<tr>
	<th>
    <?php echo CHtml::encode(UserModule::t($field->title)); ?>
  </th>
  <td>
    <?php echo (($field->widgetView($profile))?$field->widgetView($profile):CHtml::encode((($field->range)?Profile::range($field->range,$profile->getAttribute($field->varname)):$profile->getAttribute($field->varname)))); ?>
  </td>
</tr>
			<?php
			}
		}
?>
<tr>
	<th>
    <?php echo CHtml::encode($model->getAttributeLabel('email')); ?>
  </th>
  <td>
    <?php echo CHtml::encode($model->email); ?>
  </td>
<tr>
	<th>
    <?php echo CHtml::encode($model->getAttributeLabel('mob_phone')); ?>
  </th>
  <td>
    <?php echo CHtml::encode($model->mob_phone); ?>
  </td>
</tr>
<tr>
	<th>
    <?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?>
  </th>
  <td>
    <?php echo date("d.m.Y H:i:s",$model->createtime); ?>
  </td>
</tr>
<tr>
	<th>
    <?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?>
  </th>
  <td>
    <?php echo date("d.m.Y H:i:s",$model->lastvisit); ?>
  </td>
</tr>
<tr>
	<th>
    <?php echo CHtml::encode($model->getAttributeLabel('status')); ?>
  </th>
  <td>
    <?php echo CHtml::encode(User::itemAlias("UserStatus",$model->status)); ?>
  </td>
</tr>
<tr>
	<th>
    <?php if ($model->kids): ?>
    <?php switch ( true) {
        case in_array( sizeof($model->kids), array('1')):
          $kids_text = 'ребенок';
          break;
        case in_array( sizeof($model->kids), array('2', '3', '4')):
          $kids_text = 'ребенка';
          break;        
        default:
          'детей';
    } ?>
      У вас <?php echo sizeof($model->kids) . ' ' . $kids_text; ?>.
    <?php endif; ?>
  </th>
  <td>
    
  </td>
</tr>
</table>
</div>
<?php 
Yii::app()->clientscript->registerCss('registration', 
        '
            .profile-wrap tr, .profile-wrap li {
              height: 30px;
            }
        ');
?>
