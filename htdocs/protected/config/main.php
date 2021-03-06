<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');

Yii::setPathOfAlias('phpexcel', dirname(__FILE__).'/../extensions/PHPExcel');

Yii::setPathOfAlias('select2', dirname(__FILE__).'/../extensions/select2');

Yii::setPathOfAlias('XSelect2', dirname(__FILE__).'/../extensions/widgets/select2');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'"Тарекс" - автозапчасти для иномарок оптом. Доставка запчастей оптом в регионы', //'Tarex v.3.4',	
	//'defaultController' => 'MyFrontend',
	'language'=>'ru',
	'sourceLanguage'=> 'en_US',
	// preloading 'log' component
	'preload'=>array('log'),
	// for gzip http requests compressing
	'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
	'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
	// autoloading model and component classes
	'import'=>array(
		'select2.*',
		'application.models.*',
		'application.components.*',
		'application.extensions.*', 
		'application.extensions.shoppingCart.*',	
		'application.extensions.magnific-popup.*',  
       	'application.extensions.EchMultiSelect.*',
       	'application.extensions.tinymce.*',
       	'application.extensions.EJuiDateTimePicker.*',
	),
	'controllerMap'=>array(
		'YiiFeedWidget' => 'ext.yii-feed-widget.YiiFeedWidgetController'
	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Saturn78',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'), 
			'ipFilters'=>array('*.*.*.*','::1'),
		),
		
	),
	
	// application components
	'components'=>array(
		'cache'=>array(
			'class'=>'system.caching.CFileCache',
				//	'connectionID'=>'db',
				//	'autoCreateCacheTable'=>false,
				//	'cacheTableName'=>'cache',
				),
		'memcache'=>array(
		   'class'=>'system.caching.CMemCache',
		 ),
		'formatter' => [
		  'class' => 'yii\i18n\Formatter'
		],
		'shoppingCart' =>
			array(
				'class' => 'ext.shoppingCart.EShoppingCart', /*.yiiext.components.*/
				'discounts' =>
				array(
					array(
						'class' => 'ext.shoppingCart.discounts.TestDiscount',
						'rate' => 40), /*.yiiext.components*/
						//array('class' => 'otherDiscount'),
						),
			),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'WebUser', 
			 
		),
		'request'=>array(
            'enableCsrfValidation'=>true,
        ),
		'authManager' => array(
			// Будем использовать свой менеджер авторизации
			'class' => 'PhpAuthManager',
			// Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
			'defaultRoles' => array('guest'),
		//	'connectionID'=>'db',
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array( 
			'showScriptName'=>false,
	//		'caseSensitive'=>false,
   //		'enablePrettyUrl' => true, for yii2 only
			'urlFormat'=>'path',
			'rules'=>array( 	
			 	 'assortment/<groupCategory:\d+>'=> 'assortment/index',			
				 'site/page/<page:\w+>'=> 'site/index',			
	        	 'assortment/<groupCategory:\d+>/<id:\d+>'=> 'assortment/index', 
				 
			/*	'<controller:\w+>/<id:\d+>'=>'<controller>/view',*/
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',  
			),  
		), 
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'db'=>array(			
                // настройки для конфигурации в производство 
			'connectionString' => 
			'mysql:host=localhost;dbname=srv50213_tarex',
			'emulatePrepare' => true,
			'schemaCachingDuration' => 3600,
			'username' => 'srv50213_admin',
			'password' => 'NNK8tvx1',
			'charset' => 'utf8',
			'tablePrefix' => 'tarex_', 
			'class'         => 'CDbConnection'   
		),
		'otherDb'=>array(			
                // настройки для конфигурации 217.28.212.98 '; 
			'connectionString' => 
			'mysql:host=217.28.212.98;dbname=tarex',
			'emulatePrepare' => true,
			'enableParamLogging' => true,
			'username' => 'testuser1',
			'password' => 'Saturn78',
			'charset' => 'utf8',
			'tablePrefix' => 'yiiapp_', 
			'class'         => 'CDbConnection'   
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
				),
			/*	 array( //  to show log messages on web pages
					'class'=>'CWebLogRoute',
					'categories'=>'system.db.*',
					//'except'=>'system.db.ar.*', // показываем всё, что касается базы данных, но не касается AR
				), */
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	// v 3.4
	'params'=>array(
		// this is used in contact page
	    'shopOrder'=>'',
		'organization'=>7, // информация об организации хранится в массиве "params"
		'adminEmail'=>'vyacheslav.sladkov@gmail.com', //'info@tarex.ru', //'igor.savinkin@gmail.com',
		'generalManagerEmail'=>'auto@tarex.ru', // 'mr.Sladkoff@yandex.ru', // // 'igor.savinkin@gmail.com', // //'igor.savinkin@gmail.com',
		'defaultPageSize'=>34,
		'maxPageSize'=>10000,
		'returnUrl'=>'345',
	//	'Subsystem' => $_GET['Subsystem'], 
	//	'Reference' => $_GET['Reference'], 
	),
);