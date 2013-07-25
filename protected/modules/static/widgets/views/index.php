<!--noindex-->
<?php foreach($model as $value) :?>
<hr/>
<div style="height: 129px">
<p>
<?php 
$date = explode(' ', $value->date);
$newdmy = array_reverse(explode('-', $date[0]));
echo implode('.', $newdmy);
unset($date, $newdmy);
?>
<br/>
<span>    
<?php
    echo CHtml::link(mb_substr($value->text, 0 , 320,'utf-8').'...', '/news/'.$value->id, array('itemprop' => 'url', 'rel' => 'nofollow'));
?>
</span>
<br/>
</p>
</div>
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru"
 data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

></div> 

<?php endforeach; ?>
<!--/noindex-->
