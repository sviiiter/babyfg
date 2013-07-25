<h2>------Видео ------------------------------------------------------------</h2> 
<div class="row" style="margin-left: -10px;">
<?php foreach($model as $video) : ?>
<div style="width: 270px; float:left; margin-left: 30px;">    
<a class="video" rel='nofollow' href="<?=$video->embedlink?>">
    <img src="baners/video/<?=$video->imglink;?>" alt="" />
</a>
<?php 
if(Yii::app()->getModule('user')->isAdmin())
    echo CHtml::link('>>править',array('/static//video/load/id/'.$video->id)); 
?>    
</div>    
<?php endforeach;?>
</div>
<hr>