<?php
/* @var $this AccountsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Accounts'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create Accounts'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage Accounts'), 'url'=>array('admin')),
);
?>

<h1>Расчетные счета</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
