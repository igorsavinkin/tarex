<?php
/* @var $this DiscountGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Discount Groups'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create DiscountGroup'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage DiscountGroup'), 'url'=>array('admin')),
);
?>

<h1>Discount Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
