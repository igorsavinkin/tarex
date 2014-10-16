<?php
/* @var $this SparePartController */
/* @var $model SparePart */

$this->breadcrumbs=array(
	Yii::t('general','Spare Parts')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List SparePart'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage SparePart'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Spare Parts'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>