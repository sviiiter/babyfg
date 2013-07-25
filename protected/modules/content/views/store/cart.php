<?php
$this->breadcrumbs=array(
        'Спортивное питание'=>'/store',
	'Корзина',
);
?>
<h1>Корзина</h1>
<?php
Yii::app()->clientscript->registerCssFile('/css/cart.css');       
?>

<?php 
if(Yii::app()->user->hasFlash('empty items')) :
{ ?>
<br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('empty items');?></div> 
<?php } 
elseif(Yii::app()->user->hasFlash('Order saved')) :
{ ?>
    <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('Order saved');?></div>
<?php 
}
   else :
?>


<?php foreach ($model as $value): ?>
<div class="tovar_cart">  
    <div class="img">
    <div class="tovar_img">
        <?php
            $picture = '/baners/thumbs/'.$value->pic_name;               
            if(strlen($value->pic_name)<=0 || !file_exists(Yii::getPathOfAlias('webroot').$picture))
                $picture = '/images/nofoto.png';    
            
            echo CHtml::link('<img src="'.$picture.'" />',
            '/store/'.$value->id
            );            
            ?>

    </div>
    </div>
    <div class="cart_description">
        <div class="textd">
            Наименование : <?=$value->name;?> 
            <br />
            Колличество в упаковке : <?=$value->quantity;?>
            <br />
            Цена : <?=$value->price;?>    
            <br />
            Производитель: <?php
                                $brands = $value->brands;
                                echo $brands->brand;
                            ?> 
    <br/>        
    <?php
    $cf = $value->customfield;
    echo CHtml::activeDropDownList($value,'name',
                CHtml::listData($cf,'name', function($cf) {return CHtml::encode($cf->name);}),
                array('empty' => '(Выберите...)','class'=>'span2', 'id' => 'opt'.$value->id)
            );  
                
    $this->renderPartial('param',array('value' => $value));           
    ?>
    
    
    
        </div>
        <div class="inputd">
        <div>Колличество:</div>
        <div>
            <form>
            <?php 
            $session = Yii::app()->session['id'];
            
            if(isset($session[$value->id]) && !is_array($session[$value->id]))
                    $val = Yii::app()->session['id'][$value->id]; 
            else
                    $val = 1; 
            ?>                
            <input id="<?=$value->id?>" class="inputquan" type="text" name="answer" value="<?=$val;?>">
            <br />
            </form>
        </div>
        <br/>
        <br/>
        <br/>
        <div class="savebut">
        <?php
                echo CHtml::button('Сохранить',
                        array(
                            'id' => 'b'.$value->id,
                            'class'=>'btn btn-small btn-inverse'
                        )
                        );        
        ?>
        </div>        
        </div>
    <?php
        echo CHtml::link('Удалить из корзины', '/store/Deleteorderitem/id/'.$value->id, array('class'=>'deletecart'));
    ?>
    </div>

</div>
<?php
Yii::app()->clientscript->registerScript(
        '4ajax'.$value->id,
        '
        $("#b'.$value->id.'").click(
        function(){
        val = $("#'.$value->id.'").val();
        custom = $("#opt'.$value->id.'").val();
        $.ajax({
            type: "POST",
            url: "/store/saveitem",
            data: "id='.$value->id.'&quantity="+val+"&custom="+custom,
            success: function(data){
                $("#center_all").html(data);
            }
                });   
        }    
        )    
        ',
        CClientScript::POS_END
        );
?>
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru"
 data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,moimir,lj,moikrug,gplus"

></div> 


<?php endforeach;?>
<br />
<div class="row span1 alert alert-block" style="position:fixed; right: 0px; top: 250px;">Суммарная стоимость: <div id="sumprice"><span style="font-size: 22px;"><?=$sumprice?>&nbsp;р</span></div></div>
<br/>
<div class="pagintr">
<?php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
</div>
<div class="orderlink">
<?php
if(isset(Yii::app()->session['id']))
{
    if(Yii::app()->session['id'])
    {
        echo CHtml::link('Оформить', '/store/saveorder',
                array('class'=>'btn btn-large btn-info')
                
                );       
    }
}
?>
</div>
<?php endif;?>
