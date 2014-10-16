<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */

$this->breadcrumbs=array(
	'Pricesettings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pricesetting', 'url'=>array('index')),
	array('label'=>'Manage Pricesetting', 'url'=>array('admin')),
);
?>

<h1>Create Pricesetting</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>