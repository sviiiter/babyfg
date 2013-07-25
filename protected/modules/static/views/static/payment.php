<?php
$this->breadcrumbs=array(
	'Оплата и доставка'
);
?>
<h1>Оплата и доставка</h1>
<!--div class="span4"-->
<?=$model->payment;?>  
<br/>
<br/>
<br/>
<?php
    if(Yii::app()->getModule('user')->isAdmin())
    {
    echo CHtml::link('Редактировать',array('/static/static/editpayment'), array('class' => 'btn btn-small btn-inverse'));
    }
?>  
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru"
 data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

></div> 

<br/>
<br/>

<!--/div-->
