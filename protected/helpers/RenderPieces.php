<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RenderPieces
 *
 * @author zebra
 */
class RenderPieces {
  public static function createImg($filename, $big = false, $alt = false, $htmlOptions = null) 
  {
    $middlePath = ($big) ? '/image/' : '/image/thumbs_middle/';    
    return CHtml::image( ((isset($filename)) ? $middlePath . $filename : '/images/nofoto.png'), $alt, $htmlOptions);
  }
}

?>
