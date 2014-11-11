<h2>VIN: <em><?php echo $vin; ?></em></h2><br>

<div id="printResult">
	<img src='css/loading.gif' height='320' />
	<?php //echo 'по VIN-номеру'.$vin.' пока ничего не найдено.'; ?>
</div>

<?php
Yii::app()->clientScript->registerScriptFile("css/SearchByVin.js");	  
Yii::app()->clientScript->registerScript('search-vin', "
	FSeachByVin('{$vin}');
");
?>