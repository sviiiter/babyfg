<?php

class Tovartype extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tovartype';
	}
        
	public function rules()
	{
		return array(
                        array('type, description, caption', 'required', 'on'=>'articles'),
                        array('type, description, caption', 'safe'),
                    );
        }
        
	public function relations()
	{
		$relations = array(
		);		
		return $relations;
	}  
        
        public function scopes()
        {
            return array(               
            );
        }

	public function attributeLabels()
	{
		return array(
            'type'=>'Тип',
            'description'=>'Описание',
            'caption'=>'Заголовок статьи',
		);
	}        
}