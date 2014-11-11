<?php
/* @var $this PogeneratorController */
/* @var $model Assortment */
	$UserRole=Yii::app()->user->role;
	$UserId=Yii::app()->user->id;
	$UserName=Yii::app()->user->username;
	//$UserName=Yii::app()->user->username;
	$OrganizationId=Yii::app()->user->organization;
	
	//echo 'OrganizationId'.$OrganizationId;
	//return;

?>
	<?php Yii::app()->clientScript->registerCssFile("extjs/resources/css/ext-all.css"); ?>
	<?php Yii::app()->clientScript->registerScriptFile("extjs/ext-all.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("protected/js/Lang.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("protected/js/UniversalStore.js")	?>
	<?php Yii::app()->clientScript->registerScriptFile("protected/js/reports/Stockavailability.js")	?>


 
<h3><?php echo Yii::t('general','Stock Availability'); ?></h3>

<div id="Filters"></div><br>
<div id="Grid"></div><br>

<table border=1><tr>	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'events-form',
	'enableAjaxValidation'=>false,
)); 
?>


<td>
<?php
	echo '<strong>'.Yii::t('general','Begin').'</strong>'; 
	$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
	'model'=>$model,
	'attribute'=>'Begin',
	'language'=>'ru',
	 'options'=>array(
		'dateFormat'=>'yy-mm-dd',
		'timeFormat'=>strtolower(Yii::app()->locale->timeFormat),
		'changeMonth'=>'true',
		 'showSecond'=>true,
		'changeYear'=>'true',
		'changeHour'=>'true',
		//'showButtonPanel'=>'true',
		'timeOnlyTitle' => 'Выберите часы',
		'timeText' => 'Время',
		'hourText'=>'Часы',
		'minuteText'=> 'Минуты',
		'secondText'=> 'Секунды', 				
		),
	)); 
?>
</td><td>
<?php	
	echo '<strong>'.Yii::t('general','End').'</strong>'; 
	$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
	'model'=>$model,
	'attribute'=>'End',
	'language'=>'ru',
	 'options'=>array(
		'dateFormat'=>'yy-mm-dd',
		'timeFormat'=>strtolower(Yii::app()->locale->timeFormat),
		'changeMonth'=>'true',
		 'showSecond'=>true,
		'changeYear'=>'true',
		'changeHour'=>'true',
		//'showButtonPanel'=>'true',
		'timeOnlyTitle' => 'Выберите часы',
		'timeText' => 'Время',
		'hourText'=>'Часы',
		'minuteText'=> 'Минуты',
		'secondText'=> 'Секунды', 				
		),
	)); 

?>
</td>
</tr><tr>
<td>
<?
	echo '<strong>'.Yii::t('general','Contractor').'</strong>'; 
	if($RoleId<=3){
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'contractorId',
			'data' => CHtml::listData(User::model()->findAll(array('order'=>'name ASC')), 'id','username'),
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '',
				//'minimumInputLength' => 3
				),
		)); 
	}elseif ($RoleId>3 && $RoleId<6){
	
		$AllowedContractors=CHtml::listData(User::model()->findAll(array(
			'order'=>'name ASC',
			'condition'=>'organization=:organization',
			'params'=>array(':organization'=>$OrganizationId),
			)), 'id','username');
	
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'contractorId',
			'data' => $AllowedContractors,
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '',
				//'minimumInputLength' => 3
				),
		)); 
	}else{
		echo $UserName;
	}
?>	
	
</td><td>
<?
	//Author
	echo '<strong>'.Yii::t('general','Author').'</strong>'; 
	
		$AllowedContractors=CHtml::listData(User::model()->findAll(array(
			'order'=>'name ASC',
			'condition'=>'organization=:organization AND isEmployee=1',
			'params'=>array(':organization'=>$OrganizationId),
			)), 'id','username');
			
			
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'authorId',
			'data' => $AllowedContractors,
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '',
				//'minimumInputLength' => 3
				),
		)); 
?>
</td><td>

		

	
<?	
	//Wharehouse
	echo '<strong>'.Yii::t('general','Warehouse').'</strong>'; 
	
		$AllowedContractors=CHtml::listData(Warehouse::model()->findAll(array(
			'order'=>'name ASC',
			'condition'=>'organizationId=:organization',
			'params'=>array(':organization'=>$OrganizationId),
			)), 'id','name');
	
		$this->widget('ext.select2.ESelect2', array(
			'model'=> $model,
			'attribute'=> 'Subconto1',
			'data' => $AllowedContractors,
			'options'=> array('allowClear'=>true, 
				'width' => '200', 
				'placeholder' => '',
				//'minimumInputLength' => 3
				),
		)); 
	
?>
	</td>
	</tr><tr>
	<td>
<?
	//Title
	$Assortment=new Assortment;
	echo '<br><strong>'.Yii::t('general','Assortment title').'</strong>'; 
	echo '</td><td>';
	echo $form->textField($Assortment, 'title', array('size'=>70)); 
	echo '</td></tr><tr><td>';
	
	
	//model
	echo '<br><strong>'.Yii::t('general','Assortment model').'</strong>'; 
	echo '</td><td>';
	echo $form->textField($Assortment, 'model', array('size'=>70)); 
	echo '</td></tr><tr><td>';

	//make
	echo '<br><strong>'.Yii::t('general','Assortment make').'</strong>'; 
	echo '</td><td>';
	echo $form->textField($Assortment, 'make', array('size'=>70)); 
	echo '</td></tr><tr><td>';

	//manufacturer
	echo '<br><strong>'.Yii::t('general','Assortment manufacturer').'</strong>'; 
	echo '</td><td>';
	echo $form->textField($Assortment, 'manufacturer', array('size'=>70)); 
	echo '</td></tr><tr><td>';

	//subgroup
	echo '<br><strong>'.Yii::t('general','Assortment subgroup').'</strong>'; 
	echo '</td><td>';
	echo $form->textField($Assortment, 'subgroup', array('size'=>70)); 
	echo '</td></tr><tr><td>';


	//number
	echo '<br><strong>'.Yii::t('general','Document number').'</strong>'; 
	echo '</td><td>';
	echo $form->textField($Assortment, 'id', array('size'=>70)); 
	
	
	
	


?>
</td><td>
<?
	echo CHtml::submitButton(Yii::t('general','Generate')); 
	


?>
	
</td> 
</tr></table> 
<?php $this->endWidget(); ?>


<?
	if(isset($_POST['Events']))
	{
		
	
	
	}
	
	
?>



