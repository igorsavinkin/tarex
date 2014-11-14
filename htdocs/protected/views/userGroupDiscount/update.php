<?php
/* @var $this UserGroupDiscountController */
/* @var $model UserGroupDiscount */

$this->breadcrumbs=array(
	Yii::t('general','User Group Discounts')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List UserGroupDiscount'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create UserGroupDiscount'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View UserGroupDiscount'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage UserGroupDiscount'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View UserGroupDiscount') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>