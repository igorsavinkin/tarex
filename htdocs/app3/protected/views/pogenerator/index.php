<?php
/* @var $this PogeneratorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Assortments'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create Assortment'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage Assortment'), 'url'=>array('admin')),
);
?>

<h1>Номенклатура</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
