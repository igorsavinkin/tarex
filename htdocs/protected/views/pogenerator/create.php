<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */

$this->breadcrumbs=array(
	Yii::t('general','Assortments')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Assortment'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage Assortment'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Assortments'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>