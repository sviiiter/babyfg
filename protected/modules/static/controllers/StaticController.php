<?php
// Везде isGuest!!
class StaticController extends Controller
{
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}

	public function accessRules()
	{
		return array(
			array('allow', 
				'actions' => array('contacts','feedback','news','payment','article', 'measurement'),
				'users'=>array('*'),
			),            
			array('allow', 
				'actions'=>array('EditMeasurement', 'editcontacts','allfeedback','deletefeed','addnews','editpayment','editnews','props','editarticles','editmainarticle'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  
				'users'=>array('*'),
			),
		);
	} 
    
    public function actionEditmainarticle(){
        $this->breadcrumbs=array(
                'Редактировать главную статью' 
        );   
        $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать главную статью';        
        $result = Proposals::model()->findByPk(2);
            if(isset($_POST['Proposals'])){                                
                    if(strlen($_POST['Proposals']['indextext'])>1){  
                        $result->scenario = 'indexpage';
                        $result->attributes = Yii::app()->request->getParam('Proposals');
                        $result->save();
                        Yii::app()->user->setFlash('success', 'Успешно.');
                    }
            }
        $this->render('mainarticle_edit',array('model'=>$result));
    }   
    
    /*public function actionMainarticle(){     
        $model = Proposals::model()->findByPk(2);
        $this->breadcrumbs=array(
                $model->caption 
        );   
        $this->pageTitle = '"'.Yii::app()->name.'" - '.$model->caption;
        $this->render('article', array('model'=>$model));
    } */   
    
    public function actionArticle($id){ 
        if(!$id)
            throw new CHttpException('404','Страница не найдена');

        $model = Tovartype::model()->findByPk($id);
        $this->breadcrumbs=array(
                $model->caption 
        ); 
        $this->addwords_start = str_replace('.', '', $model->caption) . ', магазин детской одежды, детская одежда';          
        $this->pageTitle = str_replace('.', '', $model->caption)  . "." 
                . str_replace(array('&nbsp;','&mdash;'), ' ', strip_tags(substr($model->description, 0, strpos($model->description, '.'))))
                . "|\"" . Yii::app()->name . "\"";
        $this->pageTitle = str_replace('  ', ' ', $this->pageTitle);
        $this->description = str_replace('.', '', $model->caption) . ". Купить в магазине детской одежды " . Yii::app()->name ;        
        $this->render('article', array('model'=>$model));
    }

    public function actionEditarticles(){
        $this->breadcrumbs=array(
            'Редактировать статьи' 
        );   
        $this->pageTitle = '"'.Yii::app()->name.'" - Редактировать статьи';        
        $model = new Tovartype;
            if(isset($_POST['Tovartype'])){
                $result = $model->findByPk($_POST['Tovartype']['type']);                
                    if(strlen($_POST['Tovartype']['description'])>1 && strlen($_POST['Tovartype']['caption'])>1){
                        $result->scenario = 'articles';
                        $type = $result->type;
                        $result->attributes = Yii::app()->request->getParam('Tovartype');
                        $result->type = $type;
                        $result->save();
                        Yii::app()->user->setFlash('success', 'Успешно.');
                    }else
                        $model = $result;
            }
        $this->render('typedescription',array('model'=>$model));
    }    
    
    public function actionEditContacts(){
        $this->breadcrumbs=array(
                'Контакты'=>'/static/static/contacts',
                'Редактировать контакты' 
        );
        $this->pageTitle = '"'.Yii::app()->name.'" - Контакты';

        if(!Yii::app()->user->isGuest){                            
            if(!Yii::app()->getModule('user')->isAdmin()){
                throw new CHttpException(404,'The requested page does not exist.');
            }

            $company = new Company;
            $model = $company->findByPk(1);
                if(isset($_POST['Company'])){
                    $model->attributes = $_POST['Company'];
                        if($model->validate()){
                            $model->isNewRecord ? $model->save() : $model->update(); 
                            Yii::app()->user->setFlash('contact saved', 'Контакт сохранен.');
                        }
                }
            $this->render('editcontacts', array('model' => $model));
        }
        else
            throw new CHttpException(404,'The requested page does not exist.');
    }
    
    public function actionEditMeasurement() 
    {
        if (Yii::app()->user->isGuest) {
          throw new CHttpException(404,'The requested page does not exist.');
        }      
      
        $this->breadcrumbs=array(
                'Контакты'=>'/static/static/contacts',
                'Редактировать размеры' 
        );
        $this->pageTitle = '"'.Yii::app()->name.'" - Размеры';

        if(!Yii::app()->getModule('user')->isAdmin()){
            throw new CHttpException(404,'The requested page does not exist.');
        }

        $company = new Company;
        $model = $company->findByPk(1);
            if(isset($_POST['Company'])){
                $model->attributes = $_POST['Company'];
                    if($model->validate()){
                        $model->isNewRecord ? $model->save() : $model->update(); 
                        Yii::app()->user->setFlash('Measure saved', 'Размеры сохранен.');
                    }
            }
        $this->render('editmeasurement', array('model' => $model));                   
    }    
    
        public function actionMeasurement()
        {
            $this->pageTitle = '"'.Yii::app()->name.'" - Размеры';
            $company = new Company;
            $model = $company->findByPk(1);
            $this->render('measurement', array('model' => $model));
        }    
    
    
        public function actionContacts()
        {
            $this->pageTitle = '"'.Yii::app()->name.'" - Контакты';
            $company = new Company;
            $model = $company->findByPk(1);
            $this->render('contacts', array('model' => $model));
        }
        
        public function actionPayment()
        {
            $this->pageTitle = '"'.Yii::app()->name.'" - Оплата и доставка';
            $company = new Company;
            $model = $company->findByPk(1);
            $this->render('payment', array('model' => $model));
        }
        public function actionEditPayment()
        {
            $this->pageTitle = '"'.Yii::app()->name.'" - Оплата и доставка';
            $this->breadcrumbs=array(
                    'Оплата и доставка'=>'/static/static/payment',
                    'Редактировать' 
            );              
            if(!Yii::app()->user->isGuest)
            {                           
                $user = User::model()->findByPk(Yii::app()->user->id);
                if($user->status != 1)
                {
                    throw new CHttpException(404,'The requested page does not exist.');
                }            
                $company = new Company;
                $model = $company->findByPk(1);
                    if(isset($_POST['Company']))
                    {
                        $model->attributes = $_POST['Company'];
                            if($model->validate())
                            {
                                $model->isNewRecord ? $model->save() : $model->update(); 
                                Yii::app()->user->setFlash('payment saved', 'Информация сохранена.');
                            }
                    }            

                $this->render('editpayment', array('model' => $model));
            }
            else
                throw new CHttpException(404,'The requested page does not exist.');
        }  
        
      public function actionAddnews()
      {
        $this->pageTitle = '"'.Yii::app()->name.'" - Новости'; 
        $this->breadcrumbs=array(
          'Новости'=>'/static/static/news',
          'Добавить новость' 
         );                       
        $model = new News;
        if (isset($_POST['News'])) {
          $model->attributes = $_POST['News'];
          $model->scenario = 'create';
          if ($model->validate()) {
            $model->isNewRecord ? $model->save() : $model->update(); 
            Yii::app()->user->setFlash('news saved', 'Новость сохранена.');
          }
        }                        
        $this->render('news/editnews', array('model' => $model));    
      }      
       
       public function actionNews()
       {
           $this->pageTitle = '"'.Yii::app()->name.'" - Новости'; 
           $this->breadcrumbs=array(
                    'Новости',
            );            
           if(isset($_GET['id']))
           {
                $model = News::model()->findByPk($_GET['id']);
                $this->render('news/one', array('model' => $model));
           }
           else
           {
                $criteria = new CDbCriteria;
                $criteria->order = 'date DESC';
                $pages=new CPagination(News::model()->count($criteria));
                $pages->pageSize = 10;
                $pages->applyLimit($criteria);
                $model = News::model()->findAll($criteria);
                $this->render('news/news', array('model' => $model, 'pages' => $pages));
           }
       }
       
       public function actionEditnews()
       {
           $this->pageTitle = '"'.Yii::app()->name.'" - Новости'; 
           $this->breadcrumbs=array(
                    'Новости'=>'/static/static/news',
                    'Редактировать новость' 
            );            
           $model = News::model()->findByPk($_GET['id']);
           if(isset($_POST['News']))
           {
               $model->attributes = $_POST['News'];
               if($model->validate())
               {
                   $model->update();
                   Yii::app()->user->setFlash('news saved', 'Новость сохранена.');
               }
           }           
           $this->render('news/editnews', array('model' => $model));
       }  
       
       public function actionFeedback()
       {
           $this->pageTitle = '"'.Yii::app()->name.'" - Задать вопрос';
           if(!Yii::app()->user->isGuest)
           {
                $user = User::model()->findByPk(Yii::app()->user->id); 
                $profile = $user->profile;
           }
           else $user = array();  
           $model = new Feedback;
                if(isset($_POST['Feedback']))
                {
                    if(!Yii::app()->user->isGuest)
                    {
                        $user = User::model()->findByPk(Yii::app()->user->id);                        
                        $model->name = $profile->firstname;
                        $model->phone = $user->mob_phone;
                        $model->email = $user->email;
                        $model->text = $_POST['Feedback']['text'];
                    }
                    else
                    {
                        $model->attributes = $_POST['Feedback'];
                        $user = array();
                    }
                    
                    if($model->validate())
                    {
                        $model->isNewRecord ? $model->save() : $model->update();
                        Yii::app()->user->setFlash('feed saved', 'Ваше сообщение отправлено');
                    }                                                            
                }                      
            $this->render('feedback/feedback', array('model' => $model, 'user' => $user));               
       }
       
       public function actionAllfeedback()
       {           
           if(!Yii::app()->user->isGuest)
            {
               $this->pageTitle = '"'.Yii::app()->name.'" - Задать вопрос';
                $user = User::model()->findByPk(Yii::app()->user->id);
                if($user->status != 1)
                {
                    throw new CHttpException(404,'The requested page does not exist.');
                } 
                
                if(isset($_GET['id']))
                {
                    $model = Feedback::model()->findByPk($_GET['id']);   
                    $this->render('feedback/one', array('model' => $model));                    
                }
                else
                {
                    $criteria = new CDbCriteria;
                    $criteria->params = array(
                        'order'=>'date DESC',
                    );
                    $pages=new CPagination(Feedback::model()->count($criteria));
                    $pages->pageSize = 10;
                    $pages->applyLimit($criteria);
                    $model = Feedback::model()->findAll($criteria);   
                    $this->render('feedback/allfeedback', array('model' => $model, 'pages' => $pages));
                }                 
            }
       }
       
       public function actionDeleteFeed()
       {
           if(!Yii::app()->user->isGuest)
            { 
                $this->pageTitle = '"'.Yii::app()->name.'" - Задать вопрос';
                $user = User::model()->findByPk(Yii::app()->user->id);
                if($user->status != 1)
                {
                    throw new CHttpException(404,'The requested page does not exist.');
                } 
                if(isset($_GET['id']))
                {
                    $model = Feedback::model()->findByPk($_GET['id']);   
                    $model->delete(); 
                    Yii::app()->user->setFlash('mess deleted', 'Сообщение удалено');
                }                
                $this->render('feedback/one');
            }
           else
              throw new CHttpException(404,'The requested page does not exist.');
       }
       
       public function actionProps()
       {
           $this->pageTitle = '"'.Yii::app()->name.'" - Акция';
            $this->breadcrumbs=array(
                    'Добавить акцию' 
            );             
           if(isset($_POST['content']))
           {
               $model = Proposals::model()->findByPk(1);
               $model->data = $_POST['content'];
               $model->update();
               Yii::app()->user->setFlash('prop saved', 'Акция сохранена');
           }
           $this->render('props/editprop');
       }       
}