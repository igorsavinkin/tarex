<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/in.css');

$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages && 0) :
    echo '<ul style="list-style-type: none;" class="flashes">';
    foreach($flashMessages as $key => $message) {
        echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
    }
    echo '</ul>'; 
	
else :  
	$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('general', 'Login');
 	?>
	<!-- **************************** start of the Login box ********************** -->
	<div class="tar_in_form" id='login-popup'> 
        <div class="tar_in_head">
            <span><?php echo Yii::t('general','Sign in'); ?></span>
            <a href="#" id='login-back-link'>
                <img src="images/tar_x.png">
            </a>
            <div class="pad"></div>
        </div>
        <div class="tar_in_in_form">
            <div class="tar_in_text_1">
                <?php echo Yii::t('general','Please fill out the following form with your login credentials'), ': '; ?>  
            </div>
		<p class="tar_in_text_2"><?php echo Yii::t('general','Fields with');  ?>
		<span class="required"> * </span><?php echo Yii::t('general','are required')?>
		</p>
            <div class="tar_in_form_real">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'method'=>'post',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>
				<div class="tar_in_input_all">
					<div class="tar_in_input"> 
						<?php echo $form->labelEx($model,'email', array('class'=>"input_text")); ?></br>
						<?php echo $form->textField($model,'email', array('class'=>"in_form_text")); ?>
						<?php echo $form->error($model,'email'); ?></br>
					</div>
					<div class="tar_in_input">
						<?php echo $form->labelEx($model,'password', array('class'=>"input_text")); ?></br>
						<?php echo $form->passwordField($model,'password', array('class'=>"in_form_text")); ?>
					   <?php echo $form->error($model,'password'); ?> 
					</div>  
						<?php echo $form->checkBox($model,'rememberMe', array('class'=>"in_check")); ?>
						<?php echo $form->label($model,'rememberMe', array('class'=>"tar_remember_me")); ?>
						<?php echo $form->error($model,'rememberMe'); ?>					
					<a class="tar_in_pass recover-link" href="#">
						 <?php echo Yii::t('general','Forgot your username or password?' );  ?>
					</a>  
					<input type="submit" class="in_form_submit" value="<?php echo Yii::t('general','Sign in'); ?>" name='login'>
				</div>   
				<?php $this->endWidget(); ?>
           </div>
           <br> 
           <div class="tar_in_text_3"><?php echo Yii::t('general','If you have no account in the system, please') , ' '; ?><a href="<?php echo CController::createUrl('user/register'); ?>" class="tar_in_reg"><?php echo Yii::t('general','get register'); ?></a>.</div>
			</div>
    </div><!-- tar_in_form -->	
	
 <!-- **************************** start of Recover box ***********************/ -->
 	
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
	<!--  /******************************** end of the Dialog box  *******************/
	//********************** script for the recover popup box **********************//-->
 <?php
   Yii::app()->clientScript->registerScript('dialogs', "
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
	$('#login-back-link').click(function(data){		 
		$('#login-popup').hide(); 
		return false;
	}); 
	", CClientScript::POS_END);
	
endif; ?> 