<?php
/* @var $this SparePartController */
/* @var $model SparePart */
?>
<h1><?php echo Yii::t('general','Spare Part') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>