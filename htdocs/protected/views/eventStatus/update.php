<h3><?php 
echo  Yii::t('general', 'Event Status') , ' <em>' , Yii::t('general', $model->name) , '</em></h3>';
$this->pageTitle = Yii::t('general','Event Status'); 
$this->renderPartial('_main', array('model'=>$model)); 
/*$this->widget('CTabView', array(
'tabs'=>array(			
	 'tab1'=>array(
		'title'=>Yii::t('general', 'Main'), //'Основное', 
		'view'=>'_main',
		'data'=>array('model'=>$model),				
	 ), 			
))); */
?>