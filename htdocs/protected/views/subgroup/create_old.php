<?php
/* @var $this SubgroupController */
/* @var $model Subgroup */

$this->breadcrumbs=array(
	'Subgroups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Subgroup', 'url'=>array('index')),
	array('label'=>'Manage Subgroup', 'url'=>array('admin')),
);
?>

<h1>Create Subgroup</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>