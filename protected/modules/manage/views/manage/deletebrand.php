<?php
$this->breadcrumbs=array(
        'Магазин'=>'/store/listbybrand',
	'Удалить производителя',
);
?>
<h1>Удалить производителя</h1>
<?php
        if(Yii::app()->user->hasFlash('no brand')):
        { ?>            
<br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('no brand');?></div>
       <?php }
        else :
?>
<div class="span4">
<?php
    echo CHtml::beginForm();
    echo CHtml::activeLabel($model,'brand'); 
    echo CHtml::activeDropDownList($model,'brand',
                CHtml::listData(Brands::model()->findAll(),'id', 'brand'),
                array('empty' => '(Выберите...)','class'=>'span3')
            );
    echo '<br/>';
    echo CHtml::submitButton('Удалить', array('class'=>'btn btn-small btn-danger'));
    echo CHtml::endForm();
    
    
    //Brands::model()->findAll()
?>
</div>
<?php endif; ?>