<h1><?php echo Yii::t('general', 'Sent invitation to client to the page with the given assortment'); ?></h1> 
<div class='form'>
<h3><?php echo Yii::t('general', 'Client') , ': ' , $client->name ? $client->name : $client->username; ?></h3>
<table><tr>
	<td width='200'>	
<?php  echo CHtml::form();
			echo '<label>',Yii::t('general', 'Enter a particular page url'), '</label>';
			echo CHtml::textField('url', '' ,  array('size'=>70));  
	?>
	</td> 
	<td class='padding10side top' ><label><?php echo Yii::t('general','Make'),'</label>'; 
		$this->widget('ext.select2.ESelect2',array(
			'name'=> 'Manufacturer[id]',
			'options'=> array('allowClear'=>true, 'width' => '200'),
			'data'=>CHtml::listData($manufacturers + array(''=>' '), 'id', 'title'),
		));	 
	 ?>
	</td>
</tr><tr>
	<td class='bottom' colspan='2'><p class='required error'><?php echo Yii::t('general','The client will get his(her) login/password along with given assortment page url'); ?>.</p><?php  echo CHtml::submitButton(  Yii::t('general','Send invitation'),  array( 'class'=>'red' )); ?> 
	</td>
</tr></table>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->