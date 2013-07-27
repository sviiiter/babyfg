<?php

class Tovar extends CActiveRecord
{
    public $pic_name;
    public $thumbs;
    public $brand;
    public $cus1_values;
    public $cus2_values;


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
		return 'tovar';
	}
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
      //array('pic_name', 'file', 'types'=>'jpg,gif,png', 'maxSize'=>'204800', 'allowEmpty'=>true, 'on'=>'file'),
      array('name', 'length', 'max'=>58),
      array('name,description,menu_id_item,instore,artikul,country,custom1,custom2', 'required'),
      array('price1, price2, price3, price4', 'default', 'value'  => 0),
      array('extended,tovartype', 'safe'),
      array('id, name, price, brand, pic_name, description, extended, custom, tovartype', 'safe', 'on'=>'search'),
    );
  }
        
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
      'brands'  =>  array(self::BELONGS_TO, 'Brands', 'brand'),
      'types' =>  array(self::BELONGS_TO, 'Tovartype', 'tovartype'),
      'items' =>  array(self::HAS_MANY, 'Orderitems', 'tovar_id'),
      'customfield1' =>  array(self::HAS_MANY, 'Customfield', 'tovar_id',
        'on'  =>  'customfield1.custom_id = :custom_id',
        'params'  =>  array(':custom_id' => '1'),
        'index' => 'id'
      ),
      'customfield2' =>  array(self::HAS_MANY, 'Customfield', 'tovar_id',
        'on'  =>  'customfield2.custom_id = :custom_id',
        'params'  =>  array(':custom_id' => '2'),
        'index' => 'id'
      ),      
      'customfields' =>  array(self::HAS_MANY, 'Customfield', 'tovar_id'),
      'menu'  =>  array(self::BELONGS_TO, 'NavigationItems', 'menu_id_item'),
      'pictures'  =>  array(self::HAS_MANY, 'TovarPics', 'tovar_id'),
      'cover'  =>  array(self::HAS_MANY, 'TovarPics', 'tovar_id',           
        'on' =>  'is_cover = :is_cover',
        'params'  =>  array('is_cover'  =>  '1')
      ),
		);		
		return $relations;
	}  
        
  public function scopes()
  {
      return array(
          'notsafe'=>array(
              'select' => 'id,name,quantity,price,brand,pic_name,description,extended',
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
      'name'  =>  'Наименование',
      'quantity'  =>  'Количество в упаковке',
      'price1' =>  'Цена1',
      'price2' =>  'Цена2',
      'price3' =>  'Цена3',
      'price4' =>  'Цена4',
      'brand' =>  'Брэнд',
      'pic_name'  =>  'Картинка',     
      'description' =>  'Описание',
      'custom1'  =>  'Первый дополнительный параметр',
      'custom2'  =>  'Второй дополнительный параметр',
      'extended'  =>  'Описание',
      'tovartype' =>  'Тип товара',
      'instore' =>  'Наличие на складе',
      'menu_id_item'  =>  'Раздел',
      'artikul' =>  'Артикул',
      'country' =>  'Производитель'
		);
	}     
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true,'OR');
		$criteria->compare('quantity',$this->quantity,true,'OR');
		//$criteria->compare('price',$this->price,true);
		//$criteria->compare('brand',$this->brand,true,'OR');
		//$criteria->compare('pic_name',$this->pic_name,true);
		$criteria->compare('description',$this->description,true,'OR');
		$criteria->compare('extended',$this->extended,true,'OR');
		$criteria->compare('custom',$this->custom,true,'OR');
		//$criteria->compare('tovartype',$this->tovartype,true,'OR');

		return new CActiveDataProvider($this, array(
      'pagination' => array('pageSize' => 10),
			'criteria'=>$criteria,
		));
	}        
}
?>
