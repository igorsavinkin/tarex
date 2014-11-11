<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */

$this->breadcrumbs=array(
	Yii::t('general','Discount Groups')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List DiscountGroup'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage DiscountGroup'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Discount Groups'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>