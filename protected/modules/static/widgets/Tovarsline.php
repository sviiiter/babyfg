<?php 
class Tovarsline extends CWidget
{
    public $type;
    public $caption;
    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }
 
    public function run()
    {         
        $model = Tovar::model()->findAll(new CDbCriteria(array(
                        'condition' => 'tovartype=:tovartype',
                        'params' => array(':tovartype' => $this->type),
                        'order' => 'rand()',
                        'limit' => 3
                )));
       
        CWidget::render('tovarsline', array('model' => $model));
    }    
}