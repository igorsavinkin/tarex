<?php
$this->pageTitle = Yii::t('general','Category');
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
<h1><?php echo Yii::t('general','Parts categories'); ?></h1><br>
<?php  
echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); 
if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)){
	echo CHtml::link(Yii::t('general','Create')  , array('create'), array( 'class' => 'btn-win'));
	echo CHtml::link('Скрипт по проставлению id категории в "groupCategory" для различных подгрупп (поле "subgroup").' , array('category/setCategory'), array('target'=>'_blank'));  
	echo '<br><br>',CHtml::link(Yii::t('general','Add assortment to certain category')  , array('assortment/adminBulk'), array( 'class' => 'btn-win'));
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
 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,	
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css', 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	//'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'selectableRows'=>1,  
	'selectionChanged'=>'function(id){  
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id); 
		}',
	'htmlOptions'=>array('class'=>'grid-view grid-size-400'), 
	'columns'=>array( 
		'id'=>array( 
			'header'=>Yii::t('general','id'), 
			'name'=>'id',
		),  
		'name'=>array(  
			'name'=>Yii::t('general', 'Name'),   
			'value'=>array($this, 'translated'), 
		),    
		'image',
		'isActive' => array(
			'name' => 'isActive',
			'value' => '($data->isActive == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")),
			//'header' => 'Активен',			
			), 
		array(         
			'class'=>'CButtonColumn', 
			'template'=>'{delete}',  
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),
		), 		
	),         
)); ?>
<p class='note error' >Категория будет показана в "Меню Категорий" если она активна и есть номенклатура с этой категорией!</p>