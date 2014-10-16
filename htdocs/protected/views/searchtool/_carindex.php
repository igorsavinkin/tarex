<br><h2><?php  echo Yii::t('general','Car Index'); ?></h2><?php 
$this->widget('zii.widgets.grid.CGridView', array( 
		'id'=>'car-index-grid',
		'dataProvider'=>$arrayDataProviderCarIndex,  
        'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		'filter'=>$model,
	    'pager' => array( 'cssFile' => Yii::app()->baseUrl . '/css/customPager.css' ),		
		'columns'=>array(
			'model', 
			'make',
			'country',  
			)
		));
/*$this->widget('zii.widgets.grid.CGridView', array( 
		'id'=>'car-index-grid',
		'dataProvider'=>$dataProviderCarIndex,  
        'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		'pager' => array( 'cssFile' => Yii::app()->baseUrl . '/css/customPager.css' ),				
 	//	'ajaxUrl'=>array('assortment/index'),
		'filter'=>$model,
		'columns'=>array(
		//'id', 
			'model', 
			'make',
			'country',  
		),
	)); 
	*/?>