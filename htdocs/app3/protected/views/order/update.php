<?php
/* @var $this EventsController */
/* @var $model Events */
$UserRole=Yii::app()->user->role;
$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
//echo '<br>$loadDataSetting (in view) = '; print_r($loadDataSetting); 
?> 
<h3 style='margin-bottom: 10px;'><?php  
echo '<em>' , Yii::t('general',$model->EventType->name), '</em> №'.$model->id.' '.Yii::t('general','from date').' '. Controller::FConvertDate($model->Begin);  
if($model->eventNumber) echo ' ', Yii::t('general','#'), $model->eventNumber; ?></h3> 

<?php  	
//Менеджерам 	
	if (Yii::app()->user->checkAccess(User::ROLE_MANAGER)) {
	 $this->widget('CTabView', array( 
		'tabs'=>array(			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_main',
				'data'=>array('model'=>$model), 
			 ), 
	 	'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), //'Доступ', 
				//даём редактировать заказ до тех пор, пока он в работе или подтверждение доставки / заказа не пройдено
				'view'=> $CurrentStatusOrder <= 3   ? '_ordercontent_manager' : '_ordercontent_manager_noteditable',  
				'data'=>array('model'=>$model, 'eventId'=>$model->id ,
				      'loadDataSetting' => $loadDataSetting
				),
			//	'active'=>true,
			), 
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'),  
				'view'=>'_assortment', 
				'data'=>array('eventId'=>$model->id, 'contractorId'=>$model->contractorId,   'assortment'=>$assortment , 'pageSize'=>$pageSize),
				//'visible'=>($CurrentStatusOrder <= 3),
			),					
		)));
	} else {
// Клиентам  
		$this->widget('CTabView', array( 
		'tabs'=>array(			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_main',
				'data'=>array('model'=>$model), 
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), 
				// даём редактировать заказ до тех пор пока они не отправили его на подтверждение
				'view'=>($CurrentStatusOrder <= 2) ? '_ordercontent_client' : '_ordercontent_noteditable', 
				'data'=>array('model'=>$model, 'eventId'=>$model->id, 'loadDataSetting' => $loadDataSetting),
				'active'=>true,
			),
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'), //'Исполнение',
				'view'=>'_assortment', 
				'data'=>array('eventId'=>$model->id, 'contractorId'=>$model->contractorId,   'assortment'=>$assortment , 'pageSize'=>$pageSize), 
				'visible'=>($CurrentStatusOrder <= 2),
			),			
		)));
	}
?>