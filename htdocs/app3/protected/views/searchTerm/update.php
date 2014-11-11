<?php
/* @var $this SearchTermController */
/* @var $model SearchTerm */

$this->breadcrumbs=array(
	Yii::t('general','Search Terms')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List SearchTerm'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create SearchTerm'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View SearchTerm'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage SearchTerm'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View SearchTerm') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>