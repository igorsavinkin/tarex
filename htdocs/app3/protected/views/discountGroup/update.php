<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */
 

?>
<h1><?php echo Yii::t('general','Edit'), ' ' ,Yii::t('general','Discount Group') , ' <em><u>', $model->name . '</u></em>'; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>