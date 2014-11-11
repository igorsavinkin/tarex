<?php
/* @var $this ContractorDenisController */
/* @var $model ContractorDenis */

$this->breadcrumbs=array(
	Yii::t('general','Contractor Denises')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List ContractorDenis'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create ContractorDenis'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View ContractorDenis'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage ContractorDenis'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View ContractorDenis') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>