<?php
return array(
  'preload'=>array(//
    'log',
  ),
  'components' => array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=babyfg',
			'username' => 'root',
			'password' => '',      
    ),
    'log'=>array(
      'class'=>'CLogRouter',
      'enabled'=>true,
      'routes'=>array(
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning',
        ),
            // uncomment the following to show log messages on web pages
         array(
          'class'=>'CProfileLogRoute',
          'report'=>'callstack',
          // Показывает время выполнения каждого отмеченного блока кода.
          // Значение "report" также можно указать как "callstack".
         ),				

         array( // -- CWebLogRoute ---------------------------
          'class'=>'CWebLogRoute',
          'levels'=>'error, warning, trace, profile, info',
          'enabled'=>true,
         ), 
         /*array(
             'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
             //'ipFilters'=>array('127.0.0.1'),
         )*/            
      ),
    ),    
  )  
);