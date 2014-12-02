<?php $form=$this->beginWidget('CActiveForm', array(
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>	 

<div class="form">
	<?php 	echo $form->hiddenField($model,'id'); ?>
<table>
<tr>
<td colspan=4>
<?php  echo $form->labelEx($model,'title'); 
			echo $form->textField($model,'title',array('size'=>130)); 		
			echo $form->error($model,'title'); 
?> 
</td>
</tr><tr>
<td width='200'>
<?php echo $form->labelEx($model,'model'); 
	echo $form->textField($model,'model'); 		
 echo $form->error($model,'model'); ?>
</td>
<td width='200'>
<?php echo $form->labelEx($model,'make'); 
		$criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->order = 'make ASC';
		$criteria->select = array('make');
		//$criteria->condition =  'subgroup <> "" ';
		//$subs = Assortment::model()->findAll($criteria); 
		$this->widget('ext.select2.ESelect2',array(
			'model'=> $model,
			'attribute'=> 'make',
			'options'=> array('allowClear'=>true,
					'width' => '200',
			),
			'data'=>CHtml::listData(Assortment::model()->findAll($criteria),'make','make'),
		));	
	//echo $form->textField($model,'make'); 		
 echo $form->error($model,'make'); ?>
</td>

<td width='200'>
<?php echo $form->labelEx($model, 'warehouse'); 
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

<td>
<?php echo $form->labelEx($model,'article'); 
	echo $form->textField($model,'article'); 		
 echo $form->error($model,'article'); ?>
 
</td>
</tr><tr>
<td >
<?php echo $form->labelEx($model,'priceS'); 
	echo $form->textField($model,'priceS'); 		
 echo $form->error($model,'priceS'); ?>
 
</td><td>

<?php echo $form->labelEx($model,'manufacturer'); 
	    $criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->order = 'manufacturer ASC';
		$criteria->select = array('manufacturer');
		//$criteria->condition =  'subgroup <> "" ';
		//$subs = Assortment::model()->findAll($criteria); 
		$this->widget('ext.select2.ESelect2',array(
			'model'=> $model,
			'attribute'=> 'manufacturer',
			'options'=> array('allowClear'=>true,
					'width' => '200',
			),
			'data'=>CHtml::listData(Assortment::model()->findAll($criteria),'manufacturer','manufacturer'),
		));	
//	echo $form->textField($model,'manufacturer'); 		
 echo $form->error($model,'manufacturer'); ?>
 
</td><td>
<?php echo $form->labelEx($model,'organizationId');  	 
	$this->widget('ext.select2.ESelect2',array(
		'model'=> $model,
		'attribute'=> 'organizationId',
		'options'=> array('allowClear'=>true,
				'width' => '190',
		),
		'data'=>CHtml::listData(Organization::model()->findAll(),'id','name'),
	));	
	echo $form->error($model,'organizationId'); ?>
</td>

<td>
<?php echo $form->labelEx($model,'oem'); 
	echo $form->textField($model,'oem'); 		
 echo $form->error($model,'oem'); ?>
 
</td>
</tr><tr>
<td >
<?php echo $form->labelEx($model,'availability'); 
	echo $form->textField($model,'availability'); 		
 echo $form->error($model,'availability'); ?>

</td><td>
<?php echo $form->labelEx($model,'subgroup'); 
		// echo Yii::t('general','SubGroup'), '</br>';
					$this->widget('ext.select2.ESelect2', array(
						'model' => $model,
						'attribute' => 'groupCategory',     
						'data' => Category::getCategoryLocale(),    
						'options'=> array('allowClear'=>true, 
							'width' => '200', 
				 			'placeholder' => ''), 
					)); 
		/*$criteria = new CDbCriteria;
		$criteria->distinct = true;
		$criteria->order = 'subgroup ASC';
		$criteria->select = array('subgroup');
		//$criteria->condition =  'subgroup <> "" ';
		//$subs = Assortment::model()->findAll($criteria); 
		$this->widget('ext.select2.ESelect2',array(
			'model'=> $model,
			'attribute'=> 'subgroup',
			'options'=> array('allowClear'=>true,
					'width' => '180',
			),
			'data'=>CHtml::listData(Assortment::model()->findAll($criteria),'subgroup','subgroup'),
		));	*/
	//echo $form->textField($model,'subgroup'); 		
 echo $form->error($model,'subgroup'); ?>

</td><td>
<?php echo $form->labelEx($model,'Currency'); 
	$this->widget('ext.select2.ESelect2',array(
			'model'=> $model,
			'attribute'=> 'Currency',
			'options'=> array('allowClear'=>true,
					'width' => '100',
			),
			'data'=>CHtml::listData(Currency::model()->findAll(),'name','name'),
	));  		
	echo $form->error($model,'Currency'); ?>
	
 </td><td>
<?php echo $form->labelEx($model,'ItemPosition'); 
	echo $form->textField($model,'ItemPosition'); 		
 echo $form->error($model,'ItemPosition'); ?> 
    
 </td>
 </tr><tr valign='top'>
 <td>
	<?php echo $form->labelEx($model,'SchneiderN'); 
		echo $form->textField($model,'SchneiderN'); 		
		echo $form->error($model,'SchneiderN'); 
		$message = Yii::t('general', 'Please select one item in the \"Make\" field');
		if ($model->SchneiderN=='') 
			echo '<br>', CHtml::ajaxButton( Yii::t('general', 'Generate Schneider number'), array('generateSchneiderNb'), array( 'type'=> 'POST', 
				 'beforeSend'=>'js:function(){  	 
				 // мы проверяем не пусто ли поле Make чтобы его использовать для генерации Schneider Nr
						if($("#Assortment_make").val()=="") 
						{						    
						 	//$("#s2id_Assortment_make").attr("style", "border: 2px solid red");
						 	$("#s2id_Assortment_make").css({"border": "2px solid red"});						 
						 	alert("' . $message . '");
							return false;
						}						 
					}',		 
					'complete' =>'js:function(data){		$("input#Assortment_SchneiderN").val(data.responseText); }',),
					array('id'=>'generate-shcnNb-btn', 'class'=>'red'));
		?> 
 </td><td>
	<?php echo $form->labelEx($model,'SchneiderOldN'); 
		echo $form->textField($model,'SchneiderOldN'); 		
	 echo $form->error($model,'SchneiderOldN'); 
	 if ($model->SchneiderOldN=='')
		echo  '<br>', CHtml::ajaxButton( Yii::t('general', 'Generate old Schneider number'), array('generateSchneiderNb', 'old'=>1), array( 'type'=> 'POST',  
					'complete' =>'js:function(data){		$("input#Assortment_SchneiderOldN").val(data.responseText); }',),
					array('id'=>'generate-shcnNb-old-btn', 'class'=>'red'));?> 
 
 </td><td>
	<?php echo $form->labelEx($model,'TradeN'); 
		echo $form->textField($model,'TradeN'); 		
	 echo $form->error($model,'TradeN'); ?>  
  
  </td><td>
<?php echo $form->labelEx($model,'PartN'); 
	echo $form->textField($model,'PartN'); 		
 echo $form->error($model,'PartN'); ?> 
</td>

</tr><tr>
  <td colspan=4>  
<?php echo $form->labelEx($model,'Analogi'); 
	echo $form->textArea($model,'Analogi',array('rows'=>6, 'cols'=>100)); 		
 echo $form->error($model,'Analogi'); ?> 
 
 </td>
 </tr><tr>
 <td colspan=4> 
 <?php echo $form->labelEx($model,'specialDescription'); 
	echo $form->textField($model,'specialDescription',array('size'=>130)); 		
 echo $form->error($model,'specialDescription'); ?>
 
 </td>
</tr><tr> 
 <td colspan=4> 
 <?php echo $form->labelEx($model,'notes'); 
	echo $form->textField($model,'notes',array('size'=>130)); 		
 echo $form->error($model,'notes'); ?> 
 </td>
</tr><tr>  
 <td> 
		<?php echo $form->labelEx($model,'imageUrl'); ?> 
		<?php echo $form->fileField($model,'imageUrl',array('size'=>40,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'imageUrl'); ?>
		<br><br>
		<?php echo CHtml::submitButton( $model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'),  array( 'class'=>'red' )); ?>
 </td>  
 <td>  <?php if ((getimagesize(Yii::app()->basePath. '/../img/foto/'. $model->article2 . '.jpg') !== false) ) : ?>
	<div style="border: 1px solid #344756; margin:0 0 0 0px; padding: 5px;float:right;"> 
	<?php echo CHtml::image(Yii::app()->baseUrl. '/img/foto/'. $model->article2 . '.jpg' , $model->Misc,array("width"=>350 ))?> </div>
	<?php endif;	?>
 </td>  
 <td class='padding10side top'>
		<label><?php echo Yii::t('general','ALT tag to the picture'); ?> </label>
		<?php 	
		if(!$model->Misc)
		{	// формируем тег ALT "на лету" если он пустой
			$model->Misc = $model->title . ' - ' . $model->make . ' - ' . $model->model;
			$model->save(false);
		}
		echo $form->textArea($model,'Misc',array('row'=>6,'cols'=>40)); ?>
		<?php echo $form->error($model,'Misc'); ?>
 </td>
 
</tr></table>



<?php $this->endWidget(); ?>
</div><!-- form -->