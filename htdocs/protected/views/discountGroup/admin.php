<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#discount-group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage'), ' ',  Yii::t('general','Discount Groups'); ?></h1>
<?php 
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button'));   
echo CHtml::link(Yii::t('general','Create'),array('create'),array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
 // добавим тег открытия формы
 echo CHtml::form();
 //echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discount-group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	//'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'selectableRows'=>1,
		'selectionChanged'=>'function(id){  		
			location.href = "' . $this->createUrl('update') .'/id/"+$.fn.yiiGridView.getSelection(id);	
		}',
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		'id',
		'name',
		'prefix',
		array(
			'header'=>Yii::t('general','Articles'),
			'value'=>'substr($data->articles, 0 ,70) . "..." ',
		),
		'value',
		'isActive' => array(
			'name' => 'isActive',
			'value' => '($data->isActive == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")),
			//'header' => 'Активен',			
			), 
		
		array(
			'class' => 'CCheckBoxColumn',
			'id' => 'UserId',	
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>
