<?php
/* @var $this PricingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Pricings'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create Pricing'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage Pricing'), 'url'=>array('admin')),
);
?>

<h1>Pricings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
