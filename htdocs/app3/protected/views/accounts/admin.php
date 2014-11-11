<?php
/* @var $this AccountsController */
/* @var $model Accounts */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#accounts-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h2><?php echo Yii::t('general','Manage Accounts'); ?></h2>


<?php //echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

		<br>
		<br>

<?php 

 echo CHtml::link(Yii::t('general','Create'),array('create', 'new'=>1), array( 'class' => 'btn-win'));
 // добавим тег открытия формы
 echo CHtml::form();
 $action = 'update';  
$url = $this->createUrl($action); 
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'accounts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',
	'columns'=>array(

		'id',
		'name',
		'CustomerName',
		'AccountNumber',
		//'AccountCurrency',
		'AccountCurrency' =>array( 
			'name'=>'AccountCurrency',
			'value'=>'Yii::t("general", Currency::model()->findByPk($data->AccountCurrency)->name)',
			'filter' => CHtml::listData(Currency::model()->findall(), 'id', 'name'),		
		), 
		
		'AccountLimit',
		//'ParentCustomer',
		'ParentCustomer' =>array( 
			'name'=>'ParentCustomer',
			'value'=>'Yii::t("general", User::model()->findByPk($data->ParentCustomer)->username)',
			'filter' => CHtml::listData(User::model()->findall(), 'id', 'username'),		
		), 
		
	
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
		),
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>
