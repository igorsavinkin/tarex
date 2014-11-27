<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
	'import' => array(
			'application.extensions.shoppingCart.*',
			'application.models.*',			 
			'application.extensions.PHPExcel', 
			'application.extensions.PHPMailer', 
			
			'application.extensions.*',
			
		),
	// application components
	'components'=>array(
		
		/* 'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'request' => array(
			'hostInfo' => 'http://tarex.ru',
		/*	'baseUrl' => '',
			'scriptUrl' => '',*/
		), 
		'urlManager' => array(
			'baseUrl' => 'http://tarex.ru',
		),
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
	 
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
		
	),
	'params'=>array( 
		'organization'=>7, 
	),
);