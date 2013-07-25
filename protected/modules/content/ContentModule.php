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
            if(isset(Yii::app()->session['id'])){				
                foreach(Yii::app()->session['id'] as $key=>$cartitem){                    
                    if(!is_array($cartitem)){
                        $bit['id'] = $key;
                        $bit['quantity'] = $cartitem;
                        $bit['custom'] = 'не задан';
                        $items[] = $bit;
                    }else{
                        foreach ($cartitem as $cikey=>$civalue){
                           $bit['id'] = $key;
                           $bit['quantity'] = $civalue;
                           $bit['custom'] = $cikey;   
                           $items[] = $bit;
                        }
                    }
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
            $items = ContentModule::getItems();
            $i = 0;
            $sumprice = 0;            
            foreach ($items as $value) {
                $model = Tovar::model()->findByPk($value['id']);
                $sumprice += $model->price * $items[$i]['quantity'];
                $i++;  
            }
            return $sumprice;
        }
}
