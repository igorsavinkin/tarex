<?php
/* @var $this PricingController */
/* @var $model Pricing */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pricing-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Pricing'); ?></h1>

<?php //echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
));  
?>
</div><!-- search-form -->
<br>
<?php 
echo CHtml::link(Yii::t('general','Create'), array('create'), array( 'class' => 'btn-win')); 
 $url = $this->createUrl('update');
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pricing-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 1, // this makes user to select more than 1 checkbox in the grid
	'selectionChanged'=>'function(id){ 
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);
	}',
	'htmlOptions'=>array('class'=>'grid-view grid-size-500'), 
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		// 'id',
		'Date',
		'Comment',
		'Value',
		'isActive' => array(
			'name' => 'isActive',
			'value' => '($data->isActive == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")),
			//'header' => 'Активен',			
			), 
	  array( 
		  'class'=>'CButtonColumn',
		  'template'=>'{delete}',
		/*  'buttons'=>array( 
			   'delete'=>array(
					'visible'=>Yii::app()->user->checkAccess(User::ROLE_MANAGER), 
			   ),
		  ),*/
	  ),
	),
)); 
// добавим тег закрытия формы
	//echo CHtml::endForm();
?>
