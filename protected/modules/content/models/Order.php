<?php

class Order extends CActiveRecord
{
  public $user_id;
  public $time;
  /**
 * Returns the static model of the specified AR class.
 * @return CActiveRecord the static model class
 */

  public function beforeSave()
  {
      if(parent::beforeSave())
      {               
          $this->time = date("Y-m-d H:i:s");
          return true;
      }
      else
          return false;
  }

  public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}
        
	public function rules()
	{
    return array(
      array('person,email,phone,adress', 'required'),
      array('email', 'email'),
      array('phone', 'match', 'pattern' => '/^[\d+]+$/','message' => 'Поле должно содержать цифры или знак \'+\'. Например, 792xxxxxxxx или +792xxxxxxxx'),               
      array('adress', 'length', 'min' => 10,'message' => 'Длина не должна быть меньше 10 символов'),
      array('additionalinfo', 'safe'),
    );
  } 

                /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
                        'orderitems'=>array(self::HAS_MANY, 'Orderitems', 'order_id'),                        
		);
		if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations,Yii::app()->getModule('user')->relations);
		return $relations;
	}   
        
	public function attributeLabels()
	{
		return array(
                        'person'=>'Имя',
                        'email' => 'Электронная почта',
                        'phone' => 'Телефон',
                        'adress' => 'Адрес',
                        'additionalinfo' => 'Дополнительная информация'
		);
	}          
        
  public function saveOrder($items, $order)
  {          
    $last = $order->id; 
    $transaction = Yii::app()->db->beginTransaction();
    try {            
      foreach ($items as $id => $item) {
        foreach ($item as $properties) {            
          $model = new Orderitems;  
          $model->order_id = $last;
          $model->tovar_id = $id;
          if ( isset($properties['quantity']))
            $model->quantity = $properties['quantity'];
          if ( isset($properties['param1']))
            $model->custom1 = $properties['param1'];   
          if ( isset($properties['param2']))
            $model->custom2 = $properties['param2'];    
          $model->save(); 
        }
      }
      $transaction->commit();
    } 
    catch (Exception $e) 
    {
      $transaction->rollback();
    }
  }
          
  public function getSumprice()
  {
    $sumprice = 0;
    foreach ($this->orderitems as $item) {
      $sumprice += $item->tovars->price * $item->quantity;
    }
    return $sumprice;
  }          
}
?>
