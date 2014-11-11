<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */

$this->breadcrumbs=array(
	Yii::t('general','Pricesettings')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Pricesetting'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Pricesetting'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View Pricesetting'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage Pricesetting'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View Pricesetting') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>