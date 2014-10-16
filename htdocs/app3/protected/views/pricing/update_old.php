<?php
/* @var $this PricingController */
/* @var $model Pricing */

$this->breadcrumbs=array(
	'Pricings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pricing', 'url'=>array('index')),
	array('label'=>'Create Pricing', 'url'=>array('create')),
	array('label'=>'View Pricing', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pricing', 'url'=>array('admin')),
);
?>

<h1>Update Pricing <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>