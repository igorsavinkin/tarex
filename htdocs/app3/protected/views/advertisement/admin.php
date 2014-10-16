<?php
/* @var $this AdvertisementController */
/* @var $model Advertisement */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#advertisement-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--h1><?php //echo Yii::t('general','Manage Advertisement'), ' & ',  Yii::t('general','Special pages'), ' & ',  Yii::t('general','RSS Channel'); ?></h1-->
<h1><?php echo Yii::t('general','Advertisement, Special pages, Slider & RSS'); ?></h1>

<?php  echo CHtml::link(Yii::t('general','Create'), array('create') ,array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php //$this->renderPartial('_search',array(	'model'=>$model,)); ?>
</div><!-- search-form --> 
<?php  
 $url = $this->createUrl('update'); 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'advertisement-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model, 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 1,    
	'selectionChanged'=>'function(id){ 		
		 location.href = "'. $url .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',  
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),    
		//'id',
		'blockId',
		'content',		
		'isActive' => array(
			'name' => 'isActive', 	
			'value' => '($data->isActive == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")), //'нет', 'да'				   
			),	 
	),
)); 
?> 