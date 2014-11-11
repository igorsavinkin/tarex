<?php
/* @var $this ContractorController */
/* @var $model Contractor */

$this->breadcrumbs=array(
	Yii::t('general','Contractors')=>array('admin_frontend'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Contractor'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage Contractor'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Contractors'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>