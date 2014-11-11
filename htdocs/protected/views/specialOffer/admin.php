<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#special-offer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Special Offers'); ?></h1><br>
<?php 
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 	
echo CHtml::link(Yii::t('general','Create')  , array('create'),array( 'class' => 'btn-win'));?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$url = $this->createUrl('update');
  $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'special-offer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model, 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
    'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	'selectableRows'=>1,  
	'selectionChanged'=>'function(id){  
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id); 
		}',
	//'htmlOptions'=>array('class'=>'grid-view grid-size-600'), 
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		//'id',
		'assortmentId'=>array(
			'header'=>Yii::t('general','Assortment id'), 
			'name'=>'assortmentId',
			),
		'price',
		'description',
		'make',
		'photo',	
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}'
		),
	),
)); ?>