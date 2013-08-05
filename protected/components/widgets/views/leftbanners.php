<?php
  foreach ($model as $image) {
    echo CHtml::image('/image/leftcolumn/' . $image->image);
  }
?>