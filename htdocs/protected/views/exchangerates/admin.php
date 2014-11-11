<?php
/* @var $this EventsController */
/* @var $model Events */ 

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#exchange-rates-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
"); 
$this->pageTitle = Yii::t('general','Exchange Rates'); 
?>
<h1><?php echo Yii::t('general','Exchange Rates'); ?></h1><br>

<?php  
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 
if(Yii::app()->user->role<=1){
	echo CHtml::link(Yii::t('general','Create')  , array('update',   'id'=>'new'),array( 'class' => 'btn-win'));
} 
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php  
// выбор действия которое надо применить при клике на запись в сетке
$action = 'update';
$url = $this->createUrl($action);
  
// конец выбора действия которое надо применить при клике на запись в сетке
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'exchange-rates-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,	
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	//'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){  
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id); 
	}',
	'columns'=>array( 
		'id'=>array( 
			'header'=>Yii::t('general','#'), 
			'name'=>'id',
		), 
		'Begin'=>array( 
			'header'=>Yii::t('general','Date'),
			'name'=>'Begin',
		),  		
		'Currency'=>array( 
			'header'=>Yii::t('general','Currency'),
			'name'=>'Currency',
		), 
		'Value'=>array( 
			'header'=>Yii::t('general','Cost in RUB'),
			'name'=> 'totalSum',
		),
		'Organization'=>array(           
			'header'=>Yii::t('general','Organization'), 
			'value'=> 'Organization::model()->findByPk($data->organizationId)->name',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),
		), 
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}', 
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_DIRECTOR),
		),		
	),
));  
?>
