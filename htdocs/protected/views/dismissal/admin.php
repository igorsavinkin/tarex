<?php
/* @var $this EventsController */
/* @var $model Events */
 
$this->pageTitle =Yii::t('general','Dismissal'); 

$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
    echo '<ul class="flashes">';
    foreach($flashMessages as $key => $message) {
        echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
    }
    echo '</ul>';
}     
?>
<h1><?php echo Yii::t('general','Dismissal'); ?></h1><br> 
<?php 
if (Yii::app()->user->role < 4) {
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
	echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn-win'));  
 	echo CHtml::link(Yii::t('general','Create') . ' ' . Yii::t('general', 'New' ) , array('create', 'id'=>'new'), array( 'class' => 'btn-win')); 
} 
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php 

// выбор действия которое надо применить при клике на запись в сетке
$url = $this->createUrl('update');  

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid', 
	'dataProvider'=> $model->search(), 
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css', 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ 		
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',
	'columns'=>array(
 		'id'=>array( 
			'header'=>Yii::t('general','#'), 
			'name'=>'id', 
		), 
		'Date'=>array( 
			'name'=>'Begin',		
			'header' => Yii::t('general', 'Date'), 		
		),  
		'author' => array( 
			'name'=>'author.username',
			'header'=>Yii::t('general','User in system, who lays off'), 
		),		 
		'contractorId' => array( 
			'header'=>Yii::t('general','User in system, whom to lay off'),
			'name'=>'contractorId',
			'value'=>'User::model()->findByPk($data->contractorId)->username',
		),
	/*   'EventTypeId' =>array( 
			'name'=>'EventTypeId',
		'value'=>'Yii::t("general",Eventtype::model()->findByPk($data->EventTypeId)->name)', 		
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
	/*	'totalSum'=>array(
			'name'=>'totalSum',
			'header'=> Yii::t('general','Salary')
		), */
		'Notes',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN), 
		),
	),
)); 
?>
