<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	Yii::t('general','Events')=>array('admin'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List Events'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Events'), 'url'=>array('create')),
);
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
?>
<h1><?php // echo Yii::t('general','Manage Events'); ?></h1>
 
<p> 
<?php/* echo  Yii::t('general','You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>, <b>=</b>) <?php echo  Yii::t('general', 'at the beginning of each of your search values to specify how the comparison should be done'); */ ?>
</p>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn-win')); 
echo CHtml::link(Yii::t('general','Create') . ' ' . Yii::t('general', 'Event' ) /*. $eventMark */, array('create', 'eventtype' => $eventtype), array(/*'style' => 'float:right;',*/ 'class' => 'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 

 // добавим тег открытия формы
 echo CHtml::form();
 echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,	
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	//'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}',
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		// 'Id',
		'Subject',
		//'eventNumber',
		'EventTypeId' =>array( 
			'name'=>'EventTypeId',
			'value'=>'Eventtype::model()->findByPk($data->EventTypeId)->name',
			'filter' => CHtml::listData(Eventtype::model()->findall(), 'id', 'name'),		
		),
		'organizationId' =>array( 
			'name'=>'organizationId',
			'value'=>'Organization::model()->findByPk($data->organizationId)->name',
			'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'name'),		
		),
		'StatusId' =>array( 
			'name'=>'StatusId',
			'value'=>'EventStatus::model()->findByPk($data->StatusId)->name',
			'filter' => CHtml::listData(EventStatus::model()->findall(), 'id', 'name'),		
		),
		'Begin',
		'End',
		'totalSum'=> array(
			'name'=>'totalSum',
			'footer' => '<b>Всего рублей <span style="color:red">' . Events::getTotalsKeys($model->search()->getKeys()) . '</span>' 
		),
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
		
		array(
			'class' => 'CCheckBoxColumn',
			'id' => 'UserId',	
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 
// добавим тег закрытия формы
	echo CHtml::endForm();
?>
