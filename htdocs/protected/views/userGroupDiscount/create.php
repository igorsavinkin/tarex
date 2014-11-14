<?php
/* @var $this UserGroupDiscountController */
/* @var $model UserGroupDiscount */

$this->breadcrumbs=array(
	Yii::t('general','User Group Discounts')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List UserGroupDiscount'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage UserGroupDiscount'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create User Group Discounts'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>