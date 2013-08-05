<h1>Редактировать размеры</h1>
<?php
if(Yii::app()->user->hasFlash('Measure saved')) :
{ ?>
   <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('Measure saved');?></div>
<?php }
else :
?> 

<!--div class="span4"-->
    <?php echo CHtml::beginForm(); ?>
    <div class="span5">  
   
    <?php echo CHtml::errorSummary($model,'<div class="alert alert-error span4">','</div>'); ?>
        <br/>
    <div class="row">
    <!--?php echo CHtml::activeLabel($model,'contacts'); ?--> 
    <?php echo CHtml::activeTextArea($model,'measurement', array('rows'=>'23', 'class'=>'input-xlarge')); ?>
    </div>          
    <br/>    
    <div class="row">
    <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn btn-small btn-inverse')); ?>
    </div>            
        
    <?php echo CHtml::endForm(); ?>
    </div>
<!--/div-->
<?php endif; ?>

<?php

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
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage,|,forecolor,backcolor",
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
        '
        );

?>