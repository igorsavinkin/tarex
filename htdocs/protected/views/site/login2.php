<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/in.css');
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('general', 'Login');
 
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages && 0) :
    echo '<ul style="list-style-type: none;" class="flashes">';
    foreach($flashMessages as $key => $message) {
        echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
    }
    echo '</ul>'; 
	
else :  

?> 	
	<div id='recover-popup' class="tar_recover_form"> 
		<div class="tar_in_head">
			<span><?php echo Yii::t('general','Recover login and password'); ?> </span>
			<a href="#" class='back-link'>
					<img src="images/tar_x.png">
			</a> 
		</div>
		<div class="tar_recover_in_form" >
			<div class='tar_in_text_1'>
			 <?php echo Yii::t('general', 'Enter your email'), ':';?>	
			</div>			 
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'assortment-form',
				'enableAjaxValidation'=>false,
				'method'=>'post',
				'htmlOptions' => array( 
				),
			)); ?>
			<input type='text' name='email' size='44' class='input_text'><br />
			<div class='tar_in_text_1'><?php echo Yii::t('general', 'The login and password will be sent to this email address');?>
			</div>
			<center><?php echo CHtml::submitButton(Yii::t('general', 'Send'), array('class'=>'in_form_submit')); ?>
			</center>		 	
		</div><!-- tar_recover_in_form -->
		
		<?php $this->endWidget(); ?>
		
	</div><!-- id='recover-popup' -->
	<!--   ****************************** end of the Dialog box  ****************** 
	 ****************** script for the recover popup box ********************* -->
 <?php  
  Yii::app()->clientScript->registerScript('dialog', "
	$('.recover-link').click(function(data){		 
		$('#login-popup').hide();
		$('#recover-popup').show();
		return false;
	}); 
	$('.back-link').click(function(data){		 
		$('#recover-popup').hide();
		$('#login-popup').show();
		return false;
	}); 
	", CClientScript::POS_END);	
endif; 
?>
<style> 
#recover-popup
{ 	top: -10px;
	z-index: 1001;
    /*display:none;*/	 
}  
</style>
 
 