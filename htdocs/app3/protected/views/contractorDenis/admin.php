<?php
/* @var $this ContractorDenisController */
/* @var $model ContractorDenis */

$this->breadcrumbs=array(
	Yii::t('general','Contractor Denises')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('general','List ContractorDenis'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create ContractorDenis'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contractor-denis-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage Contractor Denises'); ?></h1>
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
	'id'=>'contractor-denis-grid',
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
		'name',
		'address',
		'phone',
		'email',
		'organizationId' =>array( 
			'name'=>'organizationId',
			'value'=>'Organization::model()->findByPk($data->organizationId)->name',
			'filter' => CHtml::listData(Organization::model()->findall(), 'id', 'name'),		
		),
		'userId' =>array( 
			'name'=>'userId',
			'value'=>'User::model()->findByPk($data->userId)->name',
			'filter' => CHtml::listData(User::model()->findall(), 'id', 'name'),		
		),
		/*
		'note',
		'inn',
		'kpp',
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
