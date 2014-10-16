<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */

$this->breadcrumbs=array(
	Yii::t('general','Load Data Settings')=>array('index'),
	Yii::t('general','Create'),
);
?>
<h1><?php echo Yii::t('general','Create Load Data Settings'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>