<?php
/* @var $this ScopeOfActivityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Scope Of Activities'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create ScopeOfActivity'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage ScopeOfActivity'), 'url'=>array('admin')),
);
?>

<h1>Scope Of Activities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
