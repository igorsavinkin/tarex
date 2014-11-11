<?php
/* @var $this MaxDiscountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Max Discounts'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create MaxDiscount'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage MaxDiscount'), 'url'=>array('admin')),
);
?>

<h1>Max Discounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
