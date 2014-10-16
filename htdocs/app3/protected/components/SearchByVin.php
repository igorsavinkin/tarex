<?php
class SearchByVIN extends CWidget
{
    public function run()
    {
		Yii::app()->clientScript->registerScriptFile("css/SearchByVin.js");	
		
		//echo '<h3>', Yii::t('general','Search by VIN'), '</h3>'; 
			echo Chtml::form(Yii::app()->createUrl('assortment/searchbyvin'), 'get');
			echo Chtml::textField('vin', 'WAUBH54B11N111054', array('size'=>20));
			echo '&nbsp;<br><center>' , CHtml::submitButton(Yii::t('general','Find'), array('class'=>'red')), '</center>'; 
		echo Chtml::endForm();
	} 
}
?>