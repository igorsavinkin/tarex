<?php 
if (Yii::app()->user->checkAccess(User::ROLE_MANAGER))
{	
	echo CHtml::Form();	    
  	$this->widget('ext.XHeditor',array(
		'language'=>'en',
		'model'=>$model,
		'modelAttribute'=>'operationCondition',
	//	'showModelAttributeValue'=>false, // defaults to true, displays the value of $modelInstance->attribute in the textarea
		'config'=>array( 
			'tools'=>'fill', // mini, simple, fill or from XHeditor::$_tools
			'width'=>'100%',
			//see XHeditor::$_configurableAttributes for more
		),
	//'contentValue'=>'Enter your text here', // default value displayed in textarea/wysiwyg editor field  
		'htmlOptions'=>array('rows'=>150, 'cols'=>140),// to be applied to textarea
	)); 
	//echo CHtml::activeTextArea($model, 'operationCondition' , array('rows'=>20, 'cols'=>90) );
	echo CHtml::submitButton(Yii::t('general', 'Save'), array('class'=>'red'));
	echo CHtml::endForm(); 
}
else 
{
	 echo htmlspecialchars_decode($model->operationCondition);
} 
?>