<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */
?>  
<h1><?php echo Yii::t('general','Getting price list by email'); ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); 
//print_r( array_keys ($model->attributes )); 
//print_r($model->getTableSchema());
?>