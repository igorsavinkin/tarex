<?php
/* @var $this EventContentController */
/* @var $model EventContent */

$this->breadcrumbs=array(
	Yii::t('general','Event Contents')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List EventContent'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create EventContent'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#event-content-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Event Contents'); ?></h1>
<h2><?php echo Yii::t('general', 'Manage model instances with the advanced template'); ?></h2>
<p>
<?php echo  Yii::t('general','You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>, <b>=</b>) <?php echo  Yii::t('general', 'at the beginning of each of your search values to specify how the comparison should be done'); ?>.
</p>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); ?>
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
	'id'=>'event-content-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		// 'id',
		'eventId',/* =>array( 
			'name'=>'eventId',
			//'value'=>'Events::model()->findByPk($data->eventId)->Subject',
			'filter' => CHtml::listData(Events::model()->findall(), 'id', 'eventId'),		
		)*/
		'eventSubject' =>array( 
			//'name'=>'eventSubject',
			'value'=>'Events::model()->findByPk($data->eventId)->Subject',
			'filter' => CHtml::listData(Events::model()->findall(), 'id', 'Subject'),		
		),
		'assortment.article2',
		'assortmentId' ,
		'assortmentId' =>array( 
			'name'=>'assortmentId',
			'value'=>'Assortment::model()->findByPk($data->assortmentId)->title',
			'filter' => CHtml::listData(Assortment::model()->findall(), 'id', 'title'),		
		),
		'assortmentTitle',
		'assortmentAmount' =>array( 
			'name'=>'assortmentAmount',
		//	'footer'=>'<b>' . Yii::t('general','Total') . ' <span style="color:red">' . EventContent::getSumPlanHours($model->search()->getKeys()) . '</span>',
			// if gonna using 'footer' define the function getSumPlanHours() 
			// in your model class by this pattern:
			// если собираетесь использовать 'footer' то определите функцию
			// getSumPlanHours() в модели посредством этого шаблона:
			// public function getSumPlanHours($keys)
			//	{
			//		$records=self::model()->findAllByPk($keys); 
			//		$sum=0;
			//		foreach($records as ) if($record->assortmentAmount) +=$record->PlanHours;
			//		return $sum;				
			//	}	
			),
		'discount',
		'price',
		
		'cost',
	/*	'cost_w_discount',
		'RecommendedPrice',
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
