<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	Yii::t('general','Accounts')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('general','List Accounts'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Accounts'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update Accounts'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete Accounts'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage Accounts'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View Accounts') . ' <em><u>'. $model->name . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'accounts-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'name',
		'CustomerName',
		'AccountNumber',
		'AccountCurrency',
		'AccountLimit',
		'ParentCustomer',
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
		'CustomerName',
		'AccountNumber',
		'AccountCurrency',
		'AccountLimit',
		'ParentCustomer',
	),
)); ?>
