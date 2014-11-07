<h3><?php echo 'Set up discount groups'; ?></h3>

	<?php CHtml::form(); ?>
 <div class="form">
	<table>
		 <tr><td class='top'>
		 <label><?php echo Yii::t('general','Discount Groups');?></label>
		 <?php $this->widget('ext.EchMultiSelect.EchMultiSelect', array(
				'name'=>'groups[]',     
				'data' => CHtml::listData(DiscountGroup::model()->findAll(), 'id', 'name'),
				'dropDownHtmlOptions'=> array(
					'style'=>'width:160px;',
				),
			));?>
			
		</td>
		<td><label><?php echo Yii::t('general','Discount'), ' %';?></label>
		<?php echo CHtml::textField('value'); 
				   echo CHtml::submitButton('Save' /*, array('class'=>'red')*/);  ?>	
		</td>
		<td class='bottom'>	<?php  
		//echo CHtml::ajaxSubmitButton('Save ajax', '',array('class'=>'red'));
		echo CHtml::submitButton('Save'/*, array('class'=>'red')*/);
		/* echo CHtml::ajaxSubmitButton('Save ajax', array('userGroup Discount/update', 'id'=> 'fff'), array('success'  => 'js: function(data) { $("#locator").html(data); } 
		function() { $.fn.yiiGridView.update("#user-group-discount-grid");}'
		)); */ ?>
	</td>
		</tr> 
	</table>
	<?php CHtml::endForm(); ?>
</div><!-- form -->
 
