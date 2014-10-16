<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	'Event Contents'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EventContent', 'url'=>array('index')),
	array('label'=>'Create EventContent', 'url'=>array('create')),
	array('label'=>'View EventContent', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EventContent', 'url'=>array('admin')),
);
?>

<h1>Update EventContent <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>