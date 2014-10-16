<?php
/* @var $this OfficeVehicleController */
/* @var $model OfficeVehicle */
 
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#office-vehicle-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Office Vehicles'); ?></h1>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); echo CHtml::link(Yii::t('general','Create'),array('create'), array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php  
$url = $this->createUrl('update'); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'office-vehicle-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 1, 
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		// 'id',
		'first_registration_date',
		'make',
		'model',
		'driver',
		'vin',
		'milage',
		'last_maintenance_date',
		'milage_since_last_maintenance',		
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN), 
		),
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>
