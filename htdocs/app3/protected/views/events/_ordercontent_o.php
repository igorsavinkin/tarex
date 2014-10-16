
<?php
/* @var $this EventcontentController */
/* @var $content Eventcontent */
/* @var $form CActiveForm */
?>
<h2><?php echo Yii::t('general', 'Order\'s content'); //Содержание заказа ?></h2>
<!--div class="form"-->

<?php 
//if (!$eventId) $eventId = 279;
 
$content = new  EventContent;
 // предварительные установки модели 
$content->eventId = $eventId; // передан из view 'update' 
// конец установок модели EventContent
 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'doc-event-content-form',
	'enableAjaxValidation'=>false,
)); 
	echo $form->errorSummary($content); ?>

	<div class="hidden">
		<?php echo $form->textField($content,'eventId'); ?>
	</div>

<h4 style='font-color:grey;'><?php echo Yii::t('general', 'Add'), ' ' , Yii::t('general','Assortment.'); //Добавьте номенклатуру: ?></h4>
<!--добавляем номенклатуру для заказа	-->
<table border="0" width="300"><tr><td  width="100">
		<?php	echo '<b>', Yii::t('general','Assortment'), '</b> </br>';
				 $this->widget('ext.select2.ESelect2',array(
				 'attribute' => 'assortmentId',
			     'model'=>$content,
				 'options'=> array(
					'allowClear'=>true,
					'width' => '200', 
					'placeholder' => '',
					'minimumInputLength' => 3
					),
				 'data'=> CHtml::listData(Assortment::model()->findAll(), 'id', 'title'),
				 'htmlOptions'=>array( 
						//'multiple'=>'multiple',
					   ),  
				));   
				?>
	</td><td width="100">
	    <b><?php echo Yii::t('general','Amount'); // Количество ?></b><br />
		<?php echo $form->textField($content,'assortmentAmount'); ?>
		<?php echo $form->error($content,'assortmentAmount'); ?>
	</td>
	<td width="60px">
		<?php echo CHtml::ajaxSubmitButton( Yii::t('general', 'Add') /*'Добавить'*/,  array('eventContent/create'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'),  array('style'=> 'border-color: red;')); ?>
</td></tr></table> 
<?php $this->endWidget(); ?>




<h4><?php /*echo Yii::t('general',	'Load assortment from file into the order'); ?></h4>
<?php // Загрузка файла с заказом
$form=$this->beginWidget('CActiveForm', array(  
	'id'=>'doc-event-content-file',
	'enableAjaxValidation'=>false,
	'action'=> array('docEvents/loadContent'),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),	
)); 
	echo $form->errorSummary($content); ?>

	<div class="hidden">
		<?php echo $form->textField($content,'eventId'); ?>
	</div>
		<?php
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
		//echo '&nbsp;&nbsp;&nbsp;' , CHtml::ajaxSubmitButton(Yii::t('general', 'Load a file thru ajax' ) ,  array('docEvents/loadContent'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}')); 
$this->endWidget(); 
*/ ?>

<div  class='print' >
<h4 class='print' style='font-color:grey;'><?php echo Yii::t('general','Order\'s Assortment'); //Номенклатура заказа: ?></h4>
<?php // сетка с номенклатурой для данного заказа


/*
$form = $this->beginWidget('CActiveForm', array(
                        'id' => 'hide-form',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class'=>'well'),
                    ));
					echo $form->fileField($model, 'file');
					
					
					echo CHtml::submitButton('Загрузить номенклатуру из файла',  array('class'=>'btn btn-medium btn-primary',)); 
	*/				
					


$dataProvider=new CActiveDataProvider('EventContent', array(    
        'criteria' => array(
        'condition'=>'eventId = '. $eventId), 
    ));
// добавим тег открытия формы
echo CHtml::form();
$this->widget('ext.bootstrap.widgets.TbExtendedGridView', array(
        'id' => 'orderscontent',
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
			'style' => 'width:400px;', /*clear:both;*/
		),
        'columns' => array(
          //  'id',
          //  array('header' =>'Артикул', 'name' => 'assortmentId', 'htmlOptions' => array('style' => 'width: 40px')), 
			//array('header' =>'Наименование', 'name' => 'assortment.title'), 
			'assortment.title',
			//array( 'header' =>'Артикул',   'name'=>'assortment.article'),	
			'assortment.article',
			array(//'header' =>'Ед. изм.',
				'name' => 'assortment.measure_unit', 'htmlOptions' => array('style' => 'width: 30px') ),          
			array(
			   'class' => 'editable.EditableColumn', 
			//   'header' =>'Количество',			   
			   'name' => 'assortmentAmount',
			   'headerHtmlOptions' => array('style' => 'width: 60px'),
			   'editable' => array(    //editable section
					  'url'    => $this->createUrl('eventContent/updateOrderContent'),    
					  // 'order/updatetest'), //'site/updateUser'), 
					  'placement'  => 'right',
					  'success' =>'js: function() { /* here we update the current Grid with id = "orderscontent" */
								$.fn.yiiGridView.update("orderscontent");
					            }',					  
				  )               
			),
		/*	array(//'header' =>'Цена',
				'name' => 'assortment.priceS'),*/
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
						'url'=>'Yii::app()->createUrl("eventContent/update", array("id"=>$data->id , "returnUrl" => "index.php?r=docEvents/update&id=".$data->eventId."#tab4" ))',
					),
					'delete' => array
					(
						'url'=>'Yii::app()->createUrl("eventContent/delete", array("id"=>$data->id, "end" => $data->id))',
					)
				),
			), 
		),
    )); 
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Delete several') /* 'Удалить несколько'*/,  array('eventContent/bulkActions', 'name' => 'delete'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("orderscontent");}'), array('style'=>'float:right;')); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>
</div>
<button class='no-print' 'style'='float:right;' onClick="window.print()">Распечатать накладную</button>

