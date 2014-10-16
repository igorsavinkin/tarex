<?php
/* @var $this PricingController */
/* @var $model Pricing */
?>
<h1><?php echo Yii::t('general','Pricing') , ' <em><u>', $model->Comment; ?></u></em></h1>
<br>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>