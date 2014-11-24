<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */

$this->breadcrumbs=array(
	Yii::t('general','Price List Settings')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List PriceListSetting'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage PriceListSetting'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create Price List Settings'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>