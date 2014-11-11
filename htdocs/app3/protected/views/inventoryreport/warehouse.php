<h1>Report on Warehouse</h1>
<div class="search-form" style="display:block"> 
<?php $this->renderPartial('_search',array(
	'warehouse'=>$warehouse, 'event'=>$event, 
)); ?>
</div><!-- search-form -->
<?php   
$warehouseUrl = $this->createUrl('warehouse/update'); 
$eventUrl = $this->createUrl('events/update'); 
$assortmentUrl = $this->createUrl('assortment/update'); 
if($dataProviderGroup) {
	echo '<h3>', Yii::t('general','Grouped by warehouses'), '</h3>';
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'grouped-by-warehouses-grid',
		'dataProvider'=>$dataProviderGroup, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
		'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
		'selectableRows'=>1,   
		'selectionChanged'=>'function(id){   
			window.open(
			  "' . $warehouseUrl .'&id="+$.fn.yiiGridView.getSelection(id),
			  "_blank"
			);
		}',
	));
}
if($dataProvider) {
	echo '<br><h3>', Yii::t('general', 'By each warehouse'), '</h3>';
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'By-each-warehouse-grid',
		'dataProvider'=>$dataProvider, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
		'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
		'selectableRows'=>1,   
		'selectionChanged'=>'function(id){   
			 window.open(
			  "' . $eventUrl .'&id="+$.fn.yiiGridView.getSelection(id),
			  "_blank"
			);
		}',
	));
}
if($dataProviderAssortment) {
	echo '<br><h3>', Yii::t('general', 'By each assortment item'), '</h3>';
	echo 'Assotrment item = ', Assortment::model()->findByPK($_GET['id'])->title; 
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'by-each-assortment-item-grid',
		'dataProvider'=>$dataProviderAssortment, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
		'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
		'selectableRows'=>1,   
		'selectionChanged'=>'function(id){   
			 window.open(
			  "' . $assortmentUrl .'&id="+$.fn.yiiGridView.getSelection(id),
			  "_blank"
			);
		 }',
	));
}
?>

