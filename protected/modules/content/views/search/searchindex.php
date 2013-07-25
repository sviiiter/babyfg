<?php
$this->breadcrumbs=array(
	'Поиск',
);
?>
<h1><?=$this->pageTitle?></h1>
<?php
$this->widget('MyGridView', array(
    'id'=>'vouchers-grid',
    'dataProvider'=>$model->search(),
    'widview' => 'search',
    'filter'=>$model,
));
?>
