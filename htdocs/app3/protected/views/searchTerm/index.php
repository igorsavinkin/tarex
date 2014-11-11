<?php
/* @var $this SearchTermController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Search Terms'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create SearchTerm'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage SearchTerm'), 'url'=>array('admin')),
);
?>

<h1>Search Terms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
