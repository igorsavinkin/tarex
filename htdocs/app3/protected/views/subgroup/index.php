<?php
/* @var $this SubgroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Subgroups'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create Subgroup'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage Subgroup'), 'url'=>array('admin')),
);
?>

<h1>Subgroups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
