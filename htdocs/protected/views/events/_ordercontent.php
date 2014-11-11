
<?php
/* @var $this EventcontentController */
/* @var $content Eventcontent */
/* @var $form CActiveForm */
?>
<h2><?php echo Yii::t('general', 'Event\'s content'); //Содержание заказа ?></h2>
<!--div class="form"-->
 
<div class='print' >

<h4 class='print' style='font-color:grey;'><?php// echo Yii::t('general','Order\'s Assortment'); //Номенклатура заказа: ?></h4>
<?php // сетка с номенклатурой для данного заказа
$dataProvider=new CActiveDataProvider('EventContent', array(    
        'criteria' => array(
        'condition'=>'eventId = '. $eventId), // $eventId передан из view 'update' 
		'pagination'=>array(
			'pageSize'=>100,
		),
	));
// добавим тег открытия формы
echo CHtml::form();
$this->widget( 'zii.widgets.grid.CGridView', array(
        'id' => 'orderscontent',
	//	'itemsCssClass' => 'table-bordered items',
		'selectableRows' => 2, 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		// выводим сумму по таблице и подсчитываем всю сумму и заносим это в атрибут 'totalSum' модели Events ---> $this->countSumTotal($eventId). Это происходит каждый раз при пересчёте/обновлении таблицы
	    'summaryText' => '<h3>' . Yii::t('general','Total with discount' ) . ' <em>'. EventContent::getTotalSumByEvent($eventId) . '</em> ' . Yii::t('general','RUB')  . '</h3>' . 'Результат {start} - {end} из {count}',
		'dataProvider' => $dataProvider,   	 
        'columns' => array( 
			'id',
			'assortmentTitle',
			
			
			//'assortmentAmount',
			array(  
				'type'=>'raw',
				'name'=>'assortmentAmount',
				'value' => array($this, 'amountDataField'),
				//'$data->amountDropDown()',//$data->id
				/*  function($data){
                        return EventContent::getAmountDropDown($data->id);
                   },    */  
			),
			
			'price',
			//'discount',
			'cost',
			//'cost_w_discount', 
			
			array(
				'class' => 'CCheckBoxColumn',
				'id' => 'eventContentId',	
			),
		/*	array(
				'class'=>'CButtonColumn',
				'visible' => Yii::app()->user->checkAccess('1'),
				'template'=>'{delete}',	//	{update} 	
				'buttons'=>array
				(
					'update' => array
					(
						'url'=>'Yii::app()->createUrl("eventContent/update", array("id"=>$data->id , "returnUrl" => "index.php?r=docEvents/update&id=".$data->eventId."#tab4" ))',
					),
					'delete' => array
					(
						'url'=>'Yii::app()->createUrl("eventContent/delete", array("id"=>$data->id, "end" => $data->id))',
					)
				),
			), */
		),
    )); 
	
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Delete selection') /* 'Удалить несколько'*/,  array('eventContent/bulkActions', 'name' => 'delete'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'), array('style'=>'float:right;')); 
/*echo CHtml::ajaxSubmitButton(Yii::t('general', 'Save selection'),  array('eventContent/bulkActions', 'name' => 'save'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'), array('style'=>'float:right;')); */
// добавим тег закрытия формы




		$ArrayD=CHtml::listData(LoadDataSettings::model()->findAll(), 'id', 'TemplateName');
        $this->widget('ext.select2.ESelect2',array(
                'name' => 'LoadDataSettingsID',
                'options'=> array('allowClear'=>true,
                        'width' => '200'),
                'data'=>$ArrayD,
           ));
		
		echo CHtml::link(Yii::t('general','Edit loading settings'), array('LoadDataSettings/admin')); 
				
		$this->widget('CMultiFileUpload', array( 		
			'name'=>'FileUpload1',
		  ));
		  
		echo CHtml::submitButton(Yii::t('general', 'Load assortment from file'));
		



	echo CHtml::submitButton($model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'), array('class'=>'red')); 
	
	
	
	
	echo CHtml::endForm();
?>
</div>
<button class='no-print' 'style'='float:right;' onClick="window.print()"><?php echo Yii::t('general','Print event content');  ?></button>


<?php /*
// добавим тег открытия формы
echo CHtml::form();
include( Yii::getPathOfAlias('editable') .  '/Editable.php');
$this->widget('ext.bootstrap.widgets.TbExtendedGridView', array(
        'id' => 'orderscontent2',
		'itemsCssClass' => 'table-bordered items',
		'selectableRows' => 2,
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',	
		// выводим сумму по таблице и подсчитываем всю сумму и заносим это в атрибут 'totalSum' модели DocEvents ---> $this->countSumTotal($eventId). Это происходит каждый раз при пересчёте/обновлении таблицы
	//	'summaryText' => $this->countSumTotal($eventId) . 'Результат {start} - {end} из {count}',
		'dataProvider' => $dataProvider, //new CArrayDataProvider('Item', array('data'=>$model->contents)),
		'extendedSummary' => array(
			'title' => '<h4>' . Yii::t('general', 'Total of this order') . '</h4>',
			'columns' => array(
				'sumwithdiscount' => array('label'=> Yii::t('general', 'Total with discount') . ' (' .  Yii::t('general', 'RUB') . ') ', //   'Общая сумма со скидкой (рублей)',
				'class'=>'TbSumOperation'),
				)),
		'extendedSummaryOptions' => array(
			//'class' => 'well pull-left',
			'style' => 'width:400px;',
		),
        'columns' => array( 
			'assortmentTitle', 	    
			array(
			   'class' => 'editable.EditableColumn', 
			//   'header' =>'Количество',			   
			   'name' => 'assortmentAmount',
			   'headerHtmlOptions' => array('style' => 'width: 60px'),
			   'editable' => array(    //editable section
					  'url'    => $this->createUrl('docEventContent/updateOrderContent'),    
					  // 'order/updatetest'), //'site/updateUser'), 
					  'placement'  => 'right',
					  'success' =>'js: function() { // here we update the current Grid with id = "orderscontent" 
								$.fn.yiiGridView.update("orderscontent2");
					            }',					  
				  )               
			),
		 	array(//'header' =>'Цена',
				'name' => 'assortment.priceS'),
			array('header'=>Yii::t('general', 'Sum'), //'Сумма', 
				'value' => array($this, 'count_sum')),
            array('header' =>Yii::t('general', 'Discount'), //'Скидка', 
				'value' => array($this, 'discount')
				),
			//'discount',	
            array('header' =>Yii::t('general', 'Total with discount'), // 'Сумма со скидкой', 
				'value' => array($this, 'sum_w_disc'), 'name'=>'sumwithdiscount'),	
			array(
				'class' => 'CCheckBoxColumn',
				'id' => 'userId',	
			),
			array(
				'class'=>'CButtonColumn',
				'visible' => Yii::app()->user->checkAccess('1'),
				'template'=>'{update} {delete}',			
				'buttons'=>array
				(
					'update' => array
					(
						'url'=>'Yii::app()->createUrl("docEventContent/update", array("id"=>$data->id , "returnUrl" => "index.php?r=docEvents/update&id=".$data->eventId."#tab4" ))',
					),
					'delete' => array
					(
						'url'=>'Yii::app()->createUrl("docEventContent/delete", array("id"=>$data->id, "end" => $data->id))',
					)
				),
			), 
		),
    )); 
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Delete several') ,  array('docEventContent/bulkActions', 'name' => 'delete'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'), array('style'=>'float:right;')); 
// добавим тег закрытия формы
	echo CHtml::endForm();*/
?>