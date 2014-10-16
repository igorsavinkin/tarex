<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */

$this->breadcrumbs=array(
	'Search Terms'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SearchTerm', 'url'=>array('index')),
	array('label'=>'Create SearchTerm', 'url'=>array('create')),
	array('label'=>'View SearchTerm', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SearchTerm', 'url'=>array('admin')),
);
?>

<h1>Update SearchTerm <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>