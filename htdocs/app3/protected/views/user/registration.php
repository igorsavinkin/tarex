<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */
$this->renderPartial('registration_organization',array(
	'model'=>$model,
));
/*
$this->widget('CTabView', array(
		// 'htmlOptions'=>array('class'=>'no-print'),
		//'activeTab'=>'tab' . $activeTab,
		'tabs'=>array(
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Private person'), //'Основное', 
				'view'=>'registration_private',
				'data'=>array('model'=>$model),
				//'itemOptions'=>array('class'=>'inbox', 'title'=>'click here to read the mail'),
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Organization'), //'Доступ', 
				'view'=>'registration_private',
				//'view'=>'_ordercontent2',
				'data'=>array('model'=>$model),
				'active'=>true,
			),			
		)));
*/		
?> 