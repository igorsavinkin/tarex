<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */

$this->breadcrumbs=array(
	Yii::t('general','Assortments')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Assortment'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Assortment'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View Assortment'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage Assortment'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View Assortment') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>