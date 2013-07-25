<?php
$this->breadcrumbs=array(
  'Магазин'=>'/store/listbybrand',
  'Редактировать товар',
);
?>
<h1>Редактировать товар</h1>
<div class="span6" style="padding-bottom: 5px; ">
    <?php
        if(Yii::app()->user->hasFlash('item saved successufuly')):
        { ?>
             <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('item saved successufuly');?></div>
<?php } endif; ?>

    <div class="form">
    <?php echo CHtml::beginForm('', 'post',array('enctype'=>'multipart/form-data')); ?>
      <div class="span6">   
        <?php echo CHtml::errorSummary(array($model, $pictures),'<div class="alert alert-error span4">','</div>'); ?>
        <br/><?=CHtml::link('<< Назад к странце товара', '/store/'.$model->id, array('style'=>'color:red;margin-left:250px'))?>
        <div class="row">
          <?php echo CHtml::activeLabel($model,'name'); ?> 
          <?php echo CHtml::activeTextField($model,'name', array('class'=>'input-xlarge')); ?>
        </div>
        <div class="row">
          <?php echo CHtml::activeLabel($model,'artikul'); ?> 
          <?php echo CHtml::activeTextField($model,'artikul', array('class'=>'input-xlarge')); ?>
        </div>        
        <div class="row">
          <?php echo CHtml::activeLabel($model,'price1'); ?> 
          <?php echo CHtml::activeTextField($model,'price1'); ?>
        </div> 
        <div class="row">
          <?php echo CHtml::activeLabel($model,'price2'); ?> 
          <?php echo CHtml::activeTextField($model,'price2'); ?>
        </div> 
        <div class="row">
          <?php echo CHtml::activeLabel($model,'price3'); ?> 
          <?php echo CHtml::activeTextField($model,'price3'); ?>
        </div> 
        <div class="row">
          <?php echo CHtml::activeLabel($model,'price4'); ?> 
          <?php echo CHtml::activeTextField($model,'price4'); ?>
        </div>         
        <br/>
        <?php echo CHtml::activeRadioButtonList($model, 'instore',  array('1'=>'В наличии','0'=>'Нет в наличии')); ?> 
        <!--ТИП-->
        <p>
          <div class="row">    
            <?php $root = SomeIterations::selectRoot(NavigationItems::model()->findAll());
              $menu = SomeIterations::activeMenuItems($root);    
              echo CHtml::activeDropDownList($model,'menu_id_item',
                $menu['items'],
                array('empty' => '(Выберите раздел для привязки)','class'=>'span3', 'options' => $menu['disabled'])
            );?>
          </div>
          <div class="row">
            <?php echo CHtml::activeLabel($model,'country'); ?> 
            <?php echo CHtml::activeTextField($model,'country', array('class'=>'input-xlarge')); ?>
          </div>           
        </p>
        <!--ТИП-end-->    
        <br/>
            <!-- Button to trigger modal -->
        <div class="row">    
          <div class="span3" style="margin-left: 0px;">
            <a href="#myModal" role="button" class="btn btn-mini btn-inverse" data-toggle="modal">Редактировать описание</a>
          </div>
          <a href="#myModal1" role="button" class="btn btn-mini btn-inverse" data-toggle="modal">Редактировать расширенное описание</a>
        </div>
        <span class="span3" style="font: italic 9px Arial; margin-left: -30px;">* Информация отображается в ветрине магазина</span>
        <span class="span2" style="font: italic 9px Arial; margin-left: -30px; width: 200px;">* Информация отображается в расширенном описании товара</span>
        <!-- Modal -->
        <div style="width: 800px; height: 550px;" id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel">Редактировать описание</h3>
            </div>
            <div class="modal-body" style="height: 400px;">
              <p><?php echo CHtml::activeTextArea($model,'description', array('rows'=>'25', 'class'=>'input-xlarge')); ?></p>
            </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>                
        </div>

        <!-- Modal -->
        <div style="width: 800px; height: 550px;" id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel">Редактировать расширенное описание</h3>
            </div>
            <div class="modal-body" style="height: 400px;">
              <p><?php echo CHtml::activeTextArea($model,'extended',array('rows'=>'40', 'class'=>'input-xxlarge')); ?></p>
            </div>
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>                
        </div>
        <br/><br/>
        <div class="row">
          <?php echo CHtml::activeLabel($model,'custom1'); ?> 
          <?php echo CHtml::activeTextField($model,'custom1',array('placeholder'=>'Например: Вкус или цвет')); ?>
          <?php if ($model->id && $model->custom1) {
                echo CHtml::link(
                        'редактировать ' . $model->custom1,
                        '/index.php/manage/manage/editcustom/id/' . $model->id . '/custom/1',
                        array('class'=>'btn btn-mini btn-danger')
          );}?>
        </div> <!--end-->     
        <div class="row">
          <?php echo CHtml::activeLabel($model,'custom2'); ?> 
          <?php echo CHtml::activeTextField($model,'custom2',array('placeholder'=>'Например: Вкус или цвет')); ?>
          <?php if ($model->id && $model->custom2) {
            echo CHtml::link(
                    'редактировать ' . $model->custom2,
                    '/index.php/manage/manage/editcustom/id/' . $model->id . '/custom/2',
                    array('class'=>'btn btn-mini btn-danger')
          );}?>
        </div> <!--end-->         
        <h2>Загрузить изображение</h2>           
        <div class="row">  
          Выберите файл :
            <?php echo CHtml::activeFileField($pictures, 'picname', array('size' => 60, 'maxlength' => 128)); ?>     
        </div>  
        <h2>Фотогаллерея</h2>
        <p>
          <div class="row gallery">
            <ul>
              <?php foreach ($model->pictures as $p): ?>
                <li>
                <?php echo CHtml::image('/image/thumbs/' . $p->picname); ?>
                <?php echo CHtml::link('Удалить', array('/manage/manage/RemoveItemFoto', 'item_id' => $model->id, 'num_foto' => $p->id)); ?>
                <?php echo ((int)$p->is_cover === 1) ? '<span class="label">Обложка</span>' : CHtml::link('Сделать обложкой', array('/manage/manage/cover', 'item_id' => $model->id, 'num_foto' => $p->id)); ?>
                </li>
              <?php endforeach; ?>
            </ul>  
          </div>
        </p>
        <br /><br />
        <div class="row submit pull-right">
          <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn')); ?>
        </div>
      </div>
    <?php echo CHtml::endForm(); ?>        
    </div><!-- form -->
    <?php
    if(isset($model->id))
        echo CHtml::link('Удалить позицию', '/index.php/manage/manage/delete/id/'.$model->id, array('class'=>'btn btn-small btn-danger'))
    ?>
</div>
<?php Yii::app()->clientscript->registerCss('manageedit',
  '
    .gallery *{
      margin-left:40px;            
    }
    .gallery li{
    margin-top:20px;
    }

    a.deletelink{
    color: red;            
    }

    a.deletelink:hover{
    color: red;        
    text-decoration: none;            
    }
    iframe{
    height: 275px !important;
    width: 575px !important;
    }                        
  ');
Yii::app()->clientscript->registerScript('tinyMCEin',
  '
    tinyMCE.init({
      // General options
      language : "ru",
      mode : "textareas",
      theme : "advanced",
      plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",


      // Theme options
      theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
      theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
      theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
      theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "bottom",
      theme_advanced_resizing : true,

      // Skin options
      skin : "o2k7",
      skin_variant : "black",

      // Example content CSS (should be your site CSS)
      content_css : "css/example.css",

      // Drop lists for link/image/media/template dialogs
      template_external_list_url : "js/template_list.js",
      external_link_list_url : "js/link_list.js",
      external_image_list_url : "js/image_list.js",
      media_external_list_url : "js/media_list.js",

      // Replace values for the template plugin
      template_replace_values : {
              username : "Some User",
              staffid : "991234"
      }
    });            
  ');?>