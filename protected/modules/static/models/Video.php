<?php
class Video extends CActiveRecord
{    

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'video';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array('phone', 'match', 'pattern' => '/^[\d+\s]+$/','message' => 'Поле должно только цифры'),
                        array('embedlink, imglink', 'required'),
                    );
        }  
        
	public function attributeLabels()
	{
		return array(
                        'embedlink'=>'Ссылка на youtube.com',
                        'imglink'=>'Префью картинка'
		);
	}          
}
?>
