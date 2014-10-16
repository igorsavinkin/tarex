<?php
/* @var $this ContractorDenisController */
/* @var $model ContractorDenis */

$this->breadcrumbs=array(
	'Contractor Denises'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContractorDenis', 'url'=>array('index')),
	array('label'=>'Create ContractorDenis', 'url'=>array('create')),
	array('label'=>'View ContractorDenis', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ContractorDenis', 'url'=>array('admin')),
);
?>

<h1>Update ContractorDenis <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>