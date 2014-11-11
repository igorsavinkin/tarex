<?php
/* @var $this LoadDataSettingsController */
/* @var $model LoadDataSettings */

?>
<h1><?php echo Yii::t('general','Load Data Settings') . ' <em><u>'. $model->TemplateName . '</u></em>'; ?></h1><br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>