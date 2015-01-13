<?php
/* @var $this ScrapeDataController */
/* @var $model ScrapeData */

$this->breadcrumbs=array(
	Yii::t('general','Scrape Datas')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List ScrapeData'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage ScrapeData'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Scrape Datas'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>