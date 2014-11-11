<?php
/* @var $this MaxDiscountController */
/* @var $model MaxDiscount */

$this->breadcrumbs=array(
	Yii::t('general','Max Discounts')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List MaxDiscount'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create MaxDiscount'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View MaxDiscount'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage MaxDiscount'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View MaxDiscount') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>