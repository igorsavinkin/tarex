<?php
/* @var $this ContractorController */
/* @var $model Contractor */

$this->breadcrumbs=array(
	'Contractors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Contractor', 'url'=>array('index')),
	array('label'=>'Manage Contractor', 'url'=>array('admin')),
);
?>

<h1>Create Contractor</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>