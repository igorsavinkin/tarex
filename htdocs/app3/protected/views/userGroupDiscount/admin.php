<?php
/* @var $this UserGroupDiscountController */
/* @var $model UserGroupDiscount */

$this->breadcrumbs=array(
	Yii::t('general','User Group Discounts')=>array('index'),
	Yii::t('general','Manage'),
); 
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-group-discount-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo Yii::t('general','Manage') , ' ',  Yii::t('general','User Group Discounts'); ?></h1>
 
<p>
<?php echo  Yii::t('general','You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>, <b>=</b>) <?php echo  Yii::t('general', 'at the beginning of each of your search values to specify how the comparison should be done'); ?>.
</p>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button'));echo CHtml::link(Yii::t('general','Create'),array('create'),array('class'=>'btn-win')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(	'model'=>$model,)); ?>
</div><!-- search-form -->

<?php 

 // добавим тег открытия формы
 echo CHtml::form();
  echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-group-discount-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model, 
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'htmlOptions'=>array('class'=>'grid-view grid-size-500'), 
	'columns'=>array(
 		array(
			'header' => '№',
			'value' => '$row + 1 +
				$this->grid->dataProvider->pagination->currentPage
				* $this->grid->dataProvider->pagination->pageSize',
		),
	    'id',
	 	'userId' =>array( 
			'name'=>'userId',
			'value'=>'User::model()->findByPk($data->userId)->username',
			'filter' => CHtml::listData(User::model()->findall(array('order'=>'username ASC','condition'=> '`role`=' . User::ROLE_USER)), 'id', 'username'),		
		), 
		'discountGroupId' =>array( 
			'name'=>'discountGroupId',
			'value'=>'DiscountGroup::model()->findByPk($data->discountGroupId)->name',
			'filter' => CHtml::listData(DiscountGroup::model()->findall(), 'id', 'name'),		
		),
		'value',
		
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
