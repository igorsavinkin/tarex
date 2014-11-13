<?php
/* @var $this DiscountGroupController */
/* @var $model DiscountGroup */

$this->breadcrumbs=array(
	Yii::t('general','Discount Groups')=>array('index'),
	Yii::t('general','Manage'),
); 

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#discount-group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage'), ' ',  Yii::t('general','Discount Groups'); ?></h1>
 
<p>
<?php echo  Yii::t('general','You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>, <b>=</b>) <?php echo  Yii::t('general', 'at the beginning of each of your search values to specify how the comparison should be done'); ?>.
</p>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button'));echo CHtml::link(Yii::t('general','Create'),array('create'),array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 

 // добавим тег открытия формы
 echo CHtml::form();
 //echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'discount-group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.", 
	'selectableRows'=>1,
		'selectionChanged'=>'function(id){  		
			location.href = "' . $this->createUrl('update') .'/id/"+$.fn.yiiGridView.getSelection(id);	
		}',
	'columns'=>array(
 		array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		// 'id',		
		'name',	
		'prefix',
		array(
			'header'=>Yii::t('general','Articles'),
			'value'=>'substr($data->articles, 0 ,70) . "..." ',
		), 
		/*'articles',*/
		'value',
		'isActive',
		
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
