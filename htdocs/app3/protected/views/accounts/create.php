<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	Yii::t('general','Accounts')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Accounts'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage Accounts'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Accounts'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>