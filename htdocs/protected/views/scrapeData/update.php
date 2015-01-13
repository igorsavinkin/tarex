<?php
/* @var $this ScrapeDataController */
/* @var $model ScrapeData */

$this->breadcrumbs=array(
	Yii::t('general','Scrape Datas')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List ScrapeData'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create ScrapeData'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View ScrapeData'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Manage ScrapeData'), 'url'=>array('admin')),
);

?>
<h1><?php echo Yii::t('general','View ScrapeData') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<h1></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>