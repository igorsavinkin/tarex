<?php
/* @var $this ContractorDenisController */
/* @var $model ContractorDenis */

$this->breadcrumbs=array(
	'Contractor Denises'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ContractorDenis', 'url'=>array('index')),
	array('label'=>'Manage ContractorDenis', 'url'=>array('admin')),
);
?>

<h1>Create ContractorDenis</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>