<?php
/* @var $this ContractorController */
/* @var $model Contractor */

$this->breadcrumbs=array(
	Yii::t('general','Contractors')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Contractor'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Contractor'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View Contractor'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage Contractor'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View Contractor') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>