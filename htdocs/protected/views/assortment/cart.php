<div class='print' style='visibility:hidden;display:none'>
	<?php echo date('d-m-Y H:i:s'); ?>
</div>
<div class='print'>
<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/print.css');
$this->pageTitle = Yii::t('general','Cart'); 
echo date('d-m-Y H:i:s'); 
if (!Yii::app()->shoppingCart->isEmpty()) 
{
	echo '<h1>', Yii::t('general', 'Cart'), '</h1>';   
	$positions = Yii::app()->shoppingCart->getPositions();
	$items= array();  
	$cartCost = 0;
	foreach($positions as $position)
	{
		$items[$position->getId()] = $position->getQuantity();	
		$cartCost +=  $position->getQuantity() *  $position->getPrice(''); 
	}
	$criteria = new CDbCriteria;
	$criteria->addInCondition('id',  array_keys($items));
	$dataProvider = new CActiveDataProvider('Assortment', array(
				'criteria'=>$criteria));
				
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assortment-grid',
		'dataProvider'=>$dataProvider,/*$model->search()*/
		'filter'=>$model, 
		'columns'=>array( 
		 'agroup', 
			'title', 
			'measure_unit',
			'article',  
			'availability', 
			'price'=>array(
				'value'=>'$data->getPrice()',
				'header'=>Yii::t('general', 'Price with discount'),
			), 
			'amount'=>array(
				'name'=>'amount', 
				'value'=>'Yii::app()->shoppingCart->itemAt($data->id)->getQuantity()',
			), 
			array(
				'name'=>Yii::t('general','Total Sum'),
				'value'=>'Yii::app()->shoppingCart->itemAt($data->id)->getQuantity() * $data->getPrice()',
			), 
			array(
					'class'=>'CButtonColumn',				
					'template'=>'{delete}',
					'buttons'=>array(
						'delete' => array(
							'label'=> "Remove from cart",						
							'url'=>'Yii::app()->controller->createUrl("assortment/removefromcart", array("id"=>$data[id],/*"command"=>"delete"*/))', 
							'options' => array(  
								'confirm' => Yii::t('general','Are you sure you want to remove this item from your cart') .'?',
								),
						),						
					),
				),
		),
	)); 		
if (Yii::app()->user->checkAccess( User::ROLE_USER ) ) {
	echo CHtml::link(Yii::t('general', Yii::t('general',"Request to the delivery")) , array('checkout', 'statusId'=>Events::STATUS_REQUEST_TO_DELIVERY),array('class'=>'btn-win no-print add-info', 'style' => 'float:right;')); 
	echo CHtml::link(Yii::t('general', Yii::t('general',"Request to the reserve")) , array('checkout', 'statusId'=>Events::STATUS_REQUEST_TO_RESERVE),array('class'=>'btn-win no-print add-info', 'style' => 'float:right;'));
	echo CHtml::link(Yii::t('general', Yii::t('general',"Make order")) , array('checkout'),array('class'=>'btn-win no-print', 'style' => 'float:right;'));
	} 
else { 
	echo CHtml::link(Yii::t('general', Yii::t('general',"Make order")) , array('checkoutretail'),array('class'=>'btn-win no-print', 'style' => 'float:right;'));
}	
		echo CHtml::link(Yii::t('general', Yii::t('general',"Clear Cart")) , array('clearcart'),array('class'=>'btn-win no-print' , 'style' => 'float:right;' /**/)); 
		
	echo 'Всего различных позиций в корзине - ', Yii::app()->shoppingCart->getCount(), '</br>';
	echo 'Всего товаров в корзине - ', Yii::app()->shoppingCart->getItemsCount(), '</br>';
	
	echo '<h4>Общая стоимость товаров в коризне со скидкой - ', $cartCost, ' рублей. </h4>';?>
	</div><!-- end class 'print' -->
	<!--button class='no-print' onClick="window.print()">Распечатать накладную</button-->
<?php
}
else 
{
	echo '<h1>', Yii::t('general', 'Cart is empty'), '.</h1>';
}

?>