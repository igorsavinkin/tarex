<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	Yii::t('general','Accounts')=>array('admin'),
);


?>
<h2><?php echo Yii::t('general','View Accounts') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>