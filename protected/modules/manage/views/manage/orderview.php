<h1>Заказ</h1>
<?php if(Yii::app()->getModule('user')->isAdmin()) :
{    
    $info = Order::model()->findByPk($model[0]->order_id);
?>
<b>Заказчик:</b> <br/>
Имя: <?=$info->person;?><br/>
Телефон: <?=$info->phone;?><br/>
Адрес доставки: <?=$info->adress;?><br/>
Электронная почта: <?=$info->email;?><br/>
Дополнительная информация: <?=$info->additionalinfo;?><br/>


<?php } endif;?>
<?php
foreach ($model as $value): 
    $tovars = $value->tovars;
    ?>
<div class="tovar_cart">  
<?php     if($tovars):
    {  ?>    
    <div class="img">
    <div class="tovar_img">
        <?php
            if(strlen($tovars->pic_name)>0)
                $picture = '/baners/thumbs/'.$tovars->pic_name;
            else $picture = '/images/nofoto.png';        
    
            echo CHtml::link('<img src="'.$picture.'" />',
            '/store/'.$tovars->id
            );     
            ?>
    </div>
    </div>
    <div class="cart_description">
        <div class="textd">
            Наименование : <?=$tovars->name;?> 
            <br />
            Колличество в упаковке : <?=$tovars->quantity;?>
            <br />
            Цена : <?=$tovars->price;?>    
            <br />
            Производитель: <?=$tovars->brand;?> 
            <br />
            <?=$tovars->custom;?>: <?=$value->custom;?>             
        </div>
        <div class="inputd">
        <div>Колличество:</div>
        <div>
            <form>              
            <input id="<?=$value->id?>" class="inputquan" type="text" name="answer" value="<?=$value->quantity;?>">
            <br />
            </form>
        </div>
        <br/>
        <br/>
        <br/>
        <div class="savebut">
        <?php
            $rand = rand();
            echo CHtml::ajaxLink("Добавить в корзину",array('/store/Addtovartocart', 'id'=>$tovars->id), 
                                        array(
                                'type' => 'GET',
                                'cache' => true,
                                'success' => '
                                    function(data)
                                    {
                                    $("#cart_q").html(data);
                                    $("#'.$rand.'").parent().css("background", "none");
                                    $("#'.$rand.'").parent().html("в корзине");
                                    }
                                    '
                                ),
                        array(
                            'id' => $rand,
                            'class' => 'btn btn-small btn-inverse'
                        )
                        );       
        ?>
        </div>        
        </div>

    </div>
<?php } 
else :
    echo 'товара нет в наличии';

endif; ?>    
</div>
<?php endforeach;?>
<br />
<div class="pagintr">
<?php $this->widget('CLinkPager', array( 'pages'=>$pages));?>
</div>




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