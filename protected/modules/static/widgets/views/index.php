<h2>Новости</h2>

<!--noindex-->
<?php foreach($model as $value) :?>
  <span class="date"><?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($value->date)); ?></span>
  <h3><?php echo $value->caption; ?></h3>
  <p><?php echo $value->text; ?></p>
  <script type="text/javascript" src="//yandex.st/share/share.js"
  charset="utf-8"></script>
  <div class="yashare-auto-init" data-yashareL10n="ru"
   data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

  ></div> 
<?php endforeach; ?>
<!--/noindex-->
