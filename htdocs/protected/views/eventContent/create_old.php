<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	'Event Contents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EventContent', 'url'=>array('index')),
	array('label'=>'Manage EventContent', 'url'=>array('admin')),
);
?>

<h1>Create EventContent</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>