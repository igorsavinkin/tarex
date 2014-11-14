<?php
/* @var $this UserGroupDiscountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','User Group Discounts'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create UserGroupDiscount'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage UserGroupDiscount'), 'url'=>array('admin')),
);
?>

<h1>User Group Discounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
