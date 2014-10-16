<div class="wide form">
<?php 
Yii::app()->clientScript->registerScript('car-index-users-index', "
$('#car-index').click(function(){
	$('#car-index-form').toggle(); 
	jump('car-index-form');
	return false;
});
$('#users-form-btn').click(function(){
	$('#users-form').toggle();
	jump('users-form');
	return false;
});
function jump(h){
    var top = document.getElementById(h).offsetTop;
    window.scrollTo(0, top);
}
$('.search-form form').submit(function(){
	$('#assortment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false; 
}); 
"); 

//print_r($model);
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'id'=>'uni-form',
	'method'=>'get',
));	?>   
    
<table ><tr valign='top'>
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
	<td style='padding:0 15px 0 15px; valign:top;'> 
		<?php
		    $criteria2 = new CDbCriteria;
			$criteria2->distinct = true;
			$criteria2->order = 'subgroup ASC';
			$criteria2->select = array('subgroup');
			$subs = Assortment::model()->findAll($criteria2);  
			echo $form->label($model,'subgroup'), '</br>';
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
</tr><tr>	
	<td width='300' ><span class='nowrap'><label>  
		<?php echo Yii::t('general','Warehouses in use'), '</label></span><br>';
			echo $form->checkBoxList($model, 'warehouseId', CHtml::listData(Warehouse::model()->findAll('organizationId = ' . Yii::app()->user->organization), 'id','name'), array('template'=>'{label}{input}'/*, 'separator'=>''*/));
		?>		
	</td>
	<td valign='top' width='300'><span class='nowrap'><label>  
	<?php echo Yii::t('general','Warehouses in use'), '</label></span><br>';		
			if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN))  
				$condition = 'organizationId = ' . Yii::app()->user->organization;
			else  		
				$condition = '1=1';
			$model->warehousesArray[] = $model->warehouseId;
		 	$this->widget('ext.EchMultiSelect.EchMultiSelect', array(
				'model' => $model,
				'dropDownAttribute' => 'warehousesArray',     
				'data' => CHtml::listData(Warehouse::model()->findAll($condition), 'id','name'), 
				'dropDownHtmlOptions'=> array('style'=>'width:200px;'),
			));  ?>
	</td>		 	 
	<td width='110' class='padding10' >	
		<?php echo CHtml::submitButton(Yii::t('general','Find'),  array('class'=>'red','name'=>'find' )); ?>
	</td>
<?php $this->endWidget(); ?>
</tr></table>

</div>
<hr>
<form>
<div class='wide form'>
<?php CHtml::form(array(
	//'action'=>Yii::app()->createUrl($this->route),
	'id'=>'new-item-form',
	'method'=>'get',
));	?>  
<table><tr>
	<td width='300px'><span class='nowrap'><label>  
		<?php echo Yii::t('general','Enter Notes for market research or new Item Number'), '</label></span><br>';		
					echo CHtml::textField('searchTerm', '', array( 'style'=>'height:22px;width:300px;font-size:15px'  )); ?>  	
	</td> 
	<td width='300px' style='padding:0 15px 0 15px; valign:top;'><span class='nowrap'><label>  
		<?php echo Yii::t('general','Item Marked Price if provided, $US'), '</label></span><br>';		
					echo CHtml::textField('marketPrice', '',array( 'style'=>'height:22px;width:200px;font-size:15px' )); ?>  	
	</td>
	<td style='padding:-2px 15px 0 15px; valign:top;'><label>  
		<?php echo Yii::t('general','Client') , '</label><br>';	   
		 $this->widget('ext.select2.ESelect2', array(   
				'name'=> 'relatedClientId',
				'data' => CHtml::listData(User::model()->findAll( array(
					'order'=>'username ASC', 
					'condition'=>"isCustomer = 1 AND organization = ". Yii::app()->user->organization) ), 'id','username'),
				'options'=> array('allowClear'=>true, 
					'width' => '200', 
					'placeholder' => '', 
					),						
			)); //echo CHtml::textField('relatedClientId', '',array( 'style'=>'height:22px;width:200px;font-size:15px' )); ?>  	
	</td>
	<td class='padding10side' >	
		<?php echo CHtml::submitButton(Yii::t('general','Submit customer request'),  array('class'=>'red', 'name'=>'AddtToMarketRequest' )); ?><br>
		<?php echo CHtml::Link(Yii::t('general', 'Manage new requests') , array('searchTerm/admin') , array(  'target'=>'_blank')); ?>
	</td>
<?php CHtml::endForm(); ?>
</tr></table>
</div>
</form><!-- form -->

<hr>
<div class='wide form'>
<h3>
<?php echo Yii::t('general','Customer name'), ': '?>
	<span id='customerName'>
		<span style='font-size:10px; font-style:italic;'>choose one below in <b>Customers</b> table
		</span>
	</span>	
</h3>
<?php echo CHtml::submitButton(Yii::t('general','Simulate invoice'),  array('class'=>'big-red','name'=>'find' ,'style'=>'float:right;')); ?>
<h2><?php echo CHtml::link(Yii::t('general','Create Order'), array('order/create') , array('id'=>'create-order', 'class'=>'btn-win', 'target'=>'_blank' ,'style'=>'float:right;')); ?></h2>
</div> 