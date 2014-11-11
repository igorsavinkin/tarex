 $this->widget('ext.select2.ESelect2',array(
		'attribute' => 'subStatus',
		'model'=>$performance,        
		'data'=>$subStatusArray,
		'htmlOptions'=>array( 
			'onChange'=>CHtml::ajax(array('type'=>'POST',
			'url'=>'docEventsPerformance/update',
			'data'=>'js:$("#performance-form").serialize()',)),
		),  
   ));  