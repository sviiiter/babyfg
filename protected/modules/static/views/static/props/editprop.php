<h1>Редактировать акцию</h1>
<?php 
if(Yii::app()->user->hasFlash('prop saved')) :
{ ?>
        <br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('prop saved');?></div>
<?php }
else :       
?>
<form method="post" action="/static/static/props">
        <p>     
                <textarea name="content" cols="50" rows="27">
Вставьте сюда текст и отформатируйте в соответствии со стилями и цветом текста на фоне акции.<br/><br/>
<hr>
Пример: <br/><br/>
Акция<br/>
<span style="text-decoration: underline; font-size: 20px">Купи</span><br/>
<span style="text-decoration: none;color:yellow; font-size: 15px">Две</span> банки<br/><br/>
и получи<br/><br/>
спортивный<br/><br/>
батончик.<br/><br/>
<br/><br/><br/>
Примечание: цвет текста нужно также задать.

                </textarea>
                <br/>
                <input type="submit" value="Сохранить" class="btn btn-inverse"/>
        </p>
</form>
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