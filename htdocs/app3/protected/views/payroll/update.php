<?php
/* @var $this EventsController */
/* @var $model Events */ 
$this->pageTitle =Yii::t('general','Payment salary'); 
?> 
<h3><em><?php   
  echo  Yii::t('general', $model->EventType->name), '</em> ' , Yii::t('general','#') ,  $model->id, ' ', Yii::t('general','from date') , ' ' , Controller::FConvertDate($model->Begin); ?></h3>

  <?php $this->renderPartial('_main', array(
	'model'=>$model,
));?>