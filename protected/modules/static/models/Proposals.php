<?php
class Proposals extends CActiveRecord
{            
	public $emblem;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'proposals';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array('phone', 'match', 'pattern' => '/^[\d+\s]+$/','message' => 'Поле должно только цифры'),
                        array('data,indextext', 'safe'),
                        array('indextext', 'required', 'on'=>'indexpage'),
                    );
        }  
                
        public function scopes()
        {
            return array(
                'recently'=>array(
                    'order'=>'date DESC',
                    'limit'=>2,
                ),
            ); 
            return array(
                'common'=>array(
                    'order'=>'date DESC',
                ),
            );              
        }
        
        public function attributeLabels(){
            return array(
                'indextext' => 'Текст'
            );
        }
}
?>