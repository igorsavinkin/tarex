<h3><?php 
echo  Yii::t('general', 'Main Menu') , ' <em>' , Yii::t('general', $model->Reference) , '</em></h3>';
$this->pageTitle = Yii::t('general','Main Menu'); 
$this->widget('CTabView', array(
'tabs'=>array(			
	 'tab1'=>array(
		'title'=>Yii::t('general', 'Main'), //'Основное', 
		'view'=>'_main',
		'data'=>array('model'=>$model),				
	 ), 			
)));?>