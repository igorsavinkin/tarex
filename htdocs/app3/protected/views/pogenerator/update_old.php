<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */

$this->breadcrumbs=array(
	'Assortments'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Assortment', 'url'=>array('index')),
	array('label'=>'Create Assortment', 'url'=>array('create')),
	array('label'=>'View Assortment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Assortment', 'url'=>array('admin')),
);
?>

<h1>Update Assortment <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>