<?php
/* @var $this EventsController */
/* @var $model Events */ 
?> 
<h3><em><?php   
  echo  Yii::t('general', $model->EventType->name), '</em> ' , Yii::t('general','#') ,  $model->id, ' ', Yii::t('general','from date') , ' ' , Controller::FConvertDate($model->Begin); ?></h3>

  <?php $this->renderPartial('_main', array(
	'model'=>$model,
));
		/*$this->widget('CTabView', array(	
		'tabs'=>array(			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_main',
				'data'=>array('model'=>$model),				
			 ), 
		)));*/?>