<h3><?php 
echo  Yii::t('general', 'Category') , ' <em>' , $model->name , '</em></h3>';
$this->pageTitle = Yii::t('general','Category'); 
$this->widget('CTabView', array(
'tabs'=>array(			
	 'tab1'=>array(
		'title'=>Yii::t('general', 'Main'), //'Основное', 
		'view'=>'_main',
		'data'=>array('model'=>$model),				
	 ), 			
)));?>