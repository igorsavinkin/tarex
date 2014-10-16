<?php
$this->pageTitle = Yii::t('general','Event Status');  
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#usergroup-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
"); 
?>
<h1><?php echo Yii::t('general','Event Status'); ?></h1><br>
<?php  
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 
echo CHtml::link(Yii::t('general','Create')  , array('update', 'id'=>'new'),array( 'class' => 'btn-win'));
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php   
 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
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
		'name'=>array(
			'header'=>Yii::t('general','Name'), 
			'value'=>'Yii::t("general", $data->name)', // здесь мы осуществляем перевод для типов 
		), 
		'Order1',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',		
		), 		
	),         
)); ?>