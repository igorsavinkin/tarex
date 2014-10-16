<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Accounts', 'url'=>array('index')),
	array('label'=>'Create Accounts', 'url'=>array('create')),
	array('label'=>'View Accounts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Accounts', 'url'=>array('admin')),
);
?>

<h1>Update Accounts <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>