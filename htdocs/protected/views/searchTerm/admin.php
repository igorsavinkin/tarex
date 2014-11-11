<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */  
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#search-term-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Customer Search Terms'); ?></h1>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
// добавим тег открытия формы
echo CHtml::form();
echo CHtml::submitButton('Request to supplier', array('name'=>'bulkAction', 'style'=>'float:right;', 'class'=>'red'));
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'search-term-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'columns'=>array(
 		array(     
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		'name',     
		'marketPrice',
		'frequency',   
	 	'relatedClientId'=>array(
			'header'=>Yii::t('general','Client'),
			'value'=>'(User::model()->findByPk($data->relatedClientId)->username) ? User::model()->findByPk($data->relatedClientId)->username : ""  ',        
		),
		'firstOccurance', 		
		array(
			'class' => 'CCheckBoxColumn',
			'id' => 'UserId',	
		), 
	),
)); 
// добавим тег закрытия формы
echo CHtml::endForm(); ?>