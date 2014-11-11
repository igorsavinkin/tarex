<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */



?>
	<?php Yii::app()->clientScript->registerCssFile("extjs/resources/css/ext-all.css"); ?>
	<?php Yii::app()->clientScript->registerScriptFile("extjs/ext-all.js")	?>
	<?php //Yii::app()->clientScript->registerScriptFile("js/Lang.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/UniversalStore.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("js/reports/Pogenerator.js")	?>


 
<h3><?php echo Yii::t('general','P.O. Generator'); ?></h3>

<div id="Pogenerator"></div><br>

<table border=1  width=100%><tr><td  width=40%>Suppliers:
<div id="Suppliers"></div>
</td><td >Replacements:
<div id="ReplacementItems"></div>
</td>
</tr>
<tr><td colspan=2 >Item statistics:
<div id="ItemStatistics"></div>
</td>
</tr></table>



