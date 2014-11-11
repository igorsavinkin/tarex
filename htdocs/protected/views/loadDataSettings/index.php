<?php
/* @var $this LoadDataSettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('general','Load Data Settings'),
);
$this->menu=array(
	array('label'=>Yii::t('general','Create LoadDataSettings'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Manage LoadDataSettings'), 'url'=>array('admin')),
);
?>

<h1>Load Data Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
