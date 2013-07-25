<div itemscope itemtype="http://schema.org/Article">
<h1><span itemprop="name"><?=$model->caption?></span></h1>
<br/>
<span itemprop="articleBody">
<?=$model->description?>
</span>
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru"
 data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

></div> 

<?php $widget = $this->widget('application.modules.static.widgets.Tovarsline',array('type' => $model->id, 'caption' => 'Купить '.  mb_strtolower ($model->type,'utf-8')));?> 
</div>