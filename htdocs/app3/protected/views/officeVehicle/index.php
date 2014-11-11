<?php
/* @var $this OfficeVehicleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Office Vehicles'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create OfficeVehicle'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage OfficeVehicle'), 'url'=>array('admin')),
);
?>

<h1>Office Vehicles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
