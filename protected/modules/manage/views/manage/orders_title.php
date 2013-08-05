<h1>Заказы</h1>
<p><?php 
  $params = array('/manage/manage/downloadorders');
  ( isset($_GET['all'])) ? ($params['all'] = 'all') : ($params['id'] = ( isset($_GET['id'])) ? $_GET['id'] : Yii::app()->user->id);
  echo CHtml::link( 'Зкспортировать в Excel', $params); 
?></p>
<?php if (Yii::app()->user->hasFlash('no orders')): ?>
  <br/><div class="alert alert-block span5"><?=Yii::app()->user->getFlash('no orders');?></div>
<?php else: ?>
<!--?php $i = 0; foreach ($orders as $order) :?-->
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>new CArrayDataProvider($orders),
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => '$data->id',
		),
		array(
			'name' => 'Совершен',
			'type'=>'raw',
			'value' => 'CHtml::link( $data->time, array(\'/manage/manage/orderbyid\',\'id\' => $data->id))',
		),
		array(
			'name' => 'Сумма заказа',
			'type'=>'raw',
			'value' => '$data->sumprice . " р"',
		),    
))); ?>

<?php
  /*if (!$order->orderitems) { 
      echo 'нет элементов<br/>'; 
  }
  foreach ($order->orderitems as $item) {
      $check = Tovar::model()->findByPk($item->tovar_id);
      if ($check) {            
          $item_string[] = 'Наименование: ' 
            . $item->tovars->name . ', ' 
            . $item->tovars->custom1 . ': '
            . ( (isset($item->customfield1)) ? $item->customfield1->name : '') . ', '
            . $item->tovars->custom2 . ': '
            . ( (isset($item->customfield2)) ? $item->customfield2->name : '') . ', '            
            . ' Количество: ' . $item->quantity;
      } else {
        $item_string[] = 'товара нет в наличии';
      }
  }*/
?>
<!--?php if (isset($item_string)): ?>
  <a href="/manage/manage/orderbyid/id/<=$order->id;?>"><php echo substr(implode('; ', $item_string), 0, 700).'...' ?></a> Совершен: <=$order->time;?>
  <br /><hr>
php endif; ?>
<php  $i++; 
unset($item_string);?>
<php
endforeach; 
?-->
<div class="pagintr">
<?php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
</div>

<?php endif;?>
