<?php
$this->pageTitle = Yii::t('general','Check out');    
Yii::app()->clientScript->registerScript('formScript', "
function ShippingMethodChange(shippingMethod)
{    
    if(1 != shippingMethod) $('.useraddress').show(); else $('.useraddress').hide();
};
function PaymentMethodChange(paymentMethod)
{    
    if(1 == paymentMethod || $('#legalEntityChbox').is(':checked') ) $('.userbankdata').show(); else $('.userbankdata').hide();
};    
", CClientScript::POS_END);
//if ($orderId) echo 'New ', Chtml::LInk('order', array('orders/update', 'id'=>$orderId)), ' is created.<br>';
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) :  
    echo '<ul class="flashes">';
    foreach($flashMessages as $key => $message) {
        echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
    }
    echo '</ul>';	
	//Yii::app()->end(); 
else :
if (Yii::app()->user->role == User::ROLE_USER_RETAIL) 
{
	echo '<h1>' , Yii::t('general','Check out for retail client'), ' <em>', Yii::app()->user->username , '</em></h1>';  
}	
elseif (Yii::app()->user->isGuest)  
{	
	echo '<h1>' , Yii::t('general','Check out for new client'), '</h1><br>';   
	Yii::app()->user->returnUrl = Yii::app()->createUrl($this->route);
	echo '<h3>', Yii::t('general','You might want to') , ' ' , CHtml::link(Yii::t('general','sign in'), CController::createUrl('site/login')) , ' ' , Yii::t('general','or'), ' ' , CHtml::link(Yii::t('general','register'), CController::createUrl('user/register')) , '.</h3>';
	echo  '<h3>',Yii::t('general','I do not want to get register, so, please, check order out by the following credentials:'), '</h3>';
} 
?> 
	<div class="form search-form" >
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
	)); 
		echo $form->errorSummary($user);
		
$addressDisplay = ($user->ShippingMethod == '1') ? 'none' : 'block'; 
$bankdataDisplay = ($user->PaymentMethod == '1' OR $user->isLegalEntity == '1') ?  'block' : 'none' ; 
//echo 'addressDisplay =',  $addressDisplay;
		?>
<table>
<tr>
	<td style='border:1px solid #888; padding: 5px; margin: 5px;'>
		<div class="row"> 
			<?php echo $form->error($user , 'ShippingMethod'); ?>
			<?php echo '<b>', Yii::t('general' , 'Shipping Method'), '</b><br>';  
			 echo $form->radioButtonList($user, 'ShippingMethod', CHtml::listData(ShippingMethod::model()->findall(), 'id', 'name' ) /*array('Page'=>'Page')*/, array('onchange' => 'ShippingMethodChange(this.value);' ,  'template'=>'{label}{input}' , 'separator'=>' ')); ?>   
		</div>
	</td> 
</tr><tr>	
	<td class='useraddress' style= 'display: <?php echo $addressDisplay; ?>;' valign='top'>  
		<?php echo $form->labelEx($user,'address'); // display:none; ?>
		<?php echo $form->textArea($user,'address', array('rows'=>2,'cols'=>30));  ?>
		<?php echo $form->error($user,'address'); ?>
	</td>
	<td class='useraddress' style='width:30px; display: <?php echo $addressDisplay; ?>;'  valign='top'> 
		<?php echo $form->labelEx($user,'city'); ?>
		<?php echo $form->textField($user,'city',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($user,'city'); ?>
	</td>
</tr> 
<tr>
	<td style='border:1px solid #888; padding: 5px; margin: 5px;'>
		<div class="row"> 
	    	<?php echo $form->error($user , 'PaymentMethod'); ?> 
			<?php echo '<b>', Yii::t('general' , 'Payment Method' ), '</b><br>';  
			 echo $form->radioButtonList($user, 'PaymentMethod', CHtml::listData(PaymentMethod::model()->findall(), 'id', 'name' ) , array('onchange' => 'PaymentMethodChange(this.value);' ,  'template'=>'{label}{input}' , 'separator'=>' ')); ?>    
		</div>                    
	</td>  
	<td style='padding: 5px; margin: 5px 5px 25px; valign:bottom'>
		<div class='note userbankdata' style='border:1px solid red; color:red; padding: 3px; display:<?php echo $bankdataDisplay; ?>; '><?php echo Yii::t('general', 'With cashless payment method or if you are legal entity you must fill banking data down.'); ?> 
		</div>
		<?php echo $form->label($user, 'isLegalEntity'); ?>
		<?php echo $form->checkBox($user, 'isLegalEntity', array('id' => 'legalEntityChbox', 'onchange' => 'javascript:if ($(this).is(":checked") ) $(".userbankdata").show(); else if ($("#User_PaymentMethod_1").is(":checked")) $(".userbankdata").hide();  ')); ?>	 
		<?php echo $form->error($user, 'isLegalEntity'); ?> 	
	</td> 
</tr><tr>
	<td valign='top'  width='50px' >  <!-- style='border: 1px solid red; paddign: 5px; margin: 3px;' -->
		<div id='OrganizationInfo' class='userbankdata' style='width:50px; display:<?php echo $bankdataDisplay; ?>;' >	  
			<?php  echo $form->labelEx($user,'OrganizationInfo'); ?> 
			<?php echo $form->textArea($user,'OrganizationInfo', array('rows'=>3,'cols'=>22)); ?>
			<?php echo $form->error($user,'OrganizationInfo'); ?>
		</div>
		<div id='inn-wrapper' class='userbankdata' style='width:50px; display:<?php echo $bankdataDisplay; ?>;' >	
			<?php echo $form->labelEx($user,'INN'); ?>
			<?php echo $form->textField($user,'INN', array('maxlength'=>12)); ?>
			<?php echo $form->error($user,'INN'); ?>
		</div> 
		
	</td><td valign='top'   >	
		<div id='Bic' class='userbankdata' style='width:30px; display:<?php echo $bankdataDisplay; ?>;' >	
			<?php echo $form->labelEx($user,'BIC'); ?>
			<?php echo $form->textField($user,'BIC', array('maxlength'=>9)); ?>
			<?php echo $form->error($user,'BIC'); ?>
		</div>
		
		<div id='KPP' class='userbankdata' style='width:50px; display:<?php echo $bankdataDisplay; ?>;' >	
			<?php echo $form->labelEx($user,'KPP'); ?>
			<?php echo $form->textField($user,'KPP'); ?>
			<?php echo $form->error($user,'KPP'); ?>
		</div> 
		
		<div id='CurrentAccount' class='userbankdata' style='width:50px; display:<?php echo $bankdataDisplay; ?>;' >	
			<?php echo $form->labelEx($user,'CurrentAccount'); ?>
			<?php echo $form->textField($user,'CurrentAccount', array('size'=>40,'maxlength'=>20)); ?>
			<?php echo $form->error($user,'CurrentAccount'); ?>
		</div>	
		<?php /*   
		<!--div id='OKPO' class='userbankdata' style='width:30px; display: <?php  echo $bankdataDisplay; ?>;' >	
			<?php echo $form->labelEx($user,'OKPO'); ?>
			<?php echo $form->textField($user,'OKPO'); ?>
			<?php echo $form->error($user,'OKPO'); 
		</div-->		*/	?>
	</td><td  valign='top'  >	
		<div id='Bank' class='userbankdata' style='width:50px; display:<?php echo $bankdataDisplay; ?>;' >	
			<?php echo $form->labelEx($user,'Bank'); ?>
			<?php echo $form->textArea($user,'Bank', array('rows'=>3,'cols'=>30)); ?>
			<?php echo $form->error($user,'Bank'); ?>
		</div>			
			
		<div id='CorrespondentAccount' class='userbankdata' style='width:50px; display:<?php echo $bankdataDisplay; ?>;' > 	
			<?php echo $form->labelEx($user,'CorrespondentAccount'); ?>
			<?php echo $form->textField($user,'CorrespondentAccount', array('size'=>40,'maxlength'=>20)); ?>
			<?php echo $form->error($user,'CorrespondentAccount'); ?>
		</div>
 
				
	</td> 
</tr> 
<tr>
	<td style='width:30px' valign='top'  >
		<?php echo $form->labelEx($user,'username'); ?>
		<?php echo $form->textField($user,'username',array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($user,'username'); ?>
	</td>
	
	<td style='width:30px' valign='top'  class='padding5side' >
		<?php echo $form->labelEx($user, 'email' ); ?>
		<?php echo $form->textField($user,'email', array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($user, 'email'); ?>
	</td>
	
	<td style='width:30px' valign='top'  >
		<?php echo $form->labelEx($user, 'phone' ); ?>
		<?php echo $form->textField($user,'phone', array('size'=>30,'maxlength'=>255)); ?>
		<?php echo $form->error($user, 'phone'); ?>
	</td>
</tr><tr>   
	<!--td style='width:30px' class='top'>
		<?php //echo CHtml::submitButton(Yii::t('general','Make order'), array('name'=>'makeorder', 'class'=>'red')), '</br>', Yii::t('general','The cart content will be formed as new order and you might review and change its content'); ?>
	</td-->
	<td style='width:60px' class='top' colspan='2'>
		<?php echo CHtml::submitButton(Yii::t('general','Check out'), array('name'=>'checkout', 'class'=>'red')), ' ', Yii::t('general','When pressing button "Check out" you cannot change order\'s content'); ?>.
	</td>
</tr></table>

	<?php $this->endWidget(); ?> 

	</div><!-- form -->
<br>
<?php echo CHtml::link(Yii::t('general', Yii::t('general',"Back to Cart")) , array('cart'), array('class'=>'btn-win no-print' /*, 'style' => 'float:right;'*/ ));  
endif; // end if($flashMessages) 
?>