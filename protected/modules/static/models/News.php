<?php
class News extends CActiveRecord
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
		return 'news';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array('phone', 'match', 'pattern' => '/^[\d+\s]+$/','message' => 'Поле должно только цифры'),
                        array('caption,text, date', 'safe'),
                    );
        }  
        
	public function attributeLabels()
	{
		return array(
                        'caption'=>'Заголовок',
                        'text'=>'Текст новости',
                        'date'=>'Дата',
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