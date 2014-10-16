<?php
/* @var $this OfficeVehicleController */
/* @var $model OfficeVehicle */

$this->breadcrumbs=array(
	Yii::t('general','Office Vehicles')=>array('admin'), 
); 

?>
<h1><?php echo Yii::t('general','Edit Office Vehicle') . ' <em><u>'. $model->make . ' ' . $model->model . ' (' . $model->driver . ')</u></em> '; ?></h1> 
<?php $this->renderPartial('_form', array('model'=>$model)); ?>