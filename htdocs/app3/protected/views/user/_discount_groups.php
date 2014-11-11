<h3><?php echo Yii::t('general','Set up discount groups value for this client' ); ?></h3>

<div class="form">
<table><tr>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-group-discount-form', 
	'enableAjaxValidation'=>false,
)); ?>  
	<td>
		 <label><?php 
		 $discountGroups=array();
		 foreach(DiscountGroup::model()->findAll() as $dg) 
			 $discountGroups[$dg->id] = $dg->name . '(' . $dg->prefix .')';
 
		 echo Yii::t('general','Discount Groups');?></label>
		 <?php $this->widget('ext.EchMultiSelect.EchMultiSelect', array(
				'name'=>'groups[]',     
				'data' =>  $discountGroups, // CHtml::listData(DiscountGroup::model()->findAll(), 'id', 'name'),
				'dropDownHtmlOptions'=> array(
					'style'=>'width:160px;',
				),
			));?> 
	</td> 
	<td class='padding10side'>
		<label><?php echo Yii::t('general','Discount'), ' %';?></label>
				   <?php echo CHtml::textField('value');  ?>
	</td> 
	<td class='bottom'>	
		<?php echo CHtml::submitButton(Yii::t('general','Save'), array('class'=>'red', 'name'=>'user-group-discount')); ?>
	</td>
	
</tr></table> 
<?php $this->endWidget(); ?>

</div><!-- form -->
<h3><?php echo Yii::t('general','The user\'s discounts by groups'); ?></h3>
<?php   
$srMаnager = Yii::app()->user->checkAccess(User::ROLE_SENIOR_MANAGER);
// добавим тег открытия формы
echo CHtml::form();
if ($srMаnager) echo CHtml::submitButton(Yii::t('general','Delete Bulk'), array('name'=>'bulkDelete', 'class'=>'red',/*, 'style'=>'float:right;'*/));
 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-group-discount-grid',
	'dataProvider'=>/*$discountGroup*/ $userGroupDiscount->search($model->id),
	'filter'=>$userGroupDiscount, 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	/*'selectableRows'=>1,
		'selectionChanged'=>'function(id){  		
			location.href = "' . $this->createUrl('userGroupDiscount/update') .'/id/"+$.fn.yiiGridView.getSelection(id);	
		}',*/
    'htmlOptions'=>array('class'=>'grid-view grid-size-500'), 
	'columns'=>array(
 		array(
			'header' => '№',
			'value' => '$row + 1 +
				$this->grid->dataProvider->pagination->currentPage
				* $this->grid->dataProvider->pagination->pageSize',
		),
	   // 'id',
		'discountGroupId' =>array( 
			'name'=>'discountGroupId',
			'value'=>'DiscountGroup::model()->findByPk($data->discountGroupId)->name',
			'filter' => CHtml::listData(DiscountGroup::model()->findall(), 'id', 'name'),		
		),
		'value',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update1}',  
			'visible'=>$srMаnager,
			'buttons'=>array(
				'update1'=>array(
					'label'=>Yii::t('general', 'Update'),				  
				    'url'=>'Yii::app()->createUrl("userGroupDiscount/update", array("id"=>$data->id, "target"=>"_blank"))',
					'options'=>array('class'=>'btn btn-xs btn-primary'),
				),
			),
		),
		array(
			'class' => 'CCheckBoxColumn',
			'id' => 'UserGroupDiscountId',	 
			'visible'=>$srMаnager,
		),
		/*array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',			
			'visible'=>$srMаnager,
		),*/
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>