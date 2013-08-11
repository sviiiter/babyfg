<h1>Заказ</h1>
<?php if ( Yii::app()->getModule('user')->isAdmin()): ?>
  <p><?php 
    $params = array('/manage/manage/downloaddetails');
    $params['id'] = $_GET['id'];
    echo CHtml::link( 'Зкспортировать в Excel', $params); 
  ?></p>
  <b>Заказчик:</b> <br/>
  Имя: <?=$model->person;?><br/>
  Телефон: <?=$model->phone;?><br/>
  Адрес доставки: <?=$model->adress;?><br/>
  Электронная почта: <?=$model->email;?><br/>
  Дополнительная информация: <?=$model->additionalinfo;?><br/>
<?php endif; ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>new CArrayDataProvider($model->orderitems, array('pagination'=>array('pageSize'=>10))), 
	'columns'=>array(
		array(
			'name' => '№ заказа',
			'type'=>'raw',
			'value' => '$data->order_id',
		),   
		array(
			'name' => 'Обложка',
			'type'=>'raw',
			'value' => 'CHtml::image((isset($data->tovars->cover[0]->picname)) ? \'/image/thumbs_middle/\' . $data->tovars->cover[0]->picname : \'/image/pattern/nofoto.png\');',
		),    
		array(
			'name' => 'Артикул',
			'type'=>'raw',
			'value' => '$data->tovars->artikul',
		),
		array(
			'name' => 'Наименование',
			'type'=>'raw',
			'value' => '$data->tovars->name',
		),
		array(
			'name' => 'Параметр 1',
			'type'=>'raw',
			'value' => '$data->tovars->custom1 . \': \' . ((isset($data->customfield1)) ? $data->customfield1->name : "")',
		),    
		array(
			'name' => 'Параметр 2',
			'type'=>'raw',
			'value' => '$data->tovars->custom2 . \': \' . ((isset($data->customfield2)) ? $data->customfield2->name : "")',
		),
		array(
			'name' => 'Количество',
			'type'=>'raw',
			'value' => '$data->quantity',
		),      
		array(
			'name' => 'Цена',
			'type'=>'raw',
			'value' => '$data->tovars->getPrice($data->order->user) . \' р\'',
		),       
))); ?>
<b>Общая сумма заказа: <?php echo $model->sumprice; ?> р</b>
<!--div class="pagintr">
<php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
</div-->




<?php
Yii::app()->clientscript->registerCss('cart', 
        '
         .deletecart{
        display: block;
        margin: 100px auto auto 460px; 
        color: red;
        text-decoration: none;
        font: italic 8pt Arial,Helvetica,sans-serif;
        }
        
        a.deletecart:hover{
        text-decoration:none;
        }
        
        div.orderlink{
            margin: 20px auto auto 470px;
            text-decoration: none;
        }
        
        div.orderlink a{
            text-decoration: none;
        }       

        div.inputd div{
            float: left;
        }
        div.savebut{
            float: none;
            width: 90px;
        }

        div.textd{
        width: 300px;
        }

        div.cart_description div{
        float: left;
        }

        div.inputd{
            height: 80px;
        }
        
        div.cart_description{
            margin: 10px 10px auto 10px;
            width: 430px;
        }

        .inputquan{
            width: 30px;
        }
        
        div.tovar_cart{
            border: 1px solid white;
            height: 120px;
            margin: 10px 10px auto 10px;
        }

        div.tovar_cart div{
            float: left;
        }

        div.img{
            margin: 10px auto auto 10px;
        }
        '        
        );
?>
<?php
  Yii::app()->clientscript->registerCss('catalog','
    .in{font-size:20px}
  ');
?>