<h3><?php 
echo  Yii::t('general', 'Current Account') , ' <em>' , $model->name , '</em></h3>';
$this->pageTitle = Yii::t('general','Current Account'); 
$this->widget('CTabView', array(
'tabs'=>array(			
	 'tab1'=>array(
		'title'=>Yii::t('general', 'Main'), //'Основное', 
		'view'=>'_main',
		'data'=>array('model'=>$model),				
	 ), 			
)));?>