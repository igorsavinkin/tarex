<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */

$this->breadcrumbs=array(
	'Pricesettings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pricesetting', 'url'=>array('index')),
	array('label'=>'Create Pricesetting', 'url'=>array('create')),
	array('label'=>'View Pricesetting', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pricesetting', 'url'=>array('admin')),
);
?>

<h1>Update Pricesetting <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>