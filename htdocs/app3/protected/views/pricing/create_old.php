<?php
/* @var $this PricingController */
/* @var $model Pricing */

$this->breadcrumbs=array(
	'Pricings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pricing', 'url'=>array('index')),
	array('label'=>'Manage Pricing', 'url'=>array('admin')),
);
?>

<h1>Create Pricing</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>