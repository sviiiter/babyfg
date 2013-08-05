<?php

class ContentModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'content.models.*',
			'content.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
        
    public static function getItems(){
			$items = array();
      if ( isset(Yii::app()->session['id']) ) {				
        foreach (Yii::app()->session['id'] as $key => $value) {
          $item = explode('_', $key);              
          array_push($item , $value);
          $items[ $item[0] ][$key] = array(
            'id' => (isset($item[0])) ? $item[0] : null,
            'param1'  =>  (isset($item[1])) ? $item[1] : null,
            'param2'  =>  (isset($item[2])) ? $item[2] : null,
            'quantity'  =>  (isset($item[3])) ? $item[3] : null,
          );
          unset($item);
        }                                  
      }else $items = array();
      return $items;
    }
        
        /*public static function setParam($sessionparam, $cartitem)
        {
            if(isset(Yii::app()->session[$sessionparam]))
            {
                array_key_exists($cartitem, Yii::app()->session[$sessionparam]) ? $param = Yii::app()->session[$sessionparam][$cartitem] : ($sessionparam == 'quant' ? $param = 1 : $param = 'не задан');                    
            } else $sessionparam == 'quant' ? $param = 1 : $param = 'не задан';  
            return $param;
        }*/
        
      public static function sumprice(){
          $items = Yii::app()->session['id'];
          $sumprice = 0;            
          foreach ($items as $id => $properties) {
            $model = Tovar::model()->findByPk($id);
            foreach ($properties as $p) {
              $sumprice += $model->price * $p['quantity'];
            }            
          }
          return $sumprice;
      }
}
