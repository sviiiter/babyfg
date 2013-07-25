<?php
class Brands extends CActiveRecord
{
   public $brand;
    
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
		return 'brands';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brand', 'required'),
                        //array('brand', 'match', 'pattern' => '/^[\wА-я]+$/','message' => 'Поле должно содержать букв'),
                    );
        }        
        
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'tovar'=>array(self::HAS_MANY, 'Tovar', 'brand'),
		);		
		return $relations;
	}  
        
    public function scopes()
    {
        return array(
            'notsafe'=>array(
            	'select' => 'brand',
            ),
        );
    } 
    
    public function getTableSchema()
    {
        $table = parent::getTableSchema();
 
        $table->columns['brand']->isForeignKey = true;
        $table->foreignKeys['brand'] = array('Tovar', 'brand');
 
        return $table;
    } 
    
	public function attributeLabels()
	{
		return array(
                        'brand'=>'Производитель',
		);
	}     
            
}

