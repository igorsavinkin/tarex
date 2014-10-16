<?php
/* @var $this SubgroupController */
/* @var $model Subgroup */

$this->breadcrumbs=array(
	'Subgroups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Subgroup', 'url'=>array('index')),
	array('label'=>'Create Subgroup', 'url'=>array('create')),
	array('label'=>'View Subgroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Subgroup', 'url'=>array('admin')),
);
?>

<h1>Update Subgroup <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>