<b><?php echo CHtml::link($data->name, array('/store/'.$data->id)); ?></b>
<br>
-------
<br>
<?php echo CHtml::link(mb_substr($data->extended, 0 , 220,'utf-8').'...', array('/store/'.$data->id)); ?>
<hr/>