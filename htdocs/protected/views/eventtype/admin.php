<?php
$this->pageTitle = Yii::t('general','Event Type');  
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
<h1><?php echo Yii::t('general','Event Type'); ?></h1><br>
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
// выбор действия которое надо применить при клике на запись в сетке
$action = 'update';   
$url = $this->createUrl($action); 
 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows'=>1,  
	'selectionChanged'=>'function(id){  
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id); 
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
		'subType'=>array(
			'header'=>Yii::t('general','Sub type'), 
			'value'=>'Yii::t("general", $data->subType)', // здесь мы осуществляем перевод для подтипов
		),
		'Reference', 
		//'IsBasisFor', 
		array(
			'name'=>'IsBasisFor', 
			'value'=> '$data->bases', // здесь мы осуществляем перевод для подтипов
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',	
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),			
		), 		
	),         
)); ?>