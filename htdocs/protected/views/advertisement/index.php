<?php
/* @var $this AdvertisementController */
/* @var $dataProvider CActiveDataProvider */
?>
<h1>Advertisements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
