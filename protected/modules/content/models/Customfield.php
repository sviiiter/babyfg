<?php

class Customfield extends CActiveRecord
{
  const CUSTOM1 = '1'; // первый параметр
  const CUSTOM2 = '2'; // второй параметр
  
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
		return 'customfield';
	}
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('pic_name', 'file', 'types'=>'jpg,gif,png', 'maxSize'=>'204800', 'allowEmpty'=>true, 'on'=>'file'),                     
            array('name, custom_id', 'required'),
              //array('name', 'safe'),
    );
  }
        
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
      'tovar' =>  array(self::BELONGS_TO, 'Tovar', 'tovar_id')
			//'brands'=>array(self::HAS_ONE, 'Brands', 'brand'),
		);		
		return $relations;
	}  
        
        /*public function safeAttributes() {
        return array('name,quantity,price,brand,pic_name');
        }         */
        public function scopes()
        {
            return array(
                'notsafe'=>array(
                    'select' => 'tovar_id, name',
                ),
            );
        }
        
   /* public function getTableSchema()
    {
        $table = parent::getTableSchema();
 
        $table->columns['brand']->isForeignKey = true;
        $table->foreignKeys['brand'] = array('Brands', 'brand');
 
        return $table;
    }        */
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
      'name' => 'Введите параметр',
      'custom_id' =>  'Параметр'
		);
	}        
}
?>
