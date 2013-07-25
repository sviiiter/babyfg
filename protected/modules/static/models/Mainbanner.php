<?php
class Mainbanner extends CActiveRecord
{    
        public function beforeSave() {
            if(parent::beforeSave())
            {
                $this->time = date("Y-m-d H:i:s");
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
		return 'bannermain';
	}    
        
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        //array('image', 'match', 'pattern' => '/^[^\s]+$/','message' => 'Поле не должно быть пустым'),
                        //array('image', 'required'),
                        array('image', 'file', 'types'=>'jpg, gif, png','maxSize' => 1148576),
                    );
        }  
        
	public function attributeLabels()
	{
		return array(
            'image'=>'Центральный баннер',
		);
	} 
        
    public function scopes()
    {
        return array(
            'recently'=>array(
                'order'=>'time DESC',
                'limit'=>5,
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