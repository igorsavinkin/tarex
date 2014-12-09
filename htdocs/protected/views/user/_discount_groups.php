<h3><?php echo Yii::t('general','Discount groups' ); ?></h3>
<?php   
//********************** script for the popup Dialog **********************//
$msg='Для нового клиента задайте сначала группы скидок, сохраните их и перейдите на  вкладку "Основное" чтобы до конца задать инфо клиента.';
Yii::app()->clientScript->registerScript('info-msg', "
if (location.search.indexOf('new') != false) 
	alert('{$msg}');
", CClientScript::POS_END);
 
$dataProvider=new CActiveDataProvider('UserGroupDiscount', array(    
        'criteria' => array(
        'condition'=>'userId = '. $model->id, 'order'=>'id ASC'),   
		'pagination'=>false,
	));

if (Yii::app()->user->checkAccess(User::ROLE_MANAGER) && (0 == $dataProvider->itemCount) )
{
	echo CHtml::Link(Yii::t('general','Create Discount groups'), 
		array('userGroupDiscount/createAllGroups', 'userId'=>$model->id, 'return'=>1),
	    //array('click' =>'js:function() { fn.yiiGridView.update("#user-group-discount-grid");}' ), // это надо если ajaxLink
		array('class'=>'btn-win') ); 
}
	
 // добавим тег открытия формы
 echo CHtml::form(); 
 $msg = Yii::t('general', "The discounts are renewed");
 echo CHtml::ajaxSubmitButton(Yii::t('general', Yii::t('general','Save')) ,  array(/*'eventContent/updateEventcontent', 'name' => 'saveDiscount'*/ ), array('success'  => 'js:  function() { $.fn.yiiGridView.update("user-group-discount-grid");alert("' . $msg . '"); }'), array( 'class'=>'red')); 
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-group-discount-grid',
	'dataProvider'=>$dataProvider , //$userGroupDiscount->search($model->id),
	'filter'=>$userGroupDiscount, 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'htmlOptions'=>array('class'=>'grid-view grid-size-500'), 
	'columns'=>array(
 		array(
			'header' => '№',
			'value' => '$row + 1 +
				$this->grid->dataProvider->pagination->currentPage
				* $this->grid->dataProvider->pagination->pageSize',
		), 
		'discountGroupId' =>array( 
			'name'=>'discountGroupId',
			'value'=>'DiscountGroup::model()->findByPk($data->discountGroupId)->name',
			'filter' => CHtml::listData(DiscountGroup::model()->findall(), 'id', 'name'),		
		),
		array( 
			'header'=> Yii::t('general','Prefix'),
			'value'=>'DiscountGroup::model()->findByPk($data->discountGroupId)->prefix', 
		),
		'maxDiscount' =>array(  
			'header'=>Yii::t('general','Max wholesale discount'),		
			'value'=>'DiscountGroup::model()->findByPk($data->discountGroupId)->value',
	 	),  
		'discount'=>array(  
			'type'=>'raw',
			'htmlOptions'=>array('width'=>'150px'), 
			'header'=>Yii::t('general','Current discount') . ', %',
			'value' => '$data->discountField($data->id, $data->value)', 				
		),  
	),
)); 

// добавим тег закрытия формы
	echo CHtml::endForm();
?>