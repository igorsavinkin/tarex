<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */
$this->breadcrumbs=array(
	Yii::t('general','Special Offers')=>array('admin'), 
	Yii::t('general','Create')=>array('create'),
);?>
<h1><?php echo Yii::t('general','Edit'), ' ',  Yii::t('general','Special Offer') . ' <em><u>'. $model->description . '</u></em>'; ?></h1>
<br>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>