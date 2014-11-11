<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('general','{$label}')=>array('index'),
	Yii::t('general','Manage'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('general','List <?php echo $this->modelClass; ?>'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create <?php echo $this->modelClass; ?>'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#<?php echo $this->class2id($this->modelClass); ?>-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo "<?php echo "; ?>Yii::t('general','Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?>'); <?php echo '?>' ?></h1>
<h2><?php echo "<?php echo Yii::t('general', 'Manage model instances with the advanced template'); ?>"; ?></h2>
<p>
<?php echo "<?php echo "; ?> Yii::t('general','You may optionally enter a comparison operator'); <?php echo '?>' ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>, <b>=</b>) <?php echo "<?php echo "; ?> Yii::t('general', 'at the beginning of each of your search values to specify how the comparison should be done'); <?php echo '?>' ?>.
</p>

<?php echo "<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button')); ?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> 

 // добавим тег открытия формы
 echo CHtml::form();
 echo CHtml::submitButton('Bulk action button', array('name'=>'bulkAction', 'style'=>'float:right;'));
 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	//'rowCssClassExpression' => '$data->color',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows' => 2, // this makes user to select more than 1 checkbox in the grid
	'columns'=>array(
<?php
$count=0;
$amountArray = array('hour', 'amount');
echo " \t\tarray(
                'header' => '№',
                'value' => '\$row + 1 +
                    \$this->grid->dataProvider->pagination->currentPage
                    * \$this->grid->dataProvider->pagination->pageSize',
            ),\n";
foreach($this->tableSchema->columns as $column)
{
	if(++$count==8) 
		echo "\t\t/*\n";	
	if ($this->columnIsForeignKey($column)) 
	{	
		$colClass = $this->columnName2class($column->name);
		echo "\t\t'{$column->name}' =>array( 
			'name'=>'{$column->name}',
			'value'=>'{$colClass}::model()->findByPk(\$data->{$column->name})->name',
			'filter' => CHtml::listData({$colClass}::model()->findall(), 'id', 'name'),		
		),\n";
	}
	elseif ($column->autoIncrement) 
		echo "\t\t// '".$column->name."',\n";
	elseif ((stripos(mb_strtolower($column->name), 'hour') !== false) || (stripos(mb_strtolower($column->name), 'amount') !== false) || (stripos(mb_strtolower($column->name), 'sum') !== false))
	{
		echo "\t\t'{$column->name}' =>array( 
			'name'=>'{$column->name}',
			'footer'=>'<b>' . Yii::t('general','Total') . ' <span style=\"color:red\">' . {$this->modelClass}::getSumPlanHours(\$model->search()->getKeys()) . '</span>',
			// if gonna using 'footer' define the function getSumPlanHours() 
			// in your model class by this pattern:
			// если собираетесь использовать 'footer' то определите функцию
			// getSumPlanHours() в модели посредством этого шаблона:
			// public function getSumPlanHours(\$keys)
			//	{
			//		\$records=self::model()->findAllByPk(\$keys); 
			//		\$sum=0;
			//		foreach(\$records as $record) if(\$record->{$column->name}) $sum+=\$record->PlanHours;
			//		return \$sum;				
			//	}	
			),\n";
	}
	elseif (stripos(mb_strtolower($column->dbType), 'tinyint') !== false)//($column->dbType == 'tinyint')	
		echo "\t\t'{$column->name}' =>array(
			'name' => '{$column->name}',
			'value' => '(\$data->{$column->name} != 0) ?  Yii::t(\"general\",\"yes\") :  Yii::t(\"general\",\"no\") ',
			'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
			),\n";
	else 
		echo "\t\t'".$column->name."',\n";
}
if($count>=8) 
	echo "\t\t*/\n";
?>
		
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
