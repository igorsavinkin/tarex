<?php
/* @var $this UserGroupDiscountController */
/* @var $model UserGroupDiscount */

$this->breadcrumbs=array(
	Yii::t('general','User Group Discounts')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List UserGroupDiscount'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create UserGroupDiscount'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update UserGroupDiscount'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete UserGroupDiscount'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage UserGroupDiscount'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View UserGroupDiscount') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-group-discount-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'userId' =>array( 
			'name'=>'userId',
			'value'=>'User::model()->findByPk($data->userId)->name',
			'filter' => CHtml::listData(User::model()->findall(), 'id', 'name'),		
		),
		'discountGroupId' =>array( 
			'name'=>'discountGroupId',
			'value'=>'Discountgroup::model()->findByPk($data->discountGroupId)->name',
			'filter' => CHtml::listData(Discountgroup::model()->findall(), 'id', 'name'),		
		),
		'value',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'userId',
		'discountGroupId',
		'value',
	),
)); ?>
