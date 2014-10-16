<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */

$this->breadcrumbs=array(
	Yii::t('general','Search Terms')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List SearchTerm'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage SearchTerm'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Search Terms'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>