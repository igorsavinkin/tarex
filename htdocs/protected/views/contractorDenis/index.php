<?php
/* @var $this ContractorDenisController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Contractor Denises'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create ContractorDenis'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage ContractorDenis'), 'url'=>array('admin')),
);
?>

<h1>Contractor Denises</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
