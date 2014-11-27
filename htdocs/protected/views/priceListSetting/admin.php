<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#price-list-setting-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Price List Settings'); ?></h1>
<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); ?>
<?php echo CHtml::link(Yii::t('general','Create'),'create',array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$msg = Yii::t('general', 'Wait several seconds till the server composes and sends you personalized price list');
echo CHtml::Link(Yii::t('general','Download price list as Excel sheet') , array('user/pricelist') , array( 'class'=>'btn-win', 'style'=>'float:right;', 'onclick'=>"js:setTimeout(function(){ alert('{$msg}')},600);")); 
echo CHtml::Link(Yii::t('general','Download price list as Excel sheet'). '(csv)' , array('user/pricelistCSV') , array( 'class'=>'btn-win', 'style'=>'float:right;', 'onclick'=>"js:setTimeout(function(){ alert('{$msg}')},600);"));  

 // добавим тег открытия формы
 echo CHtml::form(); 
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'price-list-setting-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model, 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 1, 
	'selectionChanged'=>'function(id){ 		
		location.href = "' .  $this->createUrl('update') .'/id/"+$.fn.yiiGridView.getSelection(id); }', 
	
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		// 'id',
		'userId' =>array( 
			'name'=>'userId',
			'value'=>'User::model()->findByPk($data->userId)->username',
			'filter' => CHtml::listData(User::model()->findAll('username<>"" '), 'id', 'username'),		
		),
		'format' =>array( 
			'name'=>'format', 
			'header'=>Yii::t('general', 'File Format'),
			'filter' => $this->formats,		
		), 
		'daysOfWeek'=>array( 
			'name'=>'daysOfWeek',
			'value'=>array($this, 'parsedDays'), 		
		),
		'time',	
		'lastSentDate', 
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=>'Yii::app()->user->checkAccess(User::ROLE_ADMIN)',
		),
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>