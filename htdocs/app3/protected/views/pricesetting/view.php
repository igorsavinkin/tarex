<?php
/* @var $this PricesettingController */
/* @var $model Pricesetting */

$this->breadcrumbs=array(
	Yii::t('general','Pricesetting')=>array('admin'),
	$model->id,
); ?>
<h1><?php echo Yii::t('general','View Pricesetting') .  ' ' . Yii::t('general','from') , ' <em><u>'. $model->dateTime . '</u></em> '; ?></h1>
 
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'dateTime',
		'RURrate',
		'EURrate',
		'LBPrate',
		//'USDrate',
		//'organizationId',
		'personResponsible' => array(
			'label'=>'personResponsible', 
			'type'=>'raw',   // here's a parameter that disables HTML escaping by Yii
			'value'=>User::model()->findByPk($model->personResponsible)->username,
			),
	),
)); ?>
