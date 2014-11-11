<?php
/* @var $this ContractorDenisController */
/* @var $model ContractorDenis */

$this->breadcrumbs=array(
	Yii::t('general','Contractor Denises')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List ContractorDenis'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage ContractorDenis'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Contractor Denises'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>