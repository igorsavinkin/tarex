<?php
/* @var $this EventsController */
/* @var $model Events */

	$UserRole=Yii::app()->user->role;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
 
?> 
<h3><?php  
  echo '<em>' , Yii::t('general', $model->EventType->name), '</em> №'.$model->id.' '.Yii::t('general','from date').' ', Controller::FConvertDate($model->Begin);
  ?></h3>

<?php
	$this->widget('CTabView', array(
	'tabs'=>array(
		 'tab1'=>array(
			'title'=>Yii::t('general', 'Main'), //'Основное', 
			'view'=>'_main',
			'data'=>array('model'=>$model),				
		 ), 			
	)));
?>