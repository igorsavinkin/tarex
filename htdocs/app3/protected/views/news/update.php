<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */
$this->breadcrumbs=array(
	Yii::t('general','News')=>array('admin'), 
	Yii::t('general','Create')=>array('create'),
);?>
<h1><?php echo Yii::t('general','Edit'), ' ',  Yii::t('general','news') . ' <em><u>'. $model->title . '</u></em>'; ?></h1>
<br>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>