<h2>HTML Editor field</h2>
 

<?php
$this->widget('ext.editMe.widgets.ExtEditMe', array(
    'name'=>'example',
    'value'=>'put your template code here',
));

$this->widget('ext.XHeditor',array(
	'language'=>'en', //options are en, zh-cn, zh-tw
	'config'=>array(
		'id'=>'xh1',
		'name'=>'xh',
		'tools'=>'mini', // mini, simple, fill or from XHeditor::$_tools
		'width'=>'100%',
		//see XHeditor::$_configurableAttributes for more
	),
	'contentValue'=>'Enter your text here', // default value displayed in textarea/wysiwyg editor field
	'htmlOptions'=>array('rows'=>5, 'cols'=>10),// to be applied to textarea
)); 
?>