<?php
/* @var $this EventContentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Event Contents'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create EventContent'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage EventContent'), 'url'=>array('admin')),
);
?>

<h1>Event Contents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
