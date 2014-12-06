<div class="tar_search">
	<?php echo CHtml::form(); 
	    $value =  isset($_POST['search-value']) ? $_POST['search-value'] : ''; 
		echo CHtml::textField('search-value', $value, array('placeholder'=> Yii::t('general', 'OEM, Article or part name'), 'width'=>'350px') ); ?>
		<input type="submit"  value="<?php echo Yii::t('general' , 'Search'); ?>" class='red'><!--class="form_submit"-->
	 <?php echo CHtml::endForm(); ?>
</div>