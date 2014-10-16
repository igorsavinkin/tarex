<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Users'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create User'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage User'), 'url'=>array('admin')),
);
?>

<h1>Клиенты</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
