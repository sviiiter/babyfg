<h1>Заказы</h1>
<?php 
if(Yii::app()->user->hasFlash('no orders')) :
{ ?>
    <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('no orders');?></div>
  <?php  }
else :

?>

<?php
$i = 0;
?>

<?php foreach ($orders as $order) :?>
Заказ <?=$i?> :
<?php

$items = $order->orderitems;
if(!$items) 
    echo 'нет элементов<br/>'; 
    foreach ($items as $item) 
    {
        $tovar = $item->tovars;
        $check = Tovar::model()->findByPk($item->tovar_id);
        if($check)
            $item_string[] = 'Наименование: '.$tovar->name.',Вкус : '.$item->custom.', Колличество: '.$item->quantity;
        else
            $item_string[] = 'товара нет в наличии';
        
    }
?>
<?php if(isset($item_string)) :?>
<a href="/manage/manage/orderbyid/id/<?=$order->id;?>"><?php echo substr(implode('; ', $item_string), 0, 700).'...' ?></a> Совершен: <?=$order->time;?>
<br />
<hr>
<?php endif; ?>
<?php  $i++; 
unset($item_string);?>
<?php
endforeach; 
?>
<div class="pagintr">
<?php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
</div>

<?php endif;?>
