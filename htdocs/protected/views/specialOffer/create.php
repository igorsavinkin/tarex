<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */

$this->breadcrumbs=array(
	Yii::t('general','Special Offers')=>array('admin'),
	Yii::t('general','Create'),
); 
?>

<h1><?php echo Yii::t('general','Create'), ' ', Yii::t('general','Special Offer'); ?></h1>
<br>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>