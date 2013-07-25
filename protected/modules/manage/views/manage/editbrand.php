<?php
$this->breadcrumbs=array(
        'Магазин'=>'/store/listbybrand',
	'Редактировать производителя',
);
isset($onebrand) ? $actionlink = '/manage/manage/editbrand/id/'.$onebrand->id : $actionlink = '';
?>
<h1>Редактировать производителя</h1>
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
    echo CHtml::beginForm($actionlink);
    echo CHtml::activeLabel($model,'brand'); 
    if(isset($onebrand)){
        echo CHtml::activeTextField($onebrand,'brand',array('class'=>'input-xlarge'));   
    }else{    
    echo CHtml::activeDropDownList($model,'brand',
                CHtml::listData(Brands::model()->findAll(),'id', 'brand'),
                array('empty' => '(Выберите...)','class'=>'span3')
            );
    echo '<br/>';
    }
    echo CHtml::submitButton('Редактировать', array('class'=>'btn btn-small btn-danger'));
    echo CHtml::endForm();
    
   
    // echo CHtml::link('редактировать '.$model->custom, '/index.php/manage/manage/editcustom/id/'.$model->id,array('class'=>'btn btn-mini btn-danger'));
    //Brands::model()->findAll()
?>
</div>
<?php endif; ?>