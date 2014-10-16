<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	Yii::t('general','Events')=>array('admin'),
	$model->Subject,
);

$this->menu=array(
	array('label'=>Yii::t('general','List Events'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create Events'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update Events'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('general','Delete Events'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage Events'), 'url'=>array('admin')),
); 


?>
<h2>
<?php
 

if($model->eventNumber) echo ' ', Yii::t('general','#'), $model->eventNumber;  if($model->Subject) echo ' ', Yii::t('general', "Subject"), ' "<em>' , $model->Subject , '</em>".'; ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid',
	'dataProvider'=>$model->search(),
	'summaryText'=>'',
	'columns'=>array(
		// 'id',
		'Subject',
		'eventNumber',
		'Notes',
		'Place',
		'EventTypeId' =>array( 
			'name'=>'EventTypeId',
			'value'=>'Eventtype::model()->findByPk($data->EventTypeId)->name',
			'filter' => CHtml::listData(Eventtype::model()->findall(), 'id', 'name'),		
		),
		'organizationId' =>array( 
			'name'=>'organizationId',
			'value'=>'Organization::model()->findByPk($data->organizationId)->name',
			'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'contractor'),		
		),
		'Begin',
		'End',
		/*
		'contractorId' =>array( 
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
		'totalSum',
		'ReflectInCalendar',
		'ReflectInTree' =>array(
			'name' => 'ReflectInTree',
			'value' => '($data->ReflectInTree != 0) ?  Yii::t("general","yes") :  Yii::t("general","no") ',
			//'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
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
		'StatusId' =>array( 
			'name'=>'StatusId',
			'value'=>'Status::model()->findByPk($data->StatusId)->name',
			'filter' => CHtml::listData(Status::model()->findall(), 'id', 'name'),		
		),
		'Comment',
		'PlanHours',
		'FactHours',
		'Tags',
		'bizProcessId' =>array( 
			'name'=>'bizProcessId',
			'value'=>'Bizprocess::model()->findByPk($data->bizProcessId)->name',
			'filter' => CHtml::listData(Bizprocess::model()->findall(), 'id', 'name'),		
		),
		'manualTransactionEditing' =>array(
			'name' => 'manualTransactionEditing',
			'value' => '($data->manualTransactionEditing != 0) ?  Yii::t("general","yes") :  Yii::t("general","no") ',
			//'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
			),
		'dateTimeForDelivery',
		'dateTimeForPayment',
		*/
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
)); ?>

<?php /* $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'Subject',
		'eventNumber',
		'Notes',
		'Place',
		'EventTypeId',
		'organizationId',
		'Begin',
		'End',
		'contractorId',
		'contractId',
		'Percentage',
		'totalSum',
		'ReflectInCalendar',
		'ReflectInTree',
		'ParentId',
		'parent_id',
		'Priority',
		'StatusId',
		'Comment',
		'PlanHours',
		'FactHours',
		'Tags',
		'bizProcessId',
		'manualTransactionEditing',
		'dateTimeForDelivery',
		'dateTimeForPayment',
	),
)); */?>
