<?php
/* @var $this SiteController */


	echo 'тест <br>';
	
	$Value='12345';
	
	echo CHtml::Link('Ссылка1', array('site/denis1', 'Value'=>$Value   ));
	echo CHtml::Link('Ссылка2', array('site/denis1', 'Value'=>'3'   ));
?>