<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */

$this->breadcrumbs=array(
	Yii::t('general','Special Offers')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('general','List SpecialOffer'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create SpecialOffer'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update SpecialOffer'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete SpecialOffer'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage SpecialOffer'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','View SpecialOffer') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'special-offer-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		// 'id',
		'assortmentId' =>array( 
			'name'=>'assortmentId',
			'value'=>'Assortment::model()->findByPk($data->assortmentId)->name',
			'filter' => CHtml::listData(Assortment::model()->findall(), 'id', 'name'),		
		),
		'price',
		'description',
		'photo',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'assortmentId',
		'price',
		'description',
		'photo',
	),
)); ?>
