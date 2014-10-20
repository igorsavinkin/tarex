<?php
/* @var $this AssortmentController */
/* @var $model Assortment */
$this->breadcrumbs=array(
	Yii::t('general','Assortments')=>array('index'),
	$model->title,
);?>

<div style="border: 5px solid #344756; margin:0 0 0 30px; padding: 15px;">
<h1 style='margin-left: 30px;'>
<?php echo ' <em><u>'. $model->title . '</u></em>'; ?></h1><table><tr>
	<td>
	<b><?php echo $model->getAttributeLabel('model') ?>:</b>
	<?php echo $model->model ?>
	<br />

	<b><?php echo $model->getAttributeLabel('make') ?>:</b>
	<?php echo $model->make ?>
	<br />
	 
	<b><?php echo $model->getAttributeLabel('measure_unit') ?>:</b>
	<?php echo $model->measure_unit ?>
	<br />

	<b><?php echo Yii::t('general', "Price"), ', ',Yii::t('general', "RUB"); ?>:</b>
	<?php echo $model->getPrice(); ?>
	<br />  

	<b><?php echo $model->getAttributeLabel('warehouse') ?>:</b>
	<?php echo $model->warehouse ?>
	<br />

	<b><?php echo $model->getAttributeLabel('article2') ?>:</b>
	<?php echo $model->article2 ?>
	<br /> 

	<b><?php echo $model->getAttributeLabel('oem') ?>:</b>
	<?php echo $model->oem ?>
	<br /> 

	<b><?php echo $model->getAttributeLabel('manufacturer') ?>:</b>
	<?php echo $model->manufacturer ?>
	<br /> 
	
	<b><?php echo $model->getAttributeLabel('availability') ?>:</b>
	<?php echo $model->availability ?>
	<br />
 
	<b><?php echo $model->getAttributeLabel('country') ?>:</b>
	<?php echo $model->country ?>
	<br /><br />
	<?php
		$msg = Yii::t('general','item(s) have been added to cart');
	    echo CHtml::ajaxSubmitButton(Yii::t('general', 'Add to Cart'), array('addToCartAjax'), array( 'data'=>'js:{id: this.name, amount: 1 /*jQuery(this).siblings("select").val()*/ , "' . Yii::app()->request->csrfTokenName . '": "' . Yii::app()->request->csrfToken . '" }' /*, 'update'=>'#cart-content'*/ , 'success'=>'js:function(data){var obj=JSON && JSON.parse(data) || $.parseJSON(data); $("#cart-content").html(obj.cartMsg); alert( obj.amount + " '. $msg. '"); }'), array('class'=>'btn btn-medium btn-primary', 'name' =>  $model->id ));  ?>
	</td>
	<td class='padding10side'> 
	<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/foto/'.$model->article2 . '.jpg' , "photo"/*,array("width"=>350)*/);   // Image shown here if page is update page 
	?>
	</td>
</tr> 
</table>
</div>