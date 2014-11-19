<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */
// <script type="text/javascript">
//$(document).ready(function() {
Yii::app()->clientScript->registerScript('search', "
// начально мы скрываем поля банковских реквизитов
	$('#inn-wrapper').hide(); 
	$('#KPP').hide();
	$('#OKPO').hide();
	$('#Bank').hide();
	$('#Bic').hide();
	$('#CorrespondentAccount').hide();
	$('#CurrentAccount').hide();
	
	$('#User_isLegalEntity').on('change', function() 
	{
		var checked = $(this).is(':checked');
		if (checked == true) 
		{ 		
			$('#inn-wrapper').show(); $('#User_INN').val(''); 
			$('#KPP').show();
			$('#OKPO').show();
			$('#Bank').show();
			$('#Bic').show();
			$('#CorrespondentAccount').show();
			$('#CurrentAccount').show();	
		} else { 
			$('#inn-wrapper').hide();						
			$('#KPP').hide();
			$('#OKPO').hide();
			$('#Bank').hide();
			$('#Bic').hide();
			$('#CorrespondentAccount').hide();
			$('#CurrentAccount').hide();		 
		}
	});
");  
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('general','Registration');
 
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) 
{
	 echo '<div class="form" style="background-color: white;" >
				<ul style="list-style-type: none;" class="flashes">';
	 foreach($flashMessages as $key => $message) {
		 echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
	 }
	 echo   '</ul>
			  </div>'; 	 
} else {
?>   
<h2><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', Yii::t('general','Registration'); ?></h2>
<div class="form" style='padding-left:48px;'>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'registration-form', 
			 'enableAjaxValidation'=>false, 
			 'enableClientValidation'=>true, 
		 )); ?>
	 <p class="note"><?php echo Yii::t('general','Fields with');  ?>
	 <span class="required"> * </span><?php echo Yii::t('general','are required')?>
	 </p>
	  
	  <?php echo $form->errorSummary($model);  ?>
		 <table>
		 <tr><td width='250' class='top'>	 
			 
			<?php echo $form->label($model,'isLegalEntity'); ?>
			<?php  echo $form->checkBox($model,'isLegalEntity'); ?>	
			<?php echo $form->error($model,'isLegalEntity'); ?> 
			
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
		 <td  width='280' class='top'>
		    <label><?php echo Yii::t('general','User name'); ?></label>
			<?php // echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username', array('size'=>'28')); ?>
			<?php echo $form->error($model,'username'); ?>			
			
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone', array('size'=>'28')); ?>
			<?php echo $form->error($model,'phone'); ?>
			 
			 <?php echo $form->labelEx($model,'city');   
				//====== ОПРЕДЕЛЕНИЕ ГОРОДА ПО IP  ======					
				$ipus = getenv('REMOTE_ADDR');
				
				//Выбор города
				$Array = CHtml::listData(Cityes::model()->findAll(array('order'=>'Name ASC')), 'Name','Name'); 
				$cities = new Cityes;
				$City = $this->Foccurrence($ipus,'utf-8'); 
				$city1 = Cityes::model()->findbyattributes(array('Name'=>$City));
				if (!empty($city1))	
					$cities->Name=$city1->Name;
				if (!Yii::app()->user->isGuest && !empty(Yii::app()->user->city)) 
					$cities->Name = Yii::app()->user->city; 
					
				$model->city=$cities->Name;					
				$this->widget('ext.select2.ESelect2',array(
						'model'=> $model,
						'attribute'=> 'city', 
						'options'=> array('allowClear'=>true,
								'width' => '225'), 
						'data'=>$Array,
				));  
				echo $form->error($model, 'city'); ?>
			
			<?php echo $form->labelEx($model,'address'); ?>
			<?php echo $form->textArea($model,'address', array('rows'=>2, 'cols'=>31)); ?>
			<?php echo $form->error($model,'address'); ?>
			<br>
		    <?php echo $form->labelEx($model,'agree'); ?>
			<?php echo $form->checkBox($model,'agree'); ?>
			<?php echo $form->error($model, 'agree' ); ?>
			<br> 
			<?php echo CHtml::Link(Yii::t('general', 'Read contract'), '#'   , array('id'=>'operation-conditions')  ); ?> 
			<br><br>
			<?php echo CHtml::submitButton(Yii::t('general','Register'), array('style'=>' padding:2px 5px;', 'class'=>'red')); ?>
		</td>
		<td>
			<div id='inn-wrapper' >	
				<?php echo $form->labelEx($model,'INN'); ?>
				<?php echo $form->textField($model,'INN'); ?>
				<?php echo $form->error($model,'INN'); ?>
			</div>
			<div id='KPP' >	
				<?php echo $form->labelEx($model,'KPP'); ?>
				<?php echo $form->textField($model,'KPP'); ?>
				<?php echo $form->error($model,'KPP'); ?>
			</div>
			<div id='Bic' >	
				<?php echo $form->labelEx($model,'BIC'); ?>
				<?php echo $form->textField($model,'BIC'); ?>
				<?php echo $form->error($model,'BIC'); ?>
			</div>				
			<div id='OKPO' >	
				<?php echo $form->labelEx($model,'OKPO'); ?>
				<?php echo $form->textField($model,'OKPO'); ?>
				<?php echo $form->error($model,'OKPO'); ?>
			</div>					
			<div id='Bank' >	
				<?php echo $form->labelEx($model,'Bank'); ?>
				<?php echo $form->textArea($model,'Bank', array('rows'=>2, 'cols'=>30)); ?>
				<?php echo $form->error($model,'Bank'); ?>
			</div>				
			<div id='CorrespondentAccount' >	
				<?php echo $form->labelEx($model,'CorrespondentAccount'); ?>
				<?php echo $form->textField($model,'CorrespondentAccount'); ?>
				<?php echo $form->error($model,'CorrespondentAccount'); ?>
			</div>
			<div id='CurrentAccount' >	
				<?php echo $form->labelEx($model,'CurrentAccount'); ?>
				<?php echo $form->textField($model,'CurrentAccount'); ?>
				<?php echo $form->error($model,'CurrentAccount'); ?>
			 </div>	
		 </td>
	</tr>
	</table>
		<?php $this->endWidget(); ?>
	</div><!-- form -->
<?php  
/********************************** start of the Dialog box ******************************/ 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'operation',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>Yii::t('general','Operation Conditions'),
        'autoOpen'=>false,
    )
));
echo '<br>' , $model->operationCondition; 
$this->endWidget('zii.widgets.jui.CJuiDialog');
 
// script for the popup
$url = $this->createUrl('operationcondition');
Yii::app()->clientScript->registerScript('dialog', "
/*
function validateForm() {
    var x = document.forms['registration-form']['agree'].value;
    if (x == null || x == '') {
        alert('You must agree with operation conditions');
        return false;
    }
}
*/
$('#operation-conditions').click(function(data){
 	$('#operation').dialog('open'); 
	return false;
});", CClientScript::POS_END); 
/******************************** end of the Dialog box ***********************************/
} // end of if($flashMessages)
?>