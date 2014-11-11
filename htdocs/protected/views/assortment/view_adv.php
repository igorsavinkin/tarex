<?php
/* @var $this AssortmentController */
/* @var $model Assortment */
$this->breadcrumbs=array(
	Yii::t('general','Assortments')=>array('index'),
	$model->title,
);
//echo 'baseUrl =',   Yii::app()->baseUrl;
//echo '<br>base Path =',   Yii::app()->basePath;
?> 
<div class='form'>
	<h1 style='margin-left: 30px;' >
	<?php echo ' <em><u>'. $model->title . '</u></em>'; ?></h1>
	<?php if ((getimagesize(Yii::app()->basePath. '/../img/foto/'. $model->article2 . '.jpg') !== false) ) : ?>
	<div style="border: 1px solid #344756; margin:0 0 0 30px; padding: 5px;float:left;"> 
	<?php echo CHtml::image(Yii::app()->baseUrl. '/img/foto/'. $model->article2 . '.jpg' , "photo",array("width"=>450))?> </div>
	<?php endif;	?>
	
	<table style='float:left;margin:0 10px;'><tr class='odd-row' >
		<td style='width: 200px;'> 
		<b><?php echo $model->getAttributeLabel('model') ?>:</b></td><td> 
		<?php echo $model->model ?>
		
		</td></tr><tr><td> 
		<b><?php echo $model->getAttributeLabel('make') ?>:</b></td><td> 
		<?php echo $model->make ?>
		
		 </td></tr><tr class='odd-row'><td> 
		<b><?php echo $model->getAttributeLabel('measure_unit') ?>:</b></td><td> 
		<?php echo $model->measure_unit ?>
		
	</td></tr><tr><td> 
		<b><?php echo Yii::t('general', "Price"), ', ',Yii::t('general', "RUB"); ?>:</b></td><td> 
		<?php echo $model->getPrice(); ?>
		  
	</td></tr><tr class='odd-row'><td> 
		<b><?php echo $model->getAttributeLabel('warehouse') ?>:</b></td><td> 
		<?php echo $model->warehouse ?>
		
	</td></tr><tr><td> 
		<b><?php echo $model->getAttributeLabel('article2') ?>:</b></td><td> 
		<?php echo $model->article2 ?>
		 
	</td></tr><tr class='odd-row'><td> 
		<b><?php echo $model->getAttributeLabel('oem') ?>:</b></td><td> 
		<?php echo $model->oem ?>
		 
	</td></tr><tr><td> 
		<b><?php echo $model->getAttributeLabel('manufacturer') ?>:</b></td><td> 
		<?php echo $model->manufacturer ?>
		 
	</td></tr><tr class='odd-row'><td> 	
		<b><?php echo $model->getAttributeLabel('availability') ?>:</b></td><td> 
		<?php echo $model->availability ?>
		
	 </td></tr><tr><td> 
		<b><?php echo $model->getAttributeLabel('country') ?>:</b></td><td> 
		<?php echo $model->country ?>
		</td> 
	</tr> 
	</table> 
	<div style='border-top:1px solid #ccc;border-bottom:1px solid #ccc; padding:10px 0 10px 10px;margin: 0 20px;float:right;'> 
	<?php
		$dataArr = array(); for($i=1; $i <= $model->availability; $i++ ) { $dataArr[$i] = $i; }
		$msg = Yii::t('general','item(s) have been added to cart');
		echo CHtml::ajaxSubmitButton(Yii::t('general', 'Add to Cart'), array('addToCartAjax'), array( 'data'=>'js:{id: this.name, amount:  jQuery(this).siblings().children("select").val(), "' . Yii::app()->request->csrfTokenName . '": "' . Yii::app()->request->csrfToken . '" }', 'success'=>'js:function(data){var obj=JSON && JSON.parse(data) || $.parseJSON(data); $("#cart-content").html(obj.cartMsg); alert( obj.amount + " '. $msg. '"); }'), array('class'=>'btn btn-small btn-primary', 'name' =>  $model->id )); 
		echo ' <b style="float:left; line-height: 2.5em; ">', Yii::t('general','Amount') , '  ', CHtml::dropDownList('Assortment[amount][' . $model->id .']', 1, $dataArr, array('style'=>'width:40px;')), '&nbsp;&nbsp;&nbsp;</b>';  
	?>
	</div>
</div><!-- .form -->