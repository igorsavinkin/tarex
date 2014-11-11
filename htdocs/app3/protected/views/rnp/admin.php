<?php
/* @var $this EventsController */
/* @var $model Events */
 
$this->pageTitle =Yii::t('general','RNP');  
?>
<h1><?php echo Yii::t('general','RNP'); ?></h1><br> 
<?php 
if (Yii::app()->user->role <= User::ROLE_USER) {
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
	echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn-win'));  
}
if(Yii::app()->user->role<=User::ROLE_USER) {
	echo CHtml::link(Yii::t('general','Create') . ' ' . Yii::t('general', 'New' ) , array('create', 'id'=>'new'), array( 'class' => 'btn-win')); 
} 
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php  
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid', 
	'dataProvider'=> $model->search(), 
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css', 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $this->createUrl('update') .'/id/"+$.fn.yiiGridView.getSelection(id);	
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
		'contractorId' => array( 
			'name'=>'contractorId',
			'value'=>'User::model()->findByPk($data->contractorId)->username',
		),
	/*	'parent_id' => array(  
			'header'=>Yii::t('general', 'Base'),
			'type'=>'raw',
			'value'=>'Events::model()->findByPk($data->parent_id) ? Events::model()->findByPk($data->parent_id)->orderNotation() : "-" ',
		),
		'EventTypeId' =>array( 
			'name'=>'EventTypeId',
		'value'=>'Yii::t("general",Eventtype::model()->findByPk($data->EventTypeId)->name)', 		
		),  */
		'StatusId' =>array( 
			'name'=>'StatusId',
			'value'=>'Yii::t("general", EventStatus::model()->findByPk($data->StatusId)->name)',
			'filter' => CHtml::listData(EventStatus::model()->findall(), 'id', 'name'),		
		), 
	/*	'Organization'=>array(          
			'header'=>Yii::t('general','Organization'), 
			'value'=> 'Organization::model()->findByPk($data->organizationId)->name',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),
		), 
		'CashAccount' => array(          
			'header'=>Yii::t('general','Cash Account'),  
			'value'=> 'Cashaccount::model()->findByPk($data->Subconto1)->name', 
		), 
		'Currency' => array(          
			'header'=>Yii::t('general', 'Currency'),  
			'value'=> 'Currency::model()->findByPk($data->Subconto2)->name', 
		),
		'totalSum', */
		'Notes'=>array('header'=>Yii::t('general','New assortment items codes'), 'name'=>'Notes' ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN), 
		),
	),
)); 
?>
