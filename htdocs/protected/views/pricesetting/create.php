<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */

$this->breadcrumbs=array(
	Yii::t('general','Pricesetting')=>array('admin'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Pricesetting'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage Pricesetting'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Pricesetting'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>