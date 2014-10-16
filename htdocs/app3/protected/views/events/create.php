<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	Yii::t('general','Events')=>array('admin'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Events'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage Events'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Event'); ?></h1>

<?php 

$this->renderPartial('_form', array('model'=>$model)); 


?>