<?php
/* @var $this EventsController */
/* @var $model Events */

$this->pageTitle =Yii::t('general','Events Management');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#events-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$eventtype=$app->session['Reference'];
?>
<h1><?php echo Yii::t('general','Events'); ?></h1><br> 

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn-win')); 
echo CHtml::link(Yii::t('general','Create') . ' ' . Yii::t('general', 'Event' ) /*. $eventMark */, array('create', 'eventtype' => $eventtype, 'id'=>'new',


), array(/*'style' => 'float:right;',*/ 'class' => 'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 

 // добавим тег открытия формы
 echo CHtml::form();
 //echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
// выбор действия которое надо применить при клике на запись в сетке
 $action = 'update';  
/*if (Yii::app()->user->checkAccess(1)) 
	{ $action = 'update'; }*/
 $url = $this->createUrl($action);
 
 
// конец выбора действия которое надо применить при клике на запись в сетке
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,	
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	//'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){  
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	 
	}', //+"&Subsystem=Warehouse+automation&Reference="'. Yii::app()->controller->id
	'columns'=>array(
 		'id'=>array( 
			'header'=>Yii::t('general','#'), 
			'name'=>'id',
		),  
		'Begin',	
		'author.username',		
		'contractorId' =>array( 
			'name'=>'contractorId',
			'value'=>'User::model()->findByPk($data->contractorId)->username', 	
		),
		//'eventNumber',
		'EventTypeId' =>array( 
			'name'=>'EventTypeId',
			'value'=>'Yii::t("general", Eventtype::model()->findByPk($data->EventTypeId)->name)',
			'filter' => CHtml::listData(Eventtype::model()->findall(), 'id', 'name'),		
		),
		'Organization'=>array(          
			'header'=>Yii::t('general','Organization'), 
			'value'=> 'Organization::model()->findByPk($data->organizationId)->name',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),
		), 
		'StatusId' =>array( 
			'name'=>'StatusId',
			'value'=>'Yii::t("general", EventStatus::model()->findByPk($data->StatusId)->name)',
			'filter' => CHtml::listData(EventStatus::model()->findall(), 'id', 'name'),		
		), 
		'totalSum',
		'Notes',		/*=> array(
			'name'=>'totalSum',
			//'footer' => '<b>Всего рублей <span style="color:red">' . Events::getTotalsKeys($model->search()->getKeys()) . '</span>' 
		),*/
	/*	'contractorId' =>array( 
			'name'=>'contractorId',
			'value'=>'Contractor::model()->findByPk($data->contractorId)->name',
			'filter' => CHtml::listData(Contractor::model()->findall(), 'id', 'name'),		
		),
		'contractId' =>array( 
			'name'=>'contractId',
			'value'=>'Contract::model()->findByPk($data->contractId)->name',
			'filter' => CHtml::listData(Contract::model()->findall(), 'id', 'name'),		
		),
		'Percentage',
		'totalSum' =>array( 
			'name'=>'totalSum',
			'footer'=>'<b>' . Yii::t('general','Total') . ' <span style="color:red">' . Events::getSumPlanHours($model->search()->getKeys()) . '</span>',
			// if gonna using 'footer' define the function getSumPlanHours() 
			// in your model class by this pattern:
			// если собираетесь использовать 'footer' то определите функцию
			// getSumPlanHours() в модели посредством этого шаблона:
			// public function getSumPlanHours($keys)
			//	{
			//		$records=self::model()->findAllByPk($keys); 
			//		$sum=0;
			//		foreach($records as $record) if($record->totalSum) $sum+=$record->PlanHours;
			//		return $sum;				
			//	}	
			),
		'ReflectInCalendar',
		'ReflectInTree' =>array(
			'name' => 'ReflectInTree',
			'value' => '($data->ReflectInTree != 0) ?  Yii::t("general","yes") :  Yii::t("general","no") ',
			'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
			),
		'ParentId' =>array( 
			'name'=>'ParentId',
			'value'=>'Parent::model()->findByPk($data->ParentId)->name',
			'filter' => CHtml::listData(Parent::model()->findall(), 'id', 'name'),		
		),
		'parent_id' =>array( 
			'name'=>'parent_id',
			'value'=>'Parent_::model()->findByPk($data->parent_id)->name',
			'filter' => CHtml::listData(Parent_::model()->findall(), 'id', 'name'),		
		),
		'Priority',
	
		'Comment',
		'PlanHours' =>array( 
			'name'=>'PlanHours',
			'footer'=>'<b>' . Yii::t('general','Total') . ' <span style="color:red">' . Events::getSumPlanHours($model->search()->getKeys()) . '</span>',
			// if gonna using 'footer' define the function getSumPlanHours() 
			// in your model class by this pattern:
			// если собираетесь использовать 'footer' то определите функцию
			// getSumPlanHours() в модели посредством этого шаблона:
			// public function getSumPlanHours($keys)
			//	{
			//		$records=self::model()->findAllByPk($keys); 
			//		$sum=0;
			//		foreach($records as ) if($record->PlanHours) +=$record->PlanHours;
			//		return $sum;				
			//	}	
			),
		'FactHours' =>array( 
			'name'=>'FactHours',
			'footer'=>'<b>' . Yii::t('general','Total') . ' <span style="color:red">' . Events::getSumPlanHours($model->search()->getKeys()) . '</span>',
			// if gonna using 'footer' define the function getSumPlanHours() 
			// in your model class by this pattern:
			// если собираетесь использовать 'footer' то определите функцию
			// getSumPlanHours() в модели посредством этого шаблона:
			// public function getSumPlanHours($keys)
			//	{
			//		$records=self::model()->findAllByPk($keys); 
			//		$sum=0;
			//		foreach($records as ) if($record->FactHours) +=$record->PlanHours;
			//		return $sum;				
			//	}	
			),
		'Tags',
		'bizProcessId' =>array( 
			'name'=>'bizProcessId',
			'value'=>'Bizprocess::model()->findByPk($data->bizProcessId)->name',
			'filter' => CHtml::listData(Bizprocess::model()->findall(), 'id', 'name'),		
		),
		'manualTransactionEditing' =>array(
			'name' => 'manualTransactionEditing',
			'value' => '($data->manualTransactionEditing != 0) ?  Yii::t("general","yes") :  Yii::t("general","no") ',
			'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
			),
		'dateTimeForDelivery',
		'dateTimeForPayment',
		*/
		/*array(
			'class'=>'ButtonColumn', 
			'evaluateID'=>true,
			'template'=>'{delete}',
			'buttons' => array(              
		   	    'delete' => array( 
					 'label' => Yii::t('general','Delete'), 
					 'imageUrl'=>'',
					 'options' => array('class'=>'custom-btn delete'), 
					  'visible'=>'Yii::app()->user->checkAccess(1)',				 
					),
               ), 
		)*/
	 
		
	),
)); 




// добавим тег закрытия формы
	echo CHtml::endForm();
?>
