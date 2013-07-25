<?php

/**
 * This is the model class for table "tovar_pics".
 *
 * The followings are the available columns in table 'tovar_pics':
 * @property integer $id
 * @property string $picname
 */
class TovarPics extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TovarPics the static model class
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
		return 'tovar_pics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tovar_id', 'required'),
      array('is_cover', 'safe'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('picname', 'length', 'max'=>50),
      array('picname', 'file', 'types'=>'jpeg, jpg, gif, png', 'allowEmpty'=>true, 'maxSize' => 1148576),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, picname', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'picname' => 'Название картинки',
      'is_cover'  =>  'Обложка'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('picname',$this->picname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}