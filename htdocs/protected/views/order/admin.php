<?php
/* @var $this EventsController */
/* @var $model Events */
 
$this->pageTitle =Yii::t('general','Orders');
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
<h1><?php echo Yii::t('general','Orders'); ?></h1><br> 
<?php 
if(Yii::app()->user->role<6){
	echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn-win')); 
}
echo CHtml::link(Yii::t('general','Create') . ' ' . Yii::t('general', 'Order' ) , array('create', 'new'=>1), array( 'class' => 'btn-win'));  // target='_blank' ?>
<div style="float:left; margin-top:-10px"><h4 style='padding-left:25px'>
<?php echo Yii::t('general','Quick open order');?></h4> 
	<div style=""> 
		<!--form method='get'>   
			<input type="hidden" value="order/update" name="r">
			<?php //echo CHtml::label(Yii::t('general','Event Number') . '&nbsp;'); ?>
			<input type='text' name='id' />
		</form-->  
		<?php  echo CHtml::form(array('update') , 'get'); 
					echo CHtml::label(Yii::t('general','Order') . ' ' . Yii::t('general','#') . '&nbsp;', false);
					echo CHtml::textField('id');
					echo CHtml::endForm();?>  
	</div><!-- form small --> 
</div><!-- float:left --> 
<div class='pad'></div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php 

// выбор действия которое надо применить при клике на запись в сетке
$action = 'update';  
/*if (Yii::app()->user->checkAccess(1)) 
{ $action = 'update'; }*/
$url = $this->createUrl($action);  
// конец выбора действия которое надо применить при клике на запись в сетке
 
echo CHtml::form(array('bulkActions'));
//echo CHtml::submitButton('Delete bulk', array('style'=>'float:right;', 'name'=>'delete-bulk')); 
echo CHtml::ajaxSubmitButton(Yii::t('general', 'Delete selection'), array('bulkActions', 'name' => 'delete-bulk'), array('success'  => 'js:  function() { $.fn.yiiGridView.update("events-grid");  }'), array('style'=>'float:right;'));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid',
	/*'dataProvider'=> new CActiveDataProvider('Order', array(
			'criteria'=>$model->criteria(),
			'pagination'=>array('pageSize'=>Yii::app()->params['defaultPageSize']),  
		)), */
	'dataProvider'=> $model->search(),
	 //'filter'=>$model,	
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
/*	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',*/
	'columns'=>array(
 		'id'=>array( 
			'header'=>Yii::t('general','#'), 
			'name'=>'id',
		), 
		'Date'=>array(
			'name'=>'Begin',		
			'header' => Yii::t('general', 'Date'), 		
		),  
		array( 
			'name'=>'author.username', 
			'header' => Yii::t('general', 'Order\'s author'), 	 
		),
	/*    'contractorId' =>array( 
			'name'=>'contractorId',
			'value'=>'isset($data->contractorId ) ?  User::model()->findByPk($data->contractorId)->username : "" ',	
			//'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'name'),		
		),  */
		array( 	
		    'header' => Yii::t('general', 'Contractor'), 
			'value'=>'isset($data->contractorId) ?  User::model()->findByPk($data->contractorId)->name : "" ',				
		),			
		array('header'=>Yii::t('general','Manager'),
			 'filter'=>CHtml::listData(User::model()->findAll('role = '. User::ROLE_SENIOR_MANAGER .' OR role = ' . User::ROLE_MANAGER), 'id', 'username'), 
		   'value'=>'User::model()->findByPk(User::model()->findByPk($data->contractorId)->parentId)->username',
		 ),	 
		/*'EventTypeId' =>array( 
			'name'=>'EventTypeId',
			'value'=>'Yii::t("general", EventType::model()->findByPk($data->EventTypeId)->name)',
			'filter' => CHtml::listData(EventType::model()->findall(), 'id', 'name'),		
		), */
		'StatusId' =>array( 
			'name'=>'StatusId',
			'value'=>'Yii::t("general", EventStatus::model()->findByPk($data->StatusId)->name)',
			'filter' => CHtml::listData(EventStatus::model()->findall(), 'id', 'name'),		
		), 
		'Organization'=>array(          
			'header'=>Yii::t('general','Organization'), 
			'value'=> 'Organization::model()->findByPk($data->organizationId)->name',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN),
		), 
		'totalSum', 
		'Notes',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update1}',  
			'buttons'=>array(
				'update1'=>array(
					'label'=>Yii::t('general', 'Update'),				  
				    'url'=>'Yii::app()->createUrl("order/update", array("id"=>$data->id))',
					'options'=>array('class'=>'btn btn-xs btn-primary'),
				),
			),
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN), 
		),
		array(
			'class' => 'CCheckBoxColumn',
			'id' => 'itemId', 
		), 
	),
)); 
CHtml::endForm();
?>
