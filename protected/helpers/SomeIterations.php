<?php
/**
 *  Мелкие итерации
 */
class SomeIterations
{
    public static function selectRoot($model)
    {
      $new = $tree = array();
      // корни
      foreach ($model as $m)  {
        if ((int)$m->parent_id === 0) {
          $roots[$m->id] = $m->name; 
        }
      }
      // потомки
      foreach ($model as $m) {
        if (array_key_exists($m->parent_id, $roots) ) {
          $s_key = $m->parent_id . '_' . $roots[$m->parent_id];
          if (empty($tree[$s_key])) {
            $tree[$s_key] = array();
          }
          $tree[$s_key][] = $m->id . '_' . $m->name; 
        } else {
          $tree[$m->id. '_' . $m->name] = 0;
        }       
      }
      return $tree;
    }  
  
  public static function menuItems($tree) {
    foreach ($tree as $key => $value) {
      $splited_key = explode('_', $key);
      $items[$splited_key[0]] = $splited_key[1];    
      $disabled[$splited_key[0]] = array('disabled'=>true);
      if ($value !== 0) {
        //$splited_key = explode('_', $key);
        //$items[$splited_key[0]] = $splited_key[1];                 
        foreach ($value as $child) {
          $splited_val = explode('_', $child);
          $items[$splited_val[0]] = '----' . $splited_val[1];
        }
      } 
    }  
    return array('items' => $items, 'disabled' => $disabled);
  }  
  
  public static function activeMenuItems($tree) {
    foreach ($tree as $key => $value) {
      $splited_key = explode('_', $key);
      $items[$splited_key[0]] = $splited_key[1];    
      
      if ($value !== 0) {
        $disabled[$splited_key[0]] = array('disabled'=>true);
        //$splited_key = explode('_', $key);
        //$items[$splited_key[0]] = $splited_key[1];                 
        foreach ($value as $child) {
          $splited_val = explode('_', $child);
          $items[$splited_val[0]] = '----' . $splited_val[1];
        }
      } 
    }  
    return array('items' => $items, 'disabled' => $disabled);
  }    
}