<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */

$this->breadcrumbs=array(
	Yii::t('general','Discount Groups')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
); 

?>
<h1><?php echo Yii::t('general', 'DiscountGroup') . ' <em><u>'. $model->name . '</u></em>'; ?></h1> 

<?php $this->renderPartial('_form', array('model'=>$model)); ?>