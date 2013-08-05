<?php
class Orderitems extends CActiveRecord
{
    /**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_items';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(		
      array('tovar_id, quantity, order_id', 'required'),
      array('custom', 'safe'),
    );
  }  
        
	public function relations()
	{
		$relations = array(
      'tovars' => array(self::BELONGS_TO, 'Tovar', array('tovar_id'=>'id')),
      'customfield1' => array(self::BELONGS_TO, 'Customfield', 'custom1'),
      'customfield2' => array(self::BELONGS_TO, 'Customfield', 'custom2'),
		);
		if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations,Yii::app()->getModule('user')->relations);
		return $relations;
	}
}
?>
