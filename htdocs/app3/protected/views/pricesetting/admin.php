<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */

$this->breadcrumbs=array(
	Yii::t('general','Pricesetting')=>array('admin'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Pricesetting'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Pricesetting'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pricesetting-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Pricesetting'); ?></h1>
 
<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button'));
	echo CHtml::link(Yii::t('general','Create Pricesetting'),array('create'),array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 

 // добавим тег открытия формы
 echo CHtml::form(); 
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pricesetting-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'columns'=>array(
 		array(
                'header' => '№',
				'htmlOptions'=>array('width'=>'10'),
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		'id'=>array( 
				'name'=>'id',
				'htmlOptions'=>array('width'=>'20'),
			),
		'dateTime'=>array( 
				'name'=>'dateTime',
				'htmlOptions'=>array('width'=>'100'),
			),
		'RURrate',
		'EURrate',
		'LBPrate',
		//'USDrate',
		'organizationId' =>array( 
			'name'=>'organizationId',
			'value'=>'Organization::model()->findByPk($data->organizationId)->name',
			'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'name'),		
		),		
		'personResponsible'=>array( 
			'name'=>'personResponsible',
			'value'=>'User::model()->findByPk($data->personResponsible)->username',
			'filter' => CHtml::listData(User::model()->findall(), 'id', 'username'),		
		), 
		array(
			'class'=>'CButtonColumn',
			//'template'=>'{view}',
	    	'template'=>(Yii::app()->user->checkAccess(1) ) ? '{delete}{view}' : '{view}',
			'buttons' => array(              
		   	    'delete' => array( 
					 'label' => Yii::t('general','Delete'), 
					 'options' => array('class'=>'custom-btn delete'),
					 'imageUrl'=>'',
					//  'url'=>'Yii::app()->controller->createUrl("delete", array("id"=>$data[id]))',
					 'visible'=>'Yii::app()->user->checkAccess(1)',
					), 
				'view' => array( 
					 'label' => Yii::t('general','View'), 
					 'options' => array('class'=>'custom-btn btn-view'),
					 'imageUrl'=>'', 
					), 
			),
		),
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>
