<?php
/* @var $this SubgroupController */
/* @var $model Subgroup */

$this->breadcrumbs=array(
	Yii::t('general','Subgroups')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Subgroup'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Subgroup'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View Subgroup'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage Subgroup'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View Subgroup') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>