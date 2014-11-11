<?php
/* @var $this MaxDiscountController */
/* @var $model MaxDiscount */

$this->breadcrumbs=array(
	Yii::t('general','Max Discounts')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List MaxDiscount'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage MaxDiscount'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Max Discounts'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>