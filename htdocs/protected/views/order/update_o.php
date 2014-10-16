<?php
/* @var $this EventsController */
/* @var $model Events */
$UserRole=Yii::app()->user->role;
$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;

Yii::app()->clientScript->registerScript('search3', " 
// nothing
"); ?> 
<h3 style='margin-bottom: 10px;'><?php  
echo '<em>' , Yii::t('general',$model->EventType->name), '</em> №'.$model->id.' '.Yii::t('general','from date').' '. Controller::FConvertDate($model->Begin);  
if($model->eventNumber) echo ' ', Yii::t('general','#'), $model->eventNumber; ?></h3> 

<?php  	
	//Менеджерам даём редактировать заказ до тех пор, пока он в работе или подтверждение доставки / заказа не пройдено
	if ($CurrentStatusOrder>3 && $UserRole>2 && $UserRole<6){
		$this->widget('CTabView', array(
		// 'htmlOptions'=>array('class'=>'no-print'),
		//'activeTab'=>'tab' . $activeTab,
		'tabs'=>array(
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_main',
				'data'=>array('model'=>$model),
				//'itemOptions'=>array('class'=>'inbox', 'title'=>'click here to read the mail'),
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), //'Доступ', 
				'view'=>'_ordercontent_noteditable', 
				'data'=>array('model'=>$model, 'eventId'=>$model->id, 'loadDataSetting' => $loadDataSetting),
				'active'=>true,
			),
			
		)));
	//Клиентам даём редактировать заказ до тех пор пока они не отправили его на подтверждение
	}elseif ($CurrentStatusOrder<=2 && $UserRole>=6){
		$this->widget('CTabView', array(
		// 'htmlOptions'=>array('class'=>'no-print'),
		//'activeTab'=>'tab' . $activeTab,
		'tabs'=>array(
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_main',
				'data'=>array('model'=>$model), 
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), //'Доступ', 
				'view'=>'_ordercontent_noteditable', 
				'data'=>array('model'=>$model, 'eventId'=>$model->id, 'loadDataSetting' => $loadDataSetting),
				'active'=>true,
			),
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'), //'Исполнение',
				'view'=>'_assortment', 
				'data'=>array('eventId'=>$model->id, 'contractorId'=>$model->contractorId,   'assortment'=>$assortment , 'pageSize'=>$pageSize),
			),			
		)));
	}else{
	
		$this->widget('CTabView', array(
		'tabs'=>array( 
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_main',
				'data'=>array('model'=>$model),
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), //'Доступ', 
				'view'=>(Yii::app()->user->checkAccess(User::ROLE_MANAGER) && ($model->StatusId < Events::STATUS_CONFIRMED_TO_RESERVE) ) ? '_ordercontent_manager' : '_ordercontent', 
				'data'=>array('model'=>$model, 'eventId'=>$model->id, 'loadDataSetting' => $loadDataSetting),
				'active'=>true,
			),
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'), //'Исполнение',
				'view'=>'_assortment', 
				'data'=>array('eventId'=>$model->id, 'contractorId'=>$model->contractorId,   'assortment'=>$assortment , 'pageSize'=>$pageSize),
			),
		)));		
			
	}
 ?>