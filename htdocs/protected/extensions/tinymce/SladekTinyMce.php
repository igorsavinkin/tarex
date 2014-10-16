<?php

/**
  SladekTinyMCE
 */
 
class SladekTinyMce extends CInputWidget
{
 	 public function init()
    {
	$assetUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.tinymce.js.assets'));
	Yii::app()->clientScript->registerScriptFile($assetUrl.'/tinymce.min.js');
		
	}

}