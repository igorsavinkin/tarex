<?php
Yii::app()->clientScript->registerScript('group-discount-script', "
	$('.group-discount-button').click(function(){
		$('.group-discount-form').toggle();
		return false;
	});
/*	$('.search-form form').submit(function(){
		$('#events-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});*/
	"); 
	  
Yii::app()->clientScript->registerScript('legal-fields', "
$( document ).ready(function() {
    if (!$('#User_isLegalEntity').is(':checked') && ($('#User_PaymentMethod').val() != '1' )   ) 
    { 
		$('#bankdata-wrapper').hide(); 
	}
});
	
$('#User_isLegalEntity, #User_PaymentMethod').on('change', function() {
		var checked = ( $(this).is(':checked') || (1 == $('#User_PaymentMethod').val()) ) ;
		if (checked == true) 	
			$('#bankdata-wrapper').show();  		
		else 
			$('#bankdata-wrapper').hide();   
});
"); ?>
<fieldset>
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			 'id'=>'user-update-form', 
			 'enableAjaxValidation'=>false, 
		 )); ?>
	<p class="note"><?php echo Yii::t('general','Fields with');  ?>
	<span class="required"> * </span><?php echo Yii::t('general','are required')?>
	</p>
	  
	<?php echo $form->errorSummary($model); ?>
	<table>
		 <tr><td class='top'>		
		<?php echo $form->labelEx($model,'username');?>
		<!--label><?php // это поле переименовываем в 'Client id'Клиентский номер	
		echo Yii::t('general','Client id');?></label--> 
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?> 
		
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email', array('size'=>25)); ?>
		<?php echo $form->error($model, 'email'); ?>
		
		<?php echo $form->labelEx($model,'phone'); ?> 
		<?php echo $form->textField($model,'phone'); ?>
		<?php echo $form->error($model,'phone'); ?>	
		
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->textField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?> 
		 
		<?php echo $form->labelEx($model, 'role'); 
				   if(Yii::app()->user->role < $model->role OR !isset($model->role)) 
					{ 
						$this->widget('ext.select2.ESelect2',array(
							'model'=> $model,
							'attribute'=> 'role', 
							'data'=> CHtml::listData(UserRole::model()->findAll(array('order'=>'Name ASC', 'condition'=>'id >' . Yii::app()->user->role)), 'id','name'),
							'options'=> array('allowClear'=>true, 'width' => '200',
							),                 
						));  
					 } 
					 else 
						echo UserRole::model()->findByPk($model->role)->name, '<br>'; 
		?> 
		 
		<?php echo $form->label($model,'isLegalEntity'); ?>
		<?php echo $form->checkBox($model,'isLegalEntity'); ?>	
		<?php echo $form->error($model,'isLegalEntity'); ?> 
		
		<?php echo $form->label($model,'isActive'); ?>
		<?php 
		if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
		{ 
			echo $form->checkBox($model,'isActive');  
			echo $form->error($model,'isActive'); 
		} else  
			echo $model->isActive ? Yii::t('general','yes') : Yii::t('general','no');
		
		
		echo '<br>', CHtml::Link(Yii::t('general','Print user info'), array('print', 'id'=>$model->id), array('class'=>'btn-win', 'target'=>'_blank'));
?> 
	 </td>
	 <td class='top padding10side' >  
		
		<?php echo $form->labelEx($model,'city'); 
			$this->widget('ext.select2.ESelect2',array(
				'model'=> $model,
				'attribute'=> 'city', 
				'data'=> CHtml::listData(Cityes::model()->findAll(array('order'=>'Name ASC')), 'Name','Name'),
				'options'=> array('allowClear'=>true,
						'width' => '200',
				),                 
			)); ?>  
		<?php echo '<br><font style="color:gray">', Yii::t('general', 'add your city if you cannot find it in the above dropdown list:'), '</font><br>'; ?>
		<?php echo $form->textField($model,'city_new'); ?>
		<?php echo $form->error($model, 'city_new'); ?> 
		
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>2, 'cols'=>30));  ?>
		<?php echo $form->error($model,'address'); ?>
		
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array('rows'=>2, 'cols'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
		
		<?php echo $form->labelEx($model,'AccountantName'); ?>
		<?php echo $form->textField($model,'AccountantName'); ?>
		<?php echo $form->error($model,'AccountantName'); ?>

		<?php /* echo $form->labelEx($model,'discount'); ?>
		<?php 
			if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
				{  
					echo $form->textField($model,'discount');  
					echo $form->error($model,'discount'); 
				} else 
					echo $model->discount;  */ 
		?>
		
<?php if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
		{ ?> 
		<?php echo $form->label($model,'isEmployee'); ?>
		<?php echo $form->checkBox($model,'isEmployee'); ?>	
		<?php echo $form->error($model,'isEmployee'); ?> 	
		
		<?php echo $form->label($model,'isCustomer'); ?>
		<?php echo $form->checkBox($model,'isCustomer'); ?>	
		<?php echo $form->error($model,'isCustomer'); ?> 		
		
		<?php echo $form->label($model,'isSeller'); ?>
		<?php echo $form->checkBox($model,'isSeller'); ?>	
		<?php echo $form->error($model,'isSeller'); 		
		} ?> 
		<br><br>
		<?php 
			$plsId = PriceListSetting::model()->findByAttributes(array('userId'=>$model->id))->id;
		if ($plsId)  
			echo CHtml::link(Yii::t('general','Set up Price sending'), array('priceListSetting/update', 'id'=>$plsId), array('target'=>'_blank', 'class'=>'btn-win'));
		else 
			echo CHtml::link(Yii::t('general','Set up Price sending'), array('priceListSetting/create', 'id'=>$model->id), array('target'=>'_blank', 'class'=>'btn-win'));?>
	</td> 
	<td valign='top' >		
		<?php  
		if(Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
		{ 
			echo $form->label($model,'organization'); 
			$this->widget('ext.select2.ESelect2',array(
				'model'=> $model,
				'attribute'=> 'organization', 
				'data'=> CHtml::listData(Organization::model()->findAll(array('order'=>'Name ASC')), 'id','name'),
				'options'=> array('allowClear'=>true,
						'width' => '200',
				),                 
			)); 
			echo $form->error($model,'Organization'); 
		} ?> 
	<label><?php // личный менеджер	
		echo Yii::t('general','Manager');?></label>
	<?php  
		if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
		{ 			
			$criteria = new CDbCriteria; 			  
			$criteria->condition = 'role IN ('. User::ROLE_MANAGER . ',' . User::ROLE_SENIOR_MANAGER . ') AND organization = '. Yii::app()->user->organization;
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'parentId',
				'data' => CHtml::listData(User::model()->findAll($criteria),  'id','username'),
				'options'=> array('allowClear'=>true, 
					'width' => '200', 
					'placeholder' => '', 
					),
			));    
		} else 
			echo (!empty(User::model()->findByPk($model->parentId)->username)) ? User::model()->findByPk($model->parentId)->username : '-';
	 
		if(Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
		{ 
			echo $form->labelEx($model,'Group');  
			$criteria = new CDbCriteria; 
			$criteria->order = 'name ASC'; 
			if(!Yii::app()->user->checkAccess(User::ROLE_ADMIN))  
				$criteria->condition = 'organizationId = ' . User::model()->findByPk(Yii::app()->user->id)->organization;
			$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'Group',
				'data' => CHtml::listData(UserGroup::model()->findAll($criteria), 'id','name'),
				'options'=> array('allowClear'=>true, 
					'width' => '200', 
					'placeholder' => '', 
					),
			));   
			echo $form->error($model,'Group'); 
		} ?>		 
	
		<?php echo $form->labelEx($model,'PaymentMethod'); ?>
		<?php  $this->widget('ext.select2.ESelect2',array(
			'attribute' => 'PaymentMethod',
			'model'=> $model,
			'options'=> array('allowClear'=>true, 'width' => '200'  ),
			'data'=>CHtml::listData(PaymentMethod::model()->findAll(), 'id', Yii::t('general','name') ),
			));  ?>
		<?php echo $form->error($model,'PaymentMethod'); ?>
	 
		<?php echo $form->labelEx($model,'ShippingMethod'); ?>
		<?php  $this->widget('ext.select2.ESelect2',array(
			'attribute' => 'ShippingMethod',
			'model'=> $model,
			'options'=> array('allowClear'=>true, 'width' => '200'), 
			'data'=>CHtml::listData(ShippingMethod::model()->findAll(), 'id', Yii::t('general','name') ),
			));  ?> 
		<?php echo $form->error($model,'ShippingMethod'); ?>
		
		<?php echo $form->labelEx($model,'scopeOfActivity'); ?>
		<?php  $this->widget('ext.select2.ESelect2',array(
			'attribute' => 'scopeOfActivity',
			'model'=> $model,
			'options'=> array('allowClear'=>true, 'width' => '200'), 
			'data'=>CHtml::listData(ScopeOfActivity::model()->findAll(array('order'=>'id')), 'id',  'trName' ),
			));  ?> 
		<?php echo $form->error($model,'scopeOfActivity');  ?>
		
		<?php echo $form->labelEx($model,'ShablonId'); ?>
		<?php $Array = CHtml::listData(LoadDataSettings::model()->findAll(array('order'=>'TemplateName ASC')), 'id','TemplateName');
			$this->widget('ext.select2.ESelect2',array(
				'model'=> $model,
				'attribute'=> 'ShablonId',
				'data'=>$Array,
				'options'=> array('allowClear'=>false,
						'width' => '200')              
				));?>
		<?php echo $form->error($model,'ShablonId'); ?><br> 			
		<?php echo CHtml::link(Yii::t('general','Edit loading settings'), array('LoadDataSettings/admin'), array('target'=>'_blank'));  ?>
		<br>
		<?php     
// cписок марок машин с которыми пользователь работает		
		$criteria=new CDbCriteria;
		$criteria->select='make';
		$criteria->distinct=true;
		$criteria->order='make ASC';
		$criteria->condition='make<>"" ';
		$makes = CHtml::listData(Assortment::model()->findAll($criteria), 'make', 'make'); 
		
		echo $form->labelEx($model,'carMakes');  
		$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
			'model' => $model,
			'dropDownAttribute' => 'carMakes',     
			'data' => $makes,
			'dropDownHtmlOptions'=> array(
				'style'=>'width:160px;',
			'options'=>array(
				'click'=>'function(e){alert("click");}','width'=>'160px',	'style'=>'width:160px;',
				),
			),
		));
		if ($model->carMakes) 
		{
			
			if (count($makes) == count($model->carMakes)) 
				echo '<b style="text-transform: uppercase;">&nbsp;', Yii::t('general','All makes'), '</b>';
			else 	{
				echo '<div style="float:left;width:235px;background: #9BDBF6;color: #344756;">';	
			    foreach($model->carMakes as $make)
					echo '<div style="float:left;width:65px;padding-right:5px;margin:4px 5px;">' ,  $make, '</div>';				
			 	echo '</div>'; 
			}
		
		}
		?>		
	</td> 
	<td style='padding-left:5px;'>
		<div id='bankdata-wrapper' >	
			<p class='note' style='border:1px solid red; color:red; padding: 3px; display:<?php echo $bankdataDisplay='block'; ?>; '><?php echo Yii::t('general', 'With cashless payment method or if you are legal entity you must fill banking data down.'); ?> 
			</p>  
			<?php  echo $form->labelEx($model,'OrganizationInfo'); ?> 
			<?php echo $form->textArea($model,'OrganizationInfo', array('rows'=>3,'cols'=>22)); ?>
			<?php echo $form->error($model,'OrganizationInfo'); ?>
		
			<?php echo $form->labelEx($model,'INN'); ?>
			<?php echo $form->textField($model,'INN'); ?>
			<?php echo $form->error($model,'INN'); ?>
	
			<?php echo $form->labelEx($model,'KPP'); ?>
			<?php echo $form->textField($model,'KPP'); ?>
			<?php echo $form->error($model,'KPP'); ?>
	
			<?php echo $form->labelEx($model,'BIC'); ?>
			<?php echo $form->textField($model,'BIC'); ?>
			<?php echo $form->error($model,'BIC'); ?>
	
			<?php echo $form->labelEx($model,'Bank'); ?>
			<?php echo $form->textArea($model,'Bank', array('rows'=>2, 'cols'=>'30')); ?>
			<?php echo $form->error($model,'Bank'); ?>
		
			<?php echo $form->labelEx($model,'CorrespondentAccount'); ?>
			<?php echo $form->textField($model,'CorrespondentAccount'); ?>
			<?php echo $form->error($model,'CorrespondentAccount'); ?>
	
			<?php echo $form->labelEx($model,'CurrentAccount'); ?>
			<?php echo $form->textField($model,'CurrentAccount'); ?>
			<?php echo $form->error($model,'CurrentAccount'); ?>
		</div>			
		
	</td> 
	</tr>
	
	<tr><td colspan=4>
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textField($model,'notes',array('size'=>100)); ?>
		<?php echo $form->error($model,'notes'); ?>
		<br>

			</div><!-- group-discount-form -->
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save') , array( 'class'=>'red')); ?>

		
		
	</td></tr>
	
	
	
	</table>
		<?php $this->endWidget(); ?>
		<?php echo CHtml::link(Yii::t('general', 'Discount Groups') . ' ' . '(показать/скрыть)' ,'#',array('class'=>'group-discount-button')); ?>
	    <br>
	    <div class="group-discount-form" style="display:none">
		<?php $this->renderPartial('_discount_groups',array(
			'model'=>$model, 'userGroupDiscount' => $userGroupDiscount
		)); ?>	
	</div><!-- form -->
	
 </fieldset>  

