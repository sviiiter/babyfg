<?php foreach ($model as $image): ?>
    <?php echo ($image->url) ? CHtml::link( CHtml::image('/image/leftcolumn/' . $image->image), $image->url) : CHtml::image('/image/leftcolumn/' . $image->image); ?>
    <?php if (Yii::app()->user->role == User::ADMIN): ?>
      <p>
        <?php echo CHtml::link( 'Править>>', array('/static/proposals/leftprop', 'id' =>  $image->id), array('class'  =>  'btn btn-danger')); ?>
      </p>
    <?php endif; ?>
<?php endforeach; ?>