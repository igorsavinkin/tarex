<?php
/* @var $this EventsController */
/* @var $model Events */
 
$this->pageTitle =Yii::t('general','Sales');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#events-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
"); 
?>
<h1><?php echo Yii::t('general','Sales'); ?></h1><br> 
<?php 
if(Yii::app()->user->role<6){
	echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn-win')); 
}
echo CHtml::link(Yii::t('general','Create') . ' ' . Yii::t('general', 'New' ) , array('create', 'new'=>1), array( 'class' => 'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php 

// выбор действия которое надо применить при клике на запись в сетке
$action = 'update';   
$url = $this->createUrl($action); 
// конец выбора действия которое надо применить при клике на запись в сетке

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid', 
	'dataProvider'=> $model->search(), 
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css', 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',
	'columns'=>array(
 		'id'=>array( 
			'header'=>Yii::t('general','#'), 
			'name'=>'id',
		), 
		'Date'=>array(
			'name'=>'Begin',		
			'header' => Yii::t('general', 'Date'), 		
		),  
		'author.username',
		'contractorId' =>
		array( 
			'name'=>'contractorId',
			'value'=>'($data->contractorId) ? User::model()->findByPk($data->contractorId)->username : "" ',
		), 
		/*'EventTypeId' =>array( 
			'name'=>'EventTypeId',
			'value'=>'Yii::t("general", EventType::model()->findByPk($data->EventTypeId)->name)',
			'filter' => CHtml::listData(EventType::model()->findall(), 'id', 'name'),		
		), */
		'StatusId' =>array( 
			'name'=>'StatusId',
			'value'=>'Yii::t("general", EventStatus::model()->findByPk($data->StatusId)->name)',
			'filter' => CHtml::listData(EventStatus::model()->findall(), 'id', 'name'),		
		), 
		'Organization'=>array(          
			'header'=>Yii::t('general','Organization'), 
			'value'=> '($data->organizationId) ? Organization::model()->findByPk($data->organizationId)->name : "" ',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),
		), 
		'Warehouse' => array(          
			'header'=>Yii::t('general','Warehouse'), 
			'value'=> '($data->Subconto1) ? Warehouse::model()->findByPk($data->Subconto1)->name : "" ', 
		), 
		'totalSum', 
		'Notes',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN), 
		),
	),
)); 
?>
