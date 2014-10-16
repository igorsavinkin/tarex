<?php
/* @var $this SparePartController */
/* @var $model SparePart */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#spare-part-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Spare parts for company vehicle'); ?></h1>

<?php
 echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button'));  
 echo CHtml::link(Yii::t('general','Create new'),array('create'),array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
 // добавим тег открытия формы
 echo CHtml::form();
// echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'spare-part-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 1, 
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $this->createUrl('update') . '/id/"+$.fn.yiiGridView.getSelection(id);
	}',		
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		// 'id',
		'changeDate',
		'OEM',
		'article',
		'assortmentId',
		'analogs',		
		/*array(
			'class' => 'CCheckBoxColumn',
			'id' => 'UserId',	
		),*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
		),
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();?>