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
        foreach ($value as $child) {
          $splited_val = explode('_', $child);
          $items[$splited_val[0]] = '----' . $splited_val[1];
        }
      } 
    }  
    return array('items' => $items, 'disabled' => $disabled);
  }    
  
    /**
     *  Генератор xlsx файла.
     * @param array $labels заголовки столбцов
     * @param array $model CActiveRecord запись.
     */
    public static function toExcelOrders(array $model, $user){
        $excel = Yii::app()->excel;          
        $styleArray = array(
          'font' => array('bold' => true)
        );
                       
        $excel->getActiveSheet()->setCellValue('A1','id')->getStyle('A1')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('B1','Совершен')->getStyle('B1')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('C1','Сумма заказа')->getStyle('C1')->applyFromArray($styleArray);
        $i = 2;
        foreach ($model as $value) {
          $excel->getActiveSheet()->setCellValue('A'. $i, $value->id)->getStyle('A'. $i)->applyFromArray($styleArray);
          $excel->getActiveSheet()->setCellValue('B'. $i, $value->time)->getStyle('B'. $i)->applyFromArray($styleArray);
          $excel->getActiveSheet()->setCellValue('C'. $i, $value->sumprice . ' р')->getStyle('C'. $i)->applyFromArray($styleArray);
          $i++;
        }
                
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
        $filename = ( ( $user === 'all') ? 'All' : $user->username) . '_' . Yii::app()->dateFormatter->format( 'dd-MM-yyyy', time()) . '.xlsx';
        $path = YiiBase::getPathOfAlias('webroot') . '/download/' . $filename;
        
        $objWriter = new PHPExcel_Writer_Excel2007($excel);
        $file = $objWriter->save($path);
        
        header("Pragma: public"); 
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false); // нужен для некоторых браузеров
        header("Content-Type: application/xlsx");
        header("Content-Disposition: attachment; filename=\"" . $filename . "\";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($path)); 
        readfile($path); 
        unlink(YiiBase::getPathOfAlias('webroot') . '/download/' . $filename);
    }
    
    /**
     *  Генератор xlsx файла.
     * @param array $labels заголовки столбцов
     * @param array $model CActiveRecord запись.
     */
    public static function toExcelDetails($model) {
        $excel = Yii::app()->excel;          
        $styleArray = array( 'font' => array('bold' => true));
        $excel->getActiveSheet()->setCellValue('A1','Имя')->getStyle('A1')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('A2','Телефон')->getStyle('A2')->applyFromArray($styleArray);        
        $excel->getActiveSheet()->setCellValue('A3','Адрес доставки')->getStyle('A3')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('A4','Электронная почта')->getStyle('A4')->applyFromArray($styleArray);     
        $excel->getActiveSheet()->setCellValue('A5','Дополнительная информация:')->getStyle('A5')->applyFromArray($styleArray);  
        
        $excel->getActiveSheet()->setCellValue('B1', $model->person)->getStyle('B1')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('B2', $model->phone)->getStyle('B2')->applyFromArray($styleArray);        
        $excel->getActiveSheet()->setCellValue('B3', $model->adress)->getStyle('B3')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('B4', $model->email)->getStyle('B4')->applyFromArray($styleArray);     
        $excel->getActiveSheet()->setCellValue('B5', $model->additionalinfo)->getStyle('B5')->applyFromArray($styleArray);          
        
        $excel->getActiveSheet()->setCellValue('A7','№ Заказа')->getStyle('A7')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('B7','Артикул')->getStyle('B7')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('C7','Наименование')->getStyle('C7')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('D7','Параметр 1')->getStyle('D7')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('E7','Параметр 2')->getStyle('E7')->applyFromArray($styleArray);
        $excel->getActiveSheet()->setCellValue('F7','Количество')->getStyle('F7')->applyFromArray($styleArray);      
        $excel->getActiveSheet()->setCellValue('G7','Цена')->getStyle('G7')->applyFromArray($styleArray);
        
        $i = 8;
        $count = sizeof($model->orderitems);
        foreach ($model->orderitems as $data) {
          $excel->getActiveSheet()->setCellValue('A'. $i, $data->order_id)->getStyle('A'. $i)->applyFromArray($styleArray);
          $excel->getActiveSheet()->setCellValue('B'. $i, $data->tovars->artikul)->getStyle('B'. $i)->applyFromArray($styleArray);
          $excel->getActiveSheet()->setCellValue('C'. $i, $data->tovars->name)->getStyle('C'. $i)->applyFromArray($styleArray);
          $excel->getActiveSheet()->setCellValue('D'. $i, $data->tovars->custom1 . ': ' . ( (isset($data->customfield1)) ? $data->customfield1->name : ""))->getStyle('D'. $i)->applyFromArray($styleArray);
          $excel->getActiveSheet()->setCellValue('E'. $i, $data->tovars->custom2 . ': ' . ((isset($data->customfield2)) ? $data->customfield2->name : ""))->getStyle('E'. $i)->applyFromArray($styleArray);
          $excel->getActiveSheet()->setCellValue('F'. $i, $data->quantity)->getStyle('F'. $i)->applyFromArray($styleArray);    
          $excel->getActiveSheet()->setCellValue('G'. $i, $data->tovars->price . ' р')->getStyle('G'. $i)->applyFromArray($styleArray); 
          if ($count-- == 1) {
            $excel->getActiveSheet()->setCellValue( 'F'. ($i + 1), 'Общая сумма заказа')->getStyle( 'F'. ($i + 1))->applyFromArray($styleArray);    
            $excel->getActiveSheet()->setCellValue( 'G'. ($i + 1), $model->sumprice . ' р')->getStyle( 'G'. ($i + 1))->applyFromArray($styleArray);             
          } 
          $i++;
        }
                
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(24);        
        $filename = $model->phone . '_' . Yii::app()->dateFormatter->format( 'dd-MM-yyyy', time()) . '.xlsx';
        $path = YiiBase::getPathOfAlias('webroot') . '/download/' . $filename;
        
        $objWriter = new PHPExcel_Writer_Excel2007($excel);
        $file = $objWriter->save($path);
        
        header("Pragma: public"); 
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false); // нужен для некоторых браузеров
        header("Content-Type: application/xlsx");
        header("Content-Disposition: attachment; filename=\"" . $filename . "\";" );
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($path)); 
        readfile($path); 
        unlink(YiiBase::getPathOfAlias('webroot') . '/download/' . $filename);
    }    
}