<?php
/* @var $this EventsController */
/* @var $model Events */

	$UserRole=Yii::app()->user->role;
	//$UserRole=6;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;

 $Year=substr($model->Begin,0,4);
  $Mn=substr($model->Begin,5,2);
  $Day=substr($model->Begin,8,2);

$this->breadcrumbs=array(
	Yii::t('general','Events')=>	array('admin'),
	//$model->Subject=>array('update','id'=>$model->id),
	//Yii::t('general','Update'),
);
 
 
 
 
// $app->session['Reference']=''; 
 
?> 
<h3><?php 

 

  echo '<em>' , Yii::t('general',$model->EventType->name), '</em> №'.$model->id.' '.Yii::t('general','from date').' '.$Day.'-'.$Mn.'-'.$Year; 
  
  if($model->eventNumber) echo ' ', Yii::t('general','#'), $model->eventNumber;  
  //if($model->Subject) echo ' ', Yii::t('general', "Subject"), ' "<em>' , $model->Subject , '</em>".'; 
  
  
  
  ?></h3>

  <?php

	//echo $CurrentStatusOrder.$UserRole;

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
				//'view'=>'_ordercontent2',
				'data'=>array('model'=>$model, 'eventId'=>$model->id),
				'active'=>true,
			),
			
		)));
	//Клиентам даём редактировать заказ до тех пор пока они не отправили его на подтверждение
	}elseif ($CurrentStatusOrder>2 && $UserRole>=6){
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
				//'view'=>'_ordercontent2',
				'data'=>array('model'=>$model, 'eventId'=>$model->id),
				'active'=>true,
			),
			
		)));
	}else{
		
		//echo '1';
		
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
				'view'=>'_ordercontent',
				//'view'=>'_ordercontent2',
				'data'=>array('model'=>$model, 'eventId'=>$model->id),
				'active'=>true,
			),
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'), //'Исполнение',
				'view'=>'_assortment',
			   // 'view'=>'../assortment/admin',
				'data'=>array('model'=>$model, 'eventId'=>$model->id,   'assortment'=>$assortment),
			),
		)));		
		
	
	}

	
	

	
	//$this->renderPartial('_form', array('model'=>$model)); ?>