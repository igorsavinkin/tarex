<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */

$this->breadcrumbs=array(
	Yii::t('general','Discount Groups')=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('general','List DiscountGroup'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create DiscountGroup'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update DiscountGroup'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete DiscountGroup'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage DiscountGroup'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View DiscountGroup') . ' <em><u>'. $model->name . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discount-group-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'name',
		'articles',
		'value',
		'isActive',
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
		'articles',
		'value',
		'isActive',
	),
)); ?>
