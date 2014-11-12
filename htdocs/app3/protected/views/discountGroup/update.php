<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */

$this->breadcrumbs=array(
	Yii::t('general','Discount Groups')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List DiscountGroup'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create DiscountGroup'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View DiscountGroup'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage DiscountGroup'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View DiscountGroup') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>