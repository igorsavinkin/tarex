<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */

$this->breadcrumbs=array(
	'Load Data Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LoadDataSettings', 'url'=>array('index')),
	array('label'=>'Create LoadDataSettings', 'url'=>array('create')),
	array('label'=>'View LoadDataSettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LoadDataSettings', 'url'=>array('admin')),
);
?>

<h1>Update LoadDataSettings <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>