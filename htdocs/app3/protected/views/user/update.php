<?php
 
$this->pageTitle =  Yii::t('general','User') . ' ' . Yii::t('general','Profile');
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
	echo '<ul style="list-style-type: none;" class="flashes">';
	foreach($flashMessages as $key => $message) {
		echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
		}
	echo '</ul>'; 	 
}
?>  	 
<h4><?php echo Yii::t('general','User') , ' <u><em>',  $model->username , '</em></u>'; 
//if (Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
	//echo CHtml::Link(Yii::t('general','Manage Advertisement'), array('advertisement/admin'), array('class'=>'btn-win', 'style'=>'float:right;')); 
if (Yii::app()->user->checkAccess(User::ROLE_MANAGER)) {
 //   echo CHtml::link(Yii::t('general','Send to client login/password'), array('sendinvitation', 'id'=>$model->id), array('class'=>'btn-win', 'style'=>'float:right;')); 
	echo CHtml::link(Yii::t('general','Send to client login/password with a link to a particular page'), array('sendinvitation2', 'id'=>$model->id), array('class'=>'btn-win', 'style'=>'float:right;'));

	}	
?></h4><br>
<?php //$this->renderPartial('_form_new', array('model'=>$model));  
$this->widget('CTabView', array( 
		'activeTab'=>isset($_GET['new']) ? 'tab3' : '',// если создаём по новому то тогда сразу переходим на группу скидок
		'tabs'=>array(			
			 'tab1'=>array(
				'title'=>Yii::t('general', 'Main'), //'Основное', 
				'view'=>'_form_new',
				'data'=>array('model'=>$model, 
									 'userGroupDiscount' => $userGroupDiscount), 
			 ), 
			'tab2'=>array(
				'title'=>Yii::t('general', 'Contract'),  
				'view'=>'_contract', 
				'data'=>array('model'=>$model),
			),	
	/*		'tab3'=>array( 
				'title'=>Yii::t('general', 'Discount groups'),  
				'view'=>'_discount_groups', 
				'data'=>array('model'=>$model,
									'userGroupDiscount' => $userGroupDiscount),
				'visible'=>Yii::app()->user->checkAccess(User::ROLE_MANAGER) && (User::model()->findByPk($model->id)->role == User::ROLE_USER),
			),*/
			'tab4'=>array(
				'title'=>Yii::t('general', 'Additional info'),  
				'view'=>'_info', 
				'data'=>array('model'=>$model),
			),			 
		)
	));
?>  


