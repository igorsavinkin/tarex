<?php
/* @var $this ContractorController */
/* @var $model Contractor */

$this->breadcrumbs=array(
	Yii::t('general','Contractors')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('general','List Contractor'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Contractor'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update Contractor'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete Contractor'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage Contractor'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View Contractor') . ' <em><u>'. $model->name . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contractor-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'name',
		'address',
		'phone',
		'email',
		'organizationId' =>array( 
			'name'=>'organizationId',
			'value'=>'Organization::model()->findByPk($data->organizationId)->name',
			'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'name'),		
		),
		'userId' =>array( 
			'name'=>'userId',
			'value'=>'User::model()->findByPk($data->userId)->name',
			'filter' => CHtml::listData(User::model()->findall(), 'id', 'name'),		
		),
		'note',
		'inn',
		/*
		'kpp',
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
		'name',
		'address',
		'phone',
		'email',
		'organizationId',
		'userId',
		'note',
		'inn',
		'kpp',
	),
)); ?>
