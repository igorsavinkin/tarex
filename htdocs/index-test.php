<?php
$makes = array('nissan', 'toyota', 'ford');
$Field = $_GET['make'];
foreach($makes as $make){
	$FieldToCompare=mb_strtolower($make); 
	if (strstr($Field, "=")!=''){ 
			//	if (  $FieldToCompare !=  mb_strtolower(Substr($Field,1))){
			if ( $FieldToCompare  != mb_strtolower( Substr($Field,1 ))) continue; 
	} elseif (strstr($Field, ",")!='' || strstr($Field, ";")!=''){
		if(stristr($Field, $FieldToCompare)=='' ) continue;
	} elseif (stristr($Field, "Содержит")  != '' ){
		$Pos=strpos($Field, " "); 
		$SearchString =  mb_substr($Field, $Pos+1);
		if(stristr($FieldToCompare, $SearchString) === false ) continue;
	}  
	echo '<br>', $make; 
}
echo ' has passed';
	

/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */
/*
// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();*/

