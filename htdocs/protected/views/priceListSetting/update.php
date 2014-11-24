<?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */

?>
<h1><?php echo Yii::t('general','Edit Price List Setting') . ' <em><u>'. $model->id . '</u></em>'; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>