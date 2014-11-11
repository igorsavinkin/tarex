<?php
/* @var $this EventsController */
/* @var $model Events */ 
?> 
<h3 style='margin-bottom: 10px;'><?php  
echo '<em>' , Yii::t('general',$model->EventType->name), '</em> №'.$model->id.' '.Yii::t('general','from date').' '. Controller::FConvertDate($model->Begin);  
if($model->eventNumber) echo ' ', Yii::t('general','#'), $model->eventNumber; ?></h3> 
<?php  
		$this->widget('CTabView', array( 
		'tabs'=>array( 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), //'Доступ', 
				'view'=>'_ordercontent_new',  
				'data'=>array('model'=>$model, 'eventId'=>$model->id,  'loadDataSetting' => $loadDataSetting),
				'active'=>true,
			),			
		))); 
?>