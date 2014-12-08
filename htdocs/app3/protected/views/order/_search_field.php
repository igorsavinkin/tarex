<div class="tar_search form">
	<?php echo CHtml::form(array($this->route, 'id'=>$_GET['id'], '#'=>'tab2')); 
	    $value =  isset($_REQUEST['search-value']) ? $_REQUEST['search-value'] : ''; 
	 //   $value =  isset($_POST['search-value']) ? $_POST['search-value'] : ''; 
		
		echo CHtml::textField('search-value', $value, array('placeholder'=> Yii::t('general', 'OEM, Article or part name'), 'style'=>'width:350px;') ); ?>
		<input type="submit"  value="<?php echo Yii::t('general' , 'Search'); ?>" class='red'><!--class="form_submit"-->
	 <?php echo CHtml::endForm(); ?>
</div>