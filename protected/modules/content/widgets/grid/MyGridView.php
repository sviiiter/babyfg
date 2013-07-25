<?php
Yii::import('zii.widgets.grid.CGridView');
    class MyGridView extends CGridView
    {            
     public $widview;    
        
     public function renderTableRow($row) {
         $dp = $this->dataProvider->getData();
         $this->render($this->widview, array('data'=>$dp[$row]));  //Yii::app()->getModule('user')->widgetspath.'.table.views.item'
     }
        
     
     public function renderTableHeader() {
         if(Yii::app()->user->hasFlash('error')){
             $message = Yii::app()->user->getFlash('error');
             echo '<div class="alert alert-error">'.$message.'</div>';
             Yii::app()->user->setFlash('error',$message);
         }         
     }        
    }