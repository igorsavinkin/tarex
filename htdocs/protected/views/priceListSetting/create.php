<h3><?php
/* @var $this PriceListSettingController */
/* @var $model PriceListSetting */
$msg = Yii::t('general', 'Wait several seconds till the server composes and sends you personalized price list');
//echo CHtml::Link(Yii::t('general','Download price list as Excel sheet') , array('user/pricelist') , array( 'class'=>'btn-win',  'onclick'=>"js:setTimeout(function(){ alert('{$msg}')},600);")); 
//echo CHtml::Link(Yii::t('general','Download price list as Excel sheet'). '(csv)' , array('user/pricelistCSV') , array( 'class'=>'btn-win' , 'onclick'=>"js:setTimeout(function(){ alert('{$msg}')},600);")); 
?></h3>
<h1><?php echo Yii::t('general','Getting price list by email'); ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>