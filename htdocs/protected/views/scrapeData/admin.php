<?php
/* @var $this ScrapeDataController */
/* @var $model ScrapeData */

$this->breadcrumbs=array(
	Yii::t('general','Scrape Datas')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List ScrapeData'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create ScrapeData'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#scrape-data-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Scrape Datas'); ?></h1>
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
	'id'=>'scrape-data-grid',
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
	    'id',
		'link',
		'marker',
		'created',
		'make',
		'model',
		'seria',
		'engine',
		/*
		'year',
		'owner',
		'phone',
		'isChecked',
		'isPaid' =>array( 
			'name'=>'isPaid',
			'value'=>'Ispa::model()->findByPk($data->isPaid)->name',
			'filter' => CHtml::listData(Ispa::model()->findall(), 'id', 'name'),		
		),
		'link',
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
