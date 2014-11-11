<?php
/* @var $this PricesettingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Pricesettings'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create Pricesetting'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage Pricesetting'), 'url'=>array('admin')),
);
?>

<h1>Pricesettings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
