<h3><?php echo Yii::t('general','Discount groups' ); ?></h3>
<?php 
$dataProvider=new CActiveDataProvider('UserGroupDiscount', array(    
        'criteria' => array(
        'condition'=>'userId = '. $model->id, 'order'=>'id ASC'),   
		'pagination'=>false,
	));
 // добавим тег открытия формы
 echo CHtml::form(); 
 
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