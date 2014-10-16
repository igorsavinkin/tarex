<?php

	$UserRole=Yii::app()->user->role;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;

  $Year=substr($model->Begin,0,4);
  $Mn=substr($model->Begin,5,2);
  $Day=substr($model->Begin,8,2);


?> 
<h3><?php 

 

  echo '<em>' , Yii::t('general',$model->EventType->name), '</em> №'.$model->id.' '.Yii::t('general','from date').' '.$Day.'-'.$Mn.'-'.$Year; 
  
  //if($model->eventNumber) echo ' ', Yii::t('general','#'), $model->eventNumber;  
 
  
  ?></h3>

  <?php

//echo 'model->id', $model->id;
//echo 'assortment'; print_r($assortment);
	//Менеджерам даём редактировать  до тех пор, пока он новый / в работе 
	if ($model->StatusId<=2 && $UserRole>2 && $UserRole<6){
		$this->widget('CTabView', array(
		'tabs'=>array(
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), 
				'view'=>'_main',
				'data'=>array('model'=>$model),
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), 
				'view'=>'_ordercontent',
				'data'=>array('model'=>$model, 'eventId'=>$model->id),
				//'active'=>true,
			),
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'), 
				'view'=>'_assortment',        
				'active'=>true,
				'data'=>array( 'eventId'=>$model->id , 'assortment'=>$assortment),
			),
			
		)));
	
	//Админам даём редактировать  всегда
	}elseif ($UserRole<=2){
				$this->widget('CTabView', array(
		'tabs'=>array(
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), 
				'view'=>'_main',
				'data'=>array('model'=>$model),
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), 
				'view'=>'_ordercontent',
				'data'=>array('model'=>$model, 'eventId'=>$model->id),
				'active'=>true,
			),
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'), 
				'view'=>'_assortment',
				'data'=>array( 'eventId'=>$model->id,   'assortment'=>$assortment),
			),
			
		)));
	//В других случаях на чтение
	}else{
	
		$this->widget('CTabView', array(
		'tabs'=>array(
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), 
				'view'=>'_main',
				'data'=>array('model'=>$model),
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), 
				'view'=>'_ordercontent_noteditable',
				'data'=>array('model'=>$model, 'eventId'=>$model->id),
				'active'=>true,
			),

			
		)));		
			
	}

	
	

	
	 ?>