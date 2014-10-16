<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	Yii::t('general','Event Contents')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List EventContent'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage EventContent'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Event Contents'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>