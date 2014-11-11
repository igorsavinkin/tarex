<?php
/* @var $this ScopeOfActivityController */
/* @var $model ScopeOfActivity */
 
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#scope-of-activity-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Scope Of Activity'); ?></h1>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 
echo CHtml::link(Yii::t('general','Create'),array('create'),array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php  
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'scope-of-activity-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 1,
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $this->createUrl('update') .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',
	'htmlOptions'=>array('class'=>'grid-view grid-size-500'), 
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		'id',
		'name', 
		array('name'=>'TrName', 'header'=>Yii::t('general', 'Name') ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
		),
	),
));  