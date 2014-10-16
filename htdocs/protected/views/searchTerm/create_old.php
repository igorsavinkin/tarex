<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */

$this->breadcrumbs=array(
	'Search Terms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SearchTerm', 'url'=>array('index')),
	array('label'=>'Manage SearchTerm', 'url'=>array('admin')),
);
?>

<h1>Create SearchTerm</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>