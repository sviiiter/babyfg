<?php
class Company extends CActiveRecord
{    

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'companyinfo';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array('phone', 'match', 'pattern' => '/^[\d+\s]+$/','message' => 'Поле должно только цифры'),
                        array('contacts, payment', 'safe'),
                    );
        }  
        
	public function attributeLabels()
	{
		return array(
                        'contacts'=>'Контактная информация',
                        'payment'=>'Оплата и доставка'
		);
	}          
}
?>
