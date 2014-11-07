<?php
/* @var $this MaxDiscountController */
/* @var $model MaxDiscount */

$this->breadcrumbs=array(
	Yii::t('general','Max Discounts')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List MaxDiscount'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create MaxDiscount'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update MaxDiscount'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete MaxDiscount'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage MaxDiscount'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View MaxDiscount') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'max-discount-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'prefix',
		'value',
		'manufacturer',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'prefix',
		'value',
		'manufacturer',
	),
)); ?>
