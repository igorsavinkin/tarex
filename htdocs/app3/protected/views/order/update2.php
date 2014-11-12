<?php
/* @var $this EventsController */
/* @var $model Events */
Yii::app()->clientScript->registerScript('-index', "
$('#car-index').click(function(){
	$('#car-index-form').toggle(); 
	jump('car-index-form');
	return false;
});
");
	$UserRole=Yii::app()->user->role;
	$CurrentStatusOrder=EventStatus::model()->FindByPk($model->StatusId)->Order1;
 
?> 
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
	}else {
	?>  
		<table width='100%'><tr valign='top'>  
			<td width='50%' valign='top'>  
				<h2><?php echo Yii::t('general', 'Main'); ?></h2>
				<div id="main-form" style="display:block"> 
					<?php $this->renderPartial('_main2', array('model'=>$model)); ?>
				</div><!-- main-form -->
				<!--  пользователи -->
				 <?php echo CHtml::Link(Yii::t('general', 'Customers') , '' , array('id'=>'users-form-btn', 'class'=>'btn-win',  'style'=>'float:left;')); ?>
				<div id="users-form" style="display:none"> 
					<?php $this->renderPartial('_users', array('user'=>$user, 'dataProviderUser'=>$dataProviderUser)); ?> 
				</div><!-- users-form -->
			</td>
			<td  width='50%'>
				<!-- order content  --> 
				<div id="car-index-form" style="display:block"> 
					<?php $this->renderPartial((Yii::app()->user->checkAccess(User::ROLE_MANAGER) && ($model->StatusId < Events::STATUS_CONFIRMED_TO_RESERVE) ) ? '_ordercontent_manager' : '_ordercontent', array('model'=>$model, 'eventId'=>$model->id)); ?>
				</div><!-- ordercontent-form --> 
			</td>
		</tr></table>
	 <div style='clear:both;'></div>
	 <div id="assortment-form" style="display:block"> 
	<?php $this->renderPartial('_assortment', array( 'eventId'=>$model->id,   'assortment'=>$assortment , 'pageSize'=>$pageSize )); ?>
	</div><!-- assortment-form --> 
	<?php 
/*		$this->widget('CTabView', array(
		'tabs'=>array(
			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_main',
				'data'=>array('model'=>$model),
				//'itemOptions'=>array('class'=>'inbox', 'title'=>'click here to read the mail'),
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Products / Services'), //'Доступ', 
				'view'=>(Yii::app()->user->checkAccess(User::ROLE_MANAGER) && ($model->StatusId < Events::STATUS_CONFIRMED_TO_RESERVE) ) ? '_ordercontent_manager' : '_ordercontent',
				//'view'=>'_ordercontent2',
				'data'=>array('model'=>$model, 'eventId'=>$model->id),
				'active'=>true,
			),
			'tab3'=>array(
				'title'=>Yii::t('general', 'Assortment selection'), //'Исполнение',
				'view'=>'_assortment',
			   // 'view'=>'../assortment/admin',
				'data'=>array(  'eventId'=>$model->id,   'assortment'=>$assortment , 'pageSize'=>$pageSize),
			),
		)));	*/	
			
	}
 ?>