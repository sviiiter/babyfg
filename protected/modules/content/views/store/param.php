<?php 
$tid = $value->id;
$cache = Yii::app()->session['id'];
$custom = $cache[$value->id];
if(is_array($custom)) :
?>    
<br/>
<b><?=$value->custom?></b><br/>
    <?php foreach ($custom as $key=>$value): ?>
    <div class="row">
    <div class="span2"><?=$key?>(<?=$value?>)   
    </div>
    <?php
    echo CHtml::ajaxLink('<i class="icon-minus-sign"></i>',array('/store/deletecustomfield', 'id'=>$tid,'field'=>$key), 
                            array(
                    'type' => 'GET',
                    'update' => '#center_all', 
                    'cache' => true, 
                    ),
            array(
                'id' => rand(),
                'style'=>'color:red',
                'class'=>'pull-right'
            )
            );  
    ?>                     
    </div><br/>
    <?php endforeach; ?>
<?php endif;?>