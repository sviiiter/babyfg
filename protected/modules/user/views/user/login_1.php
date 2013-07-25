<!--noindex-->
<div class="formlogin">
    <div style="margin-left: 5px;">
<?php echo CHtml::beginForm('/login'); ?>   
        <div style="height: 42px;">
	<div style="float: left; height: 42px; margin-left: 0px">  <!--class="row"-->
		<?php echo CHtml::activeLabelEx($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username', array('class'=>'input-medium','style'=>'background-color:#040404;border:1px solid #848484')) ?>
	</div>
	
	<div style="float: left;height: 42px; margin-left: 36px"> <!--class="row"-->
		<?php echo CHtml::activeLabelEx($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password', array('class'=>'input-medium','style'=>'background-color:#040404;border:1px solid #848484')) ?>
	</div>
    <div style="width: 64px;margin-top: 10px; margin-left: 31px; float: left;"> <!-- class="row submit"-->
		<?php echo CHtml::submitButton(UserModule::t("Login"), array('class'=>'btn btn-inverse','style'=>'height:33px;')); ?>
	</div>
        </div>
	
	<div>
                <div style="width:270px; float: left;">
		<p class="hint">
		<?php echo CHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl, array('rel' => 'nofollow')); ?> | <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl, array('rel' => 'nofollow')); ?>	
                </p>
                </div>
                <div style="width: 170px; margin-left: 5px; float: left;">
                <?php echo CHtml::activeLabelEx($model,'rememberMe', array('style' => 'float:left')); ?>
		<?php echo CHtml::activeCheckBox($model,'rememberMe', array('style' => 'float:left')); ?>                    
                </div>
	</div>
	

<?php echo CHtml::endForm(); ?>
            </div>
</div>


<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
<!--/noindex-->
<?php 
Yii::app()->clientscript->registerCss('cart', 
        '
         .formlogin label{
         color: black;
         line-height: 10px;
         font: italic 8pt Arial,Helvetica;
         margin-bottom: 0px;
         width: 100px;
        }
        
        .formlogin input{
        height: 15px;
        }        
        
        input.btn-info{
        height: 25px;
        }
        ');
?>