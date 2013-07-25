<?php
class Feedback extends CActiveRecord
{            

    public function beforeSave() {
            if(parent::beforeSave())
            {
                $this->date = date("Y-m-d H:i:s");
                return true;
            }
            else
                return false;
        }    
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'feedback';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('phone', 'match', 'pattern' => '/^[\d+\s]+$/','message' => 'Поле должно только цифры','allowEmpty'=>true),
                        array('name', 'safe'),
                        array('email', 'email','allowEmpty'=>true),
                        array('text', 'required'),
                    );
        }  
        
	public function attributeLabels()
	{
		return array(
                        'name'=>'Ваше имя',
                        'phone'=>'Телефон',
                        'text'=>'Текст сообщения',
                        'email'=>'Электронная почта',
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
}
?>