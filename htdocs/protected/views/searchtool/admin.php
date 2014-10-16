	<?php Yii::app()->clientScript->registerCssFile("extjs/resources/css/ext-all.css"); ?>
	<?php Yii::app()->clientScript->registerCssFile("css/test.css"); ?>
	<?php Yii::app()->clientScript->registerScriptFile("extjs/ext-all.js")	?>
	<?php //Yii::app()->clientScript->registerScriptFile("js/Lang.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/UniversalStore.js")	?>


	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/Notes.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/QuickSearch.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/CompanyToolbar.js")	?>

	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/MenuRC.js")	?>

	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/AssortmentInformationWindow.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/AssortmentMainGrid.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/AssortmentWindow.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/AssortmentInformationWindow.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/CustomerToolbar.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/CustomersPanel.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/DeliveryToolbar.js")	?>
	<?php // Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/Order.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/Order_n.js")	?>

	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/Index.js")	?>


	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FAdd.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FChange.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FFind.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FFindContractor.js")	?>
	<?php //Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FRecalcAll.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FRecalcAll_n.js")	?>
	<?php //Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FResimulate.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FResimulate_n.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/SearchTool/FRestoreAvailability.js")	?>
	
	<?php // Внимание, здесь мы определяем служебную информацию для вставки в ExtJs. Переменные - глобальные.
	Yii::app()->clientScript->registerScript('service-data', " UserRole = ". Yii::app()->user->role . "; ");?>
	
	
<h3>
<?php
echo Yii::t('general', 'Search tool').'<br>';
?>
</h3>
 


<table border=1  width=100%>
<tr><td>
<div id="Notes"></div>
</td></tr>
<tr><td>
<div id="QuickSearch"></div>

</td></tr>

<tr><td>
<div id="CompanyToolbar"></div>
</td></tr>
</table>

<div id="Searchtool">Main assortment grid:</div>


<table><tr><td>
<div id="CustomerPanel">Contractor section:</div>
</td></tr>


<tr><td>
<div id="Order">Order:</div>
</td></tr>

<tr>
<td class='row-valid'>Test blue css</td> 
<tr>

</table>

