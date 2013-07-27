<?php
return CMap::mergeArray(require(dirname(__FILE__).'/local.php'),
array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'BABYFG',
  'params' => array(
      'adminEmail' => 'haha.artur@mail.ru',
      //'phonenumber' => '79622496449'
  ),
  'language'=>'ru',
	// preloading 'log' component
  'preload'=>array(//
    'log',
    'bootstrap',
  ),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
    'application.helpers.*',
		'application.components.*',
    'application.components.widgets.*',
    'application.modules.user.models.*',
    'application.modules.user.components.*',
    'application.modules.user.controllers.*',    
    'application.modules.content.models.*',
    'application.modules.content.components.*',   
    'application.modules.manage.models.*',
    'application.modules.manage.components.*',   
    'application.modules.static.models.*',
    'application.modules.static.components.*',    
    'application.modules.content.widgets.grid.*',
	),
  'modules'=>array(
    'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'1',
      'ipFilters'=>array('127.0.0.1','::1'),
      'generatorPaths'=>array(
        'bootstrap.gii',
      ),
    ),               
    'user'=>array(
      # encrypting method (php hash function)
      'hash' => 'md5',

      # send activation email
      'sendActivationMail' => true,

      # allow access for non-activated users
      'loginNotActiv' => false,

      # activate user on registration (only sendActivationMail = false)
      'activeAfterRegister' => false,

      # automatically login from registration
      'autoLogin' => true,

      # registration path
      'registrationUrl' => array('/user/registration'),

      # recovery password path
      'recoveryUrl' => array('/user/recovery/recovery'),

      # login form path
      'loginUrl' => array('/user/login'),

      # page after login
      'returnUrl' => array('/user/profile'),

      # page after logout
      'returnLogoutUrl' => array('/user/login'),
    ),  
    'static', 'content', 'manage'            
  ),
	// application components
	'components'=>array(
    'cache'=>array(
      'cachePath' => 'runtime/cache',
      'class' => 'CFileCache',
    ),    
    'bootstrap'=>array(
      'class'=>'application.extensions.yiibootstrap.components.Bootstrap',
    ), 
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'db'=>array(
			'emulatePrepare' => true,
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
      'enableProfiling' => true,
      'enableParamLogging' => true
		),                
    'ih'=>array(
      'class'=>'CImageHandler',
    ),     
		'user'=>array(
      // enable cookie-based authentication
      'class' => 'WebUser',
      'allowAutoLogin'=>true,
      'loginUrl' => array('/user/login'),
		),            
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
      'showScriptName' => false,
			'rules'=>array(
        ''=>'site/index',
        //'<action:search>' => '/content/<action>',static/static/news
        '<controller:store>' => '/content/<controller>/listbymenu',
        '<controller:store>/<action:[^\d]\w+>' => '/content/<controller>/<action>/',
        '<controller:store>/<action:[^\d]\w+>/menu/<id:\d+>' => '/content/<controller>/<action>/menu/<id>',
        '<controller:store>/<action:[^\d]\w+>/id/<id:\d+>' => '/content/<controller>/<action>/id/<id>',
        '<controller:store>/<action:[^\d]\w+>/menu/<id:\d+>/field/<field:.+>' => '/content/<controller>/<action>/menu/<id>',
        '<controller:store>/<id:\d+>' => '/content/<controller>/item/id/<id>',
        '<action:feedback|contacts|payment>' => 'static/static/<action>',
        '<action:news>/<id:\d+>' => 'static/static/<action>/id/<id>',
        '<action:recovery>'=>'/user/recovery/<action>',
        '<action:registration|login|logout>'=>'/user/<action>',
        '<action:article>/<id:\d+>' =>'static/static/<action>/id/<id>'
			),
		),            
    // Настройки пагинатора
    'widgetFactory' => array(
      'widgets' => array(
          'CLinkPager' => array(
              'header'         => 'Перейти к странице:',
              'firstPageLabel' => '&larr; Первая',
              'prevPageLabel'  => '&larr; Предыдущая',
              'nextPageLabel'  => 'Следующая &rarr;',
              'lastPageLabel'  => 'Последняя &rarr;',
          ),                  
      ),
    ),                        
	),
));


