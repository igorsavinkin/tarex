<h1><font color='#444'><?php echo Yii::t('general', 'Profile') , ' </font><b><em>' , $model->OrganizationInfo , $model->username , ' (' , $model->email , ')'; ?></b></em></h1> 
<?php $this->widget('CTabView', array(
   'htmlOptions'=>array('id'=>'profile-tabs'),
   'tabs'=>array(
     /*    'tab1'=>array(
            'title'=>Yii::t('general', 'Finance'), //'Основное', 
            'view'=>'_finance',
            'data'=>array('model'=>$model),
			  ), 
        'tab2'=>array(
            'title'=>Yii::t('general', 'Orders'), //'заказы', 
            'view'=>'_order',
            'data'=>array('model'=>$model),
			//'visible'=>User::model()->findByPk($model->id)->role == User::ROLE_USER_RETAIL,
       
		),  
		'tab3'=>array(
            'title'=>Yii::t('general', 'Password'), //'заказы', 
            'view'=>'_password',
            'data'=>array('model'=>$model),
			'visible'=>$model->id == Yii::app()->user->id,
       
		), */
		'tab4'=>array(
            'title'=>Yii::t('general', 'Operating conditions'),  
            'view'=>'_general_info',
           'data'=>array('conditions'=>$model->operationCondition),
			//'visible'=>$model->id == Yii::app()->user->id,
       
		),
	/*	'tab5'=>array(
            'title'=>Yii::t('general', 'Ruble to $ US rate'),  
            'view'=>'_currency_rate', 
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_SENIOR_MANAGER),       
		), */
	)
));?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.extended-form-button').click(function(){
	$('.extended-form').toggle();
	$('.view-form').hide();
	return false;
});
$('.view-form-button').click(function(){
	$('.view-form').toggle();
	$('.extended-form').hide();
	return false;
});

");  ?>
</br></br>
<?php
echo CHtml::link(Yii::t('general', 'Change User\'s credentials'),'#',array('class'=>'extended-form-button btn-win')); 
echo '&nbsp;&nbsp;&nbsp;&nbsp;', CHtml::link(Yii::t('general', 'View User\'s credentials'),'#',array('class'=>'view-form-button btn-win')); 
?>
</br></br><hr size='2px' color="#54AAFF"></hr> 
<div class="extended-form" style="display:none">
<?php $this->renderPartial('_form_ext', array('model'=>$model)); ?>
</div><!-- search-form -->
<div class="view-form" style="display:none">
<?php $this->renderPartial('_view2', array('model'=>$model)); ?> 
</div><!-- search-form -->
