<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage News'); ?></h1><br>
<?php 
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 	
echo CHtml::link(Yii::t('general','Create'), array('create'), array( 'class' => 'btn-win'));?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$url = $this->createUrl('update');
  $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model, 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
    'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	'selectableRows'=>1,  
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
		//'id',
		'id'  ,
		'title',
		'link',
		'imageUrl',	
		'content',			
		'RSSchannel',
		'isActive' => array(
			'name' => 'isActive', 	
			'value' => '($data->isActive == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")), //'нет', 'да'				   
			),	 		
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}'
		),
	),
)); ?>