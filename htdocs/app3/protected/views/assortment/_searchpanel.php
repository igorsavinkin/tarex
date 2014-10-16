<div class="wide form">
<?php 
//print_r($model);
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'id'=>'uni-form',
	'method'=>'get',
));	?>
 
<table ><tr valign='top'>
	<?php/*<td valign="top"  width='110' style='padding:0 15px 0 15px'>
		 	echo $form->label($model,'itemSearch');		
					echo $form->textField($model,'itemSearch'); ?>  
	</td>*/?>
	<td><span class='nowrap'> 
	<?php echo $form->label($model,'itemSearch'), '</span><br>';	
		$this->widget('zii.widgets.jui.CJuiAutoComplete',array(	
			'model'=>$model,
			'attribute'=>'itemSearch', 
			'source'=>$this->createUrl('autocomplete'), 
			'options'=>array(
				'minLength'=>'3',
				'showAnim'=>'slide',
				'placeholder' => 'oem, article, schnieder#, trade#, part#',	
				'select'=>'js:function(event, ui) {				 			   
					$(this).val(ui.item.value); 
					location.href= "'. $this->createUrl($this->route) . '&Assortment%5BitemSearch%5D=" + ui.item.value + $("#uni-form").serialize() ;	
				 }',  	 			
			),  	
			'htmlOptions'=>array(
				'style'=>'height:22px;width:300px;font-size:15px',
				'title'=>Yii::t('general', 'Enter at least 3 characters'), 
			),
		));
		echo "<p class='note'>" , Yii::t('general', 'Enter at least 3 characters'), '</p>';
	?>
	</td>
	<td width='110' style='padding:5px 15px 0 15px; valign:top;'> 
		<?php
		    $criteria2 = new CDbCriteria;
			$criteria2->distinct = true;
			$criteria2->order = 'subgroup ASC';
			$criteria2->select = array('subgroup');
			$subs = Assortment::model()->findAll($criteria2);  
			echo '<span style="padding:15px">' , $form->label($model,'subgroup'), '</span></br>';
			$this->widget('ext.select2.ESelect2', array(
			  'model'=> $model,
			  'attribute'=> 'subgroup',
			  'data' => CHtml::listData($subs , 'subgroup', 'subgroup'),
			  'options'=> array('allowClear'=>true, 
			   'width' => '200', 
			   'placeholder' => '', 
			   ),
			)); ?>
	</td>
	<td><span class='nowrap'><label>  
	<?php echo Yii::t('general','Car search (model/make)'), '</label></span><br>';	
		$this->widget('zii.widgets.jui.CJuiAutoComplete',array(	
			'model'=>$model,
			'attribute'=>'modelMake', 
			'source'=>$this->createUrl('autocomplete', array('type'=>'car')), 
			'options'=>array(
				'minLength'=>'3', 
				'showAnim'=>'blind',
				'placeholder' => 'oem, article, schnieder#, trade#, part#',
				'select'=>'js:function(event, ui) {				 			   
					$(this).val(ui.item.value); 
					location.href= "'. $this->createUrl($this->route) . '&Assortment[modelMake]=" + ui.item.value + $("#uni-form").serialize() ;	
				 }',  
			),
			'htmlOptions'=>array(
				'style'=>'height:22px;width:300px;font-size:15px',
				'title'=>Yii::t('general', 'Enter at least 3 characters'), 
			),
		));
		echo "<p class='note'>" , Yii::t('general', 'Enter at least 3 characters'), '</p>';
	?>
	</td>
	<td width='110' class='padding10side' >	
		<?php echo CHtml::submitButton(Yii::t('general','Find'),  array('class'=>'red','name'=>'find' )); ?>
	</td>
</tr></table>
<?php $this->endWidget(); ?>
</div>