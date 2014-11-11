<?php
/* @var $this AdvertisementController */
/* @var $model Advertisement */
?>
<h2><?php echo Yii::t('general','Block') . ' <em><u>'. $model->blockId . '</u></em>'; ?></h2>
<br><?php if($model->blockId == 'RSS Feed') echo '<label class="error required">Задайте каналы RSS через запятую. Первый из них будет использоваться для формирования новостей на сайте.</label>'; ?><br>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>