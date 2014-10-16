<?php
/* @var $this OfficeVehicleController */
/* @var $model OfficeVehicle */

$this->breadcrumbs=array(
	Yii::t('general','Office Vehicles')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List OfficeVehicle'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage OfficeVehicle'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Office Vehicles'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>