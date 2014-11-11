<?php
$Reference=$_GET['Reference'];
$ModelEventTypes=Eventtype::model()->FindByAttributes(array('Reference'=>$Reference));
$UserRole=Yii::app()->user->role;
		
		

$this->pageTitle =Yii::t('general', $ModelEventTypes->name);
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

//$eventtype=$app->session['Reference'];
//echo '1'.$Reference;

?>


<?php 

if(Yii::app()->user->role<6){
	echo '<em>' , Yii::t('general',$ModelEventTypes->name).'<br><br>';
	
	echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn-win')); 
	echo CHtml::link(Yii::t('general','Create') , array('create', 'eventtype'=>$ModelEventTypes->id), array('class' => 'btn-win')); 
}
?>

<div class="search-form" style="display:none">
<?php 

$this->renderPartial('_search',array(
	'model'=>$model,
)); 

?>
</div><!-- search-form -->

<?php 

 // добавим тег открытия формы
 echo CHtml::form();

// выбор действия которое надо применить при клике на запись в сетке
 $action = 'update';  
 $url = $this->createUrl($action);
 
 
// конец выбора действия которое надо применить при клике на запись в сетке
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'events-grid',
	'dataProvider'=>$model->search(),
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){ 
	//		$StatusId=$.fn.yiiGridView.getSelection(StatusId)
		
		location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);
	
	
	}',
	'columns'=>array(
 		/*array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),*/

		'id',
		'Begin',
		//'contractorId',
		//'authorId',
		
		//'EventTypeId',
		'author.username',
		'contractorId' =>
		array( 
			'name'=>'contractorId',
			'value'=>'User::model()->findByPk($data->contractorId)->username',
			//'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'name'),		
		),

		'StatusId' =>array( 
			'name'=>'StatusId',
			'value'=>'EventStatus::model()->findByPk($data->StatusId)->name',
			//'filter' => CHtml::listData(EventStatus::model()->findall(), 'id', 'name'),		
		),

		'totalSum', 
		
	),
)); 




// добавим тег закрытия формы
	echo CHtml::endForm();
?>
