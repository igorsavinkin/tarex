<?php
/* @var $this SiteController */

	$Value=$_GET['Value'];
	
	if ($Value=='12345'){
		echo 'test1<br>';
	}else{
		echo 'test3<br>';
	}
	
	echo CHtml::Link('Ссылка2', array('site/denis'));
	
	
?>