<h1><?php echo Yii::t('general', 'Sent invitation to client to the page with the given assortment'); ?></h1>
<?php 
/* $model - Assortment model */
/*$form=$this->beginWidget('CActiveForm', array(
	'enableAjaxValidation'=>true,
	//'enableClientValidation'=>true,
)); */ 

?>	 
<div class='form'><br><h3><?php echo Yii::t('general', 'Client') , ': ' , $client->name ? $client->name : $client->username; ?></h3>
<table><tr>
	<td width='200'>
	
	<?php  echo CHtml::form();
				echo Yii::t('general', 'Enter a particular page url'), '<br>';
	            echo CHtml::textField('url', '' ,  array('size'=>70));  
	
	/* echo $form->labelEx($model,'model'); 
		    $criteriaM = new CDbCriteria;
			$criteriaM->distinct = true;
			$criteriaM->order = 'model ASC';
			$criteriaM->select = array('model');
			$models = Assortment::model()->findAll($criteriaM);
			foreach($models as $m)
			{
				$e = explode(' ', $m->model)[0];
				$arr[$e] = $e;
			}
			$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
				'model' => $model,
				'dropDownAttribute' => 'model',     
				'data' => $arr, //CHtml::listData(Assortment::model()->findAll($criteriaM),'model','model'),
				'dropDownHtmlOptions'=> array(
					'style'=>'width:160px;',
				'options'=>array(
					//'click'=>'function(e){alert("click");}','width'=>'160px',	'style'=>'width:160px;',
					),
				),
			)); 
		  //echo $form->textField($model,'model'); 		
		 echo $form->error($model,'model'); ?>
	</td> 
	<td class='padding10side' >
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
	 echo $form->error($model,'make');*/  
	 ?>
	</td>
</tr><tr>
	<td class='bottom'><?php  echo CHtml::submitButton(  Yii::t('general','Form invitation'),  array( 'class'=>'red' )); ?>
	</td>
</tr></table>
<?php echo CHtml::endForm();
 //$this->endWidget(); ?>
</div><!-- form -->