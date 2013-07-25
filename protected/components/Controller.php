<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/main';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();
        
    public $addwords_start = '';
    public $addwords_end = '';      
    public $description = '';  
        
    public function init(){
        if (preg_match('!(:?manage/manage)!', Yii::app()->request->requestUri)) {       
          Yii::app()->clientscript->registerCssFile('/css/main_addon.css');
        }
        if (preg_match('!(:?store/item/id)|(:?static/static/news)|(:?static/static/article/id/)|(:?content/store/)|(:?user/recovery)|(:?user/registration)|(:?user/login)|(:?user/logout)|(:?static/static/feedback)|(:?static/static/contacts)|(:?static/static/payment)!', Yii::app()->request->requestUri))
                $this->redirect('/');        
    }
}