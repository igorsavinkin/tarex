<h3><?php echo Yii::t('general','Set up discount groups value for this client' ); ?></h3>
<?php 
$dataProvider=new CActiveDataProvider('UserGroupDiscount', array(    
        'criteria' => array(
        'condition'=>'userId = '. $model->id, 'order'=>'id DESC'),   
		'pagination'=>false,
	));
 // добавим тег открытия формы
 echo CHtml::form();
 // echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
 
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
	//    'id',
	/* 	'userId' =>array( 
			'name'=>'userId',
			'value'=>'User::model()->findByPk($data->userId)->username',
			'filter' => CHtml::listData(User::model()->findall(array('order'=>'username ASC','condition'=> '`role`=' . User::ROLE_USER)), 'id', 'username'),		
		), */
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
			//'filter' => CHtml::listData(DiscountGroup::model()->findall(), 'id', 'name'),		
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
