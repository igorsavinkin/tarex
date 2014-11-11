<?php
/* @var $this SpecialOfferController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Special Offers'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create SpecialOffer'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage SpecialOffer'), 'url'=>array('admin')),
);
?>

<h1>Special Offers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
