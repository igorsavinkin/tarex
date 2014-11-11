<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	Yii::t('general','Event Contents')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List EventContent'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create EventContent'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View EventContent'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage EventContent'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View EventContent') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>