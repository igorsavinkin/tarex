<?php $form=$this->beginWidget('CActiveForm', array(
	'enableAjaxValidation'=>false,
)); ?>	 

<div class="form">
	<?php 	echo $form->hiddenField($model,'id'); ?>
<table>
<tr>
<td colspan=3>
<?php echo $form->labelEx($model,'title'); 
	echo $form->textField($model,'title',array('size'=>150)); 		
 echo $form->error($model,'title'); ?>
</td>
</tr><tr>

<td>
<?php echo $form->labelEx($model,'model'); 
	echo $form->textField($model,'model'); 		
 echo $form->error($model,'model'); ?>
</td>
<td>
<?php echo $form->labelEx($model,'make'); 
	echo $form->textField($model,'make'); 		
 echo $form->error($model,'make'); ?>
</td>

<td>

<?php echo $form->labelEx($model,'warehouse'); 
	echo $form->textField($model,'warehouse'); 

  /*$ArrayWarehouse = CHtml::listData(Warehouse::model()->findAll(),'id','name');
        $this->widget('ext.select2.ESelect2',array(
                'model'=> $model,
                'attribute'=> 'warehouseId',
                //'name' => 'СolumnSearch',
                'options'=> array('allowClear'=>true,
                        'width' => '200',
                ),
                'data'=>$ArrayWarehouse,
        ));*/

		
 echo $form->error($model,'warehouse'); ?>
</td>


</tr><tr>
<td>

<?php echo $form->labelEx($model,'article'); 
	echo $form->textField($model,'article'); 		
 echo $form->error($model,'article'); ?>
</td><td>
<?php echo $form->labelEx($model,'priceS'); 
	echo $form->textField($model,'priceS'); 		
 echo $form->error($model,'priceS'); ?>
</td><td>
<?php echo $form->labelEx($model,'oem'); 
	echo $form->textField($model,'oem'); 		
 echo $form->error($model,'oem'); ?>
</td><td>
<?php echo $form->labelEx($model,'organizationId'); 
	//echo $form->textField($model,'organizationId'); 		
	    $ArrayOrganization = CHtml::listData(Organization::model()->findAll(),'id','name');
        $this->widget('ext.select2.ESelect2',array(
                'model'=> $model,
                'attribute'=> 'organizationId',
                //'name' => 'СolumnSearch',
                'options'=> array('allowClear'=>true,
                        'width' => '200',
                ),
                'data'=>$ArrayOrganization,
        ));
	
 echo $form->error($model,'organizationId'); ?>
</td>
</tr><tr>
<td>
<?php echo $form->labelEx($model,'manufacturer'); 
	echo $form->textField($model,'manufacturer'); 		
 echo $form->error($model,'manufacturer'); ?>
</td><td>
<?php echo $form->labelEx($model,'availability'); 
	echo $form->textField($model,'availability'); 		
 echo $form->error($model,'availability'); ?>

 </td><td>
<?php echo $form->labelEx($model,'subgroup'); 
	echo $form->textField($model,'subgroup'); 		
 echo $form->error($model,'subgroup'); ?>

 </td><td>

<?php echo $form->labelEx($model,'Currency'); 
	  $CurrencyArray = CHtml::listData(Currency::model()->findAll(),'name','name');
        $this->widget('ext.select2.ESelect2',array(
                'model'=> $model,
                'attribute'=> 'Currency',
                //'name' => 'СolumnSearch',
                'options'=> array('allowClear'=>true,
                        'width' => '200',
                ),
                'data'=>$CurrencyArray,
        ));  		
		echo $form->error($model,'Currency'); ?>
 </td>
 </tr><tr>
 <td>
	<?php echo $form->labelEx($model,'SchneiderN'); 
		echo $form->textField($model,'SchneiderN'); 		
		echo $form->error($model,'SchneiderN'); 
		if ($model->SchneiderN=='') 
			echo ' ', CHtml::ajaxButton( Yii::t('general', 'Generate Schneider number'), array('generateSchneiderNb2'), array( 'type'=> 'POST',  					
					'complete' =>'js:function(data){		$("input#Assortment_SchneiderN").val(data.responseText); }',),
					array('id'=>'generate-shcnNb-btn', 'class'=>'red'));
		?> 
 </td><td>
	<?php echo $form->labelEx($model,'SchneiderOldN'); 
		echo $form->textField($model,'SchneiderOldN'); 		
	 echo $form->error($model,'SchneiderOldN'); 
	 if ($model->SchneiderOldN=='')
		echo ' ', CHtml::ajaxButton( Yii::t('general', 'Generate old Schneider number'), array('generateSchneiderNb2', 'old'=>1), array( 'type'=> 'POST',  
					'complete' =>'js:function(data){		$("input#Assortment_SchneiderOldN").val(data.responseText); }',),
					array('id'=>'generate-shcnNb-old-btn', 'class'=>'red'));?> 
 
 </td><td>
	<?php echo $form->labelEx($model,'TradeN'); 
		echo $form->textField($model,'TradeN'); 		
	 echo $form->error($model,'TradeN'); ?>  
  
  </td><td >
<?php echo $form->labelEx($model,'PartN'); 
	echo $form->textField($model,'PartN'); 		
 echo $form->error($model,'PartN'); ?> 
 
 </td><td >
<?php echo $form->labelEx($model,'ItemPosition'); 
	echo $form->textField($model,'ItemPosition'); 		
 echo $form->error($model,'ItemPosition'); ?> 
    
  </td>
</tr><tr>
  <td colspan='3'>  
<?php echo $form->labelEx($model,'Analogi'); 
	echo $form->textArea($model,'Analogi',array('rows'=>6, 'cols'=>100)); 		
 echo $form->error($model,'Analogi'); ?> 
 
 </td>
 </tr><tr>
 <td colspan=3> 
 <?php echo $form->labelEx($model,'specialDescription'); 
	echo $form->textField($model,'specialDescription',array('size'=>150)); 		
 echo $form->error($model,'specialDescription'); ?>
 
 </td>
</tr><tr> 
 <td colspan=3> 
 <?php echo $form->labelEx($model,'notes'); 
	echo $form->textField($model,'notes',array('size'=>150)); 		
 echo $form->error($model,'notes'); ?>
 
 </td>
</tr></table>

<?php

 echo CHtml::submitButton(  Yii::t('general','Save'),  array( 'class'=>'red' )); 
// echo CHtml::submitButton(  Yii::t('general','Save') ); 
 $this->endWidget();
// echo CHtml::endForm();	 
		
		
?>
</div><!-- form -->