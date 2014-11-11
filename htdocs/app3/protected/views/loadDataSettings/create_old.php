<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */

$this->breadcrumbs=array(
	'Load Data Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LoadDataSettings', 'url'=>array('index')),
	array('label'=>'Manage LoadDataSettings', 'url'=>array('admin')),
);
?>

<h1>Create LoadDataSettings</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>