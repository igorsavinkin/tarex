<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */

$this->breadcrumbs=array(
	'Assortments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Assortment', 'url'=>array('index')),
	array('label'=>'Manage Assortment', 'url'=>array('admin')),
);
?>

<h1>Create Assortment</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>