<?php
$this->breadcrumbs=array(
	'Контакты',
);
?>
<h1>Контакты</h1>
<?=$model->contacts;?> 
<div style="margin-left: 10px ; width:550px">
</div>
<br/><br/><br/>
<?php 
    if(Yii::app()->getModule('user')->isAdmin())
    {
    echo CHtml::link('Редактировать',array('/static/static/editcontacts'), array('class' => 'btn btn-small btn-inverse'));
    }
?>   
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru"
 data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

></div> 
<br/>
<br/>

