<h3><?php 
echo  Yii::t('general', 'Organization') , ' <em>' , $model->name; ?></em></h3>
<? $this->renderPartial('_main', array(	'model'=>$model));  
/*$this->widget('CTabView', array(
'tabs'=>array(			
	 'tab1'=>array(
		'title'=>Yii::t('general', 'Main'), //'Основное', 
		'view'=>'_main',
		'data'=>array('model'=>$model),				
	 ), 			
)));
*/
?>