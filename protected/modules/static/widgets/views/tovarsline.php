<div class="main-three-items">
    <div><b><?=$this->caption?></b></div>
    <?php        
        foreach ($model as $value):
            $subject = $value->types->type.' '.$value->name;
    ?>
        
                <div class="three-items">
                    <a href="/store/<?=$value->id?>">
                        <div class="span1">
                            <?php
                                $picture = '/baners/thumbs/'.$value->pic_name; 

                                if(strlen($value->pic_name)<=0 || !file_exists(Yii::getPathOfAlias('webroot').$picture))
                                    $picture = '/images/nofotobig.png'; 
                            ?>                        
                        <?=Sender::Imgrenderer($picture, $subject)?>           
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>

                        <?=$subject?>
                        <?=$value->brands->brand?>
                        <?=$value->description?>
                        Цена: <?=$value->price?>
                    </a>
                </div> 
        
    <?php endforeach;?>
</div>