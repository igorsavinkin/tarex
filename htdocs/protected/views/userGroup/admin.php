<?php
$this->pageTitle = Yii::t('general','User Groups');   
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#events-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
"); 
?>
<h1><?php echo Yii::t('general','User Groups'); ?></h1><br><br>
<?php  
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 
echo CHtml::link(Yii::t('general','Create'), array('update',  'id'=>'new'),array( 'class' => 'btn-win'));  
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php 
// выбор действия которое надо применить при клике на запись в сетке
$action = 'update';  
if (Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
{ $action = 'update'; }
$url = $this->createUrl($action);
 // конец выбора действия которое надо применить при клике на запись в сетке
 
// добавим тег открытия формы
echo CHtml::form(); 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-group-grid',
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
		), /* */   
		'name'=>array( 
			//'header'=>Yii::t('general','id'), 
			'name'=>'name',
			'htmlOptions'=>array('width=60'),
		) , 
		'Organization'=>array(         
			//'htmloptions'=>array('width=40'), 
			'header'=>Yii::t('general','Organization'), 
			'value'=> 'Organization::model()->findByPk($data->organizationId)->name',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),
		), 
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_MANAGER),
		),
	),         
));  
// добавим тег закрытия формы        
echo CHtml::endForm();
?>