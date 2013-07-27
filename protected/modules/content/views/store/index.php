<?php
$this->breadcrumbs=array(
        'Магазин' => '/store/',
);?>
<?php if (Yii::app()->user->hasFlash('no result')): ?>
<br/>
<div class="alert alert-block span5"><?=Yii::app()->user->getFlash('no result');?></div>
<?php else: ?>

<div class="central">
  <div class="central" style="display:table">
  <div style="margin-left:35px"><h1>Каталог</h1></div>
  <?php foreach ($model as $value) : ?>
  <a href="<?=$this->createUrl('/store/' . $value->id);?>" itemtype="http://schema.org/Product">
    <div class="item border-radiused">	
      <div class="tovar-pic"><?=CHtml::image((isset($value->pictures[0]->picname)) ? '/image/thumbs_middle/' . $value->pictures[0]->picname : $picture = '/images/nofoto.png'); ?></div>      
      <div class="tovar-name"><p><span class="cap-img-item"><?php echo $value->name; ?></span></p></div>
      <!--div class="simple-desc"-->
        <!--?=(mb_strlen($value->description, "utf-8") > 22) ? (mb_substr($value->description, 0, 22, "utf-8") . '...') : $value->description;?-->
      <!--/div-->									
      <div class="row">
        <div class="price span1"><?=intval($value->price1);?> р</div>
        <img class="buy-button span2" src="/css/but-kupit.jpg" alt="" />
      </div>
    </div>
  </a>
  <!--?=( Yii::app()->getModule('user')->isAdmin()) ? CHtml::link( 'править>>',
    array('/index.php/manage/manage/edititem/', 'id' => $value->id),
    array('class' => 'editlink', 'style' => 'font-style: italic;')
  ) : ''; ?-->
  <?php endforeach; ?>
  </div>
</div>
<div class="pagintr span6"><?php $this->widget('CLinkPager', array( 'pages'=>$pages));?></div>
<?php
Yii::app()->clientscript->registerCss('storeindex', 
        '
            a.editlink{
                margin: 0px auto auto 170px;
            }
            a.editlink:hover{
                text-decoration: none;
            }            
        '        
        );
?>
<?php endif; ?>
<?php Yii::app()->clientscript->registerCssFile(Yii::app()->request->baseUrl.'/css/catalog.css', 'screen, projection'); ?>