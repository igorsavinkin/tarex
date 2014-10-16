<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */

$this->breadcrumbs=array(
	Yii::t('general','Assortments')=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>Yii::t('general','List Assortment'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Assortment'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update Assortment'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete Assortment'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage Assortment'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View Assortment') . ' <em><u>'. $model->title . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assortment-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'parent_id' =>array( 
			'name'=>'parent_id',
			'value'=>'Parent_::model()->findByPk($data->parent_id)->name',
			'filter' => CHtml::listData(Parent_::model()->findall(), 'id', 'name'),		
		),
		'subgroup',
		'title',
		'model',
		'make',
		'measure_unit',
		'price',
		'discount',
		/*
		'warehouseId' =>array( 
			'name'=>'warehouseId',
			'value'=>'Warehouse::model()->findByPk($data->warehouseId)->name',
			'filter' => CHtml::listData(Warehouse::model()->findall(), 'id', 'name'),		
		),
		'imageUrl',
		'fileUrl',
		'isService' =>array(
			'name' => 'isService',
			'value' => '($data->isService != 0) ?  Yii::t("general","yes") :  Yii::t("general","no") ',
			//'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
			),
		'depth' =>array(
			'name' => 'depth',
			'value' => '($data->depth != 0) ?  Yii::t("general","yes") :  Yii::t("general","no") ',
			//'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
			),
		'article',
		'priceS',
		'oem',
		'organizationId' =>array( 
			'name'=>'organizationId',
			'value'=>'Organization::model()->findByPk($data->organizationId)->name',
			'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'name'),		
		),
		'manufacturer',
		'agroup',
		'availability',
		'country',
		'MinPart',
		'YearBegin',
		'YearEnd',
		'Currency',
		'Analogi',
		'Barcode',
		'Misc',
		'PartN',
		'COF',
		'Category',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'subgroup',
		'title',
		'model',
		'make',
		'measure_unit',
		'price',
		'discount',
		'warehouseId',
		'imageUrl',
		'fileUrl',
		'isService',
		'depth',
		'article',
		'priceS',
		'oem',
		'organizationId',
		'manufacturer',
		'agroup',
		'availability',
		'country',
		'MinPart',
		'YearBegin',
		'YearEnd',
		'Currency',
		'Analogi',
		'Barcode',
		'Misc',
		'PartN',
		'COF',
		'Category',
	),
)); ?>
