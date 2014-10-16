<?php
/* @var $this ContractorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Contractors'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create Contractor'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage Contractor'), 'url'=>array('admin')),
);
?>

<h1>Контрагенты</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
