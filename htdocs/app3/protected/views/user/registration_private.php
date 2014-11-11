<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */
// <script type="text/javascript">
//$(document).ready(function() {
Yii::app()->clientScript->registerScript('search', "

$('#User_isLegalEntity').on('change', function() {
		var checked = $(this).is(':checked');
		if (checked == true) { $('#inn-wrapper').show(); $('#User_INN').val(''); }
		else { $('#inn-wrapper').hide(); $('#User_INN').val('0'); }
		}); 

"); 
 
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('general','Registration');
// $this->breadcrumbs=array(
	// Yii::t('general','Registration'),
// );
  
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) :
	echo '<ul style="list-style-type: none;" class="flashes">';
	foreach($flashMessages as $key => $message) {
		echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
	}
	echo '</ul>'; 	 
else:  

?> 
<!--**************************** start of the register popup box **********************-->

<!---div id='registration-popup'!--->  
	 
	<h2><?php echo Yii::t('general','Registration'); ?>
		<?php echo CHtml::Link('', array('site/index') ,array('class'=>'close-btn')); ?></h2>
	<fieldset>
		<div class="form">
			<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'registration-form',
				//'enableClientValidation'=>true, 
				//'clientOptions'=>array(
				  // 'validateOnSubmit'=>true,
				 'enableAjaxValidation'=>false,
			   //),
			 )); ?>
			 <p class="note"><?php echo Yii::t('general','Fields with');  ?>
			<span class="required"> * </span><?php echo Yii::t('general','are required')?>
			</p>
		  
		  <?php echo $form->errorSummary($model); ?>
			 <table>
			 <tr><td width='250' class='top'>		
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model, 'email'); ?>
			
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
			
			<?php echo $form->labelEx($model,'password_repeat'); ?>
			<?php echo $form->passwordField($model,'password_repeat'); ?>
			<?php echo $form->error($model,'password_repeat'); ?>
		 
			
		 
			<?php 
			if(CCaptcha::checkRequirements()) {  ?>
				<?php echo $form->labelEx($model,'verifyCode'); ?>
				<?php $this->widget('CCaptcha'); ?>
				 <?php echo $form->error($model,'verifyCode');  ?>
				 <?php echo $form->textField($model,'verifyCode');  ?>
				 <br/><?php echo Yii::t('general','Enter letters of the picture</br> Letters are case insensitive.');  
			 } ?><!-- end "if" for CCaptcha::checkRequirements()-->
			
			 </td>
			 <td class='top'>
			 <?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
			 
			 <?php echo $form->labelEx($model,'city'); ?>
			<?php echo $form->textField($model,'city'); ?>
			<?php echo $form->error($model, 'city'); ?>
			
			<?php echo $form->labelEx($model,'address'); ?>
			<?php echo $form->textField($model,'address'); ?>
			<?php echo $form->error($model,'address'); ?>
		 <br>

			
			</br></br>
			
			<!--div class="row buttons"-->
					<?php echo CHtml::submitButton(Yii::t('general','Register'), '' ,array('style'=>'float:right;padding:2px 5px;', 'class'=>'red')); ?>
			<!--/div-->
			 </td></tr>
			 </table>
			<?php $this->endWidget(); ?>
		</div><!-- form -->
	 </fieldset>
   
<!---/div!---><!-- id='registration-popup' -->
 
<?php 
endif; // end if (Yii::app()->user->hasFlash('registration')) 
?>
<style>
#registration-popup {
	color: #222;
    position:absolute; 
	border: 2px solid #b00000;
	background: #eee; 
	/*padding: 15px; */
	padding: 0px;
	top:50%; 
	left:50%; 
	margin-top: -220px; /* Half the height */
    margin-left: -250px; /* Half the width */
	z-index:101; 
	border-radius: 8px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px; 	
	font-size:1.0em; 
	opacity:0.95;
	filter: alpha(opacity=95);
} 
#registration-popup input 
{ 
	/*height: 1.5em; */
	font-size: 1.0em;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
} 
#registration-popup h2
{
	background: #b00000;
	padding: 15px;
}
#registration-popup fieldset
{
	padding: 0px 15px;  
	
}
a.close-btn {
	position: absolute;
	background-image: url(images/close.png);
	background-repeat: no-repeat;
	background-position: center center;
	height: 35px;
	width: 35px;
	text-indent: -99999px;
	outline: none;
	top: 9px;
	right: 9px;
}
td.top {
	vertical-align: top;
}
div.form .errorSummary
{
	background: #444;
}
</style>



