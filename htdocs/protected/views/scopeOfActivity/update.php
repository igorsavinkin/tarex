<?php
/* @var $this ScopeOfActivityController */
/* @var $model ScopeOfActivity */
?>
<h1><?php echo Yii::t('general','Scope Of Activity') . ' <em><u>'. $model->trName . '</u></em>'; ?></h1> 
<?php $this->renderPartial('_form', array('model'=>$model)); ?>