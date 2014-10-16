<?php
$this->pageTitle = Yii::t('general','Main Menu');  
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#mainmenu-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
"); ?> 
<h1><?php echo Yii::t('general','Main menu items'); ?></h1><br>
<?php  
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 
echo CHtml::link(Yii::t('general','Create')  , array('update', 'id'=>'new'),array( 'class' => 'btn-win'));
?>
<div class="search-form" style="display:none">
<?php  $this->renderPartial('_search',array(	'model'=>$model)); ?>
</div><!-- search-form -->
<?php /**/  
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'mainmenu-grid',
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
	 	'Subsystem'=>array(
			'header'=>Yii::t('general','Subsystem'), 
			'value'=>'Yii::t("general", $data->Subsystem)', // здесь мы осуществляем перевод  
		),  
		'Img',
		'Reference'=>array(
			'header'=>Yii::t('general','Name'), // . '/Reference', 
			'value'=>'Yii::t("general", $data->Reference)', // здесь мы осуществляем перевод 
		),
		'ReferenceImg',
		'Link',
		'RoleId',
		/*
		'roles'=>array(
			'header'=>Yii::t('general','Roles'), 
			'value'=>'Yii::t("general", $data->getRoles())',   
		), 
		*/
	 	'DisplayOrder', 
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',	 		
		), 	 
	),         
));  ?>