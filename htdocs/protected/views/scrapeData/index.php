<?php
/* @var $this ScrapeDataController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Scrape Datas'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create ScrapeData'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage ScrapeData'), 'url'=>array('admin')),
);
?>

<h1>Scrape Datas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
