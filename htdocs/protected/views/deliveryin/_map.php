<h2><?php 
echo Yii::t('general', 'Take a look at how to get to deliver goods to/from our warehouse.'); ?></h2><br>
<?php  
//echo 'contractor org index = ', User::model()->findbypk($model->contractorId)->organization;
$origin =  $_POST['origin'] ? CHtml::encode($_POST['origin']) : Organization::model()->findByPk( User::model()->findbypk($model->contractorId)->organization /*Yii::app()->user->organization*/)->address;

$destination = $_POST['destination'] ? CHtml::encode($_POST['destination']) : Organization::model()->findByPk(Yii::app()->user->organization)->address; ?>
 
<div class='wide form' >
<?php echo Chtml::Form( CController::createUrl($this->route, array('id'=>$model->id, '#'=>'tab2')) );?>
	<div>
		<?php      
		echo Chtml::label(Yii::t('general','Origin'), 'origin');
		echo Chtml::textField('origin', $origin , array('size'=>70)); 
		?>
	</div>
	<div>
		<?php
		echo Chtml::label(Yii::t('general','Destination'), 'destination');
		echo Chtml::textField('destination',  $destination , array('size'=>70));
		?>
	</div>
<?php echo CHtml::submitButton(Yii::t('general', 'Show on the map') , array('class'=>'red', 'name'=>'geo')); ?>
<?php echo CHtml::endForm(); ?>
</div>
<?php if($origin && $destination) : ?>
<iframe
  width="550" 
  height="350"
  frameborder="0" 
  style="border:0; margin: 5px;"
  src="https://www.google.com/maps/embed/v1/directions?key=AIzaSyC4tN-HmAjRFwPjlBfIqRRCPsaPRppTXOg&origin=<?php echo $origin; ?>+Russia&destination=<?php echo $destination; ?>+Russia&mode=driving">
</iframe>
<?php
endif;  
?>