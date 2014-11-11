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
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('general','$label')=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('general','List <?php echo $this->modelClass; ?>'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create <?php echo $this->modelClass; ?>'), 'url'=>array('create')),
	array('label'=>Yii::t('general','Update <?php echo $this->modelClass; ?>'), 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>Yii::t('general','Delete <?php echo $this->modelClass; ?>'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('general','Manage <?php echo $this->modelClass; ?>'), 'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo "; ?>Yii::t('general','View <?php echo $this->modelClass ."') . ' <em><u>'. \$model->{$nameColumn} . '</u></em>'; ?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
<?php

foreach($this->tableSchema->columns as $column)
{
	if(++$count==10) 
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
	elseif ($column->name == $this->tableSchema->primaryKey) 
		echo "\t\t// '".$column->name."',\n";
	elseif (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name)){ /* do nothing*/ } 
	elseif (stripos(mb_strtolower($column->dbType), 'tinyint') !== false)//($column->dbType =='tinyint')	
		echo "\t\t'{$column->name}' =>array(
			'name' => '{$column->name}',
			'value' => '(\$data->{$column->name} != 0) ?  Yii::t(\"general\",\"yes\") :  Yii::t(\"general\",\"no\") ',
			//'filter' => array(1=> Yii::t('general','yes'), 0=>Yii::t('general','no')),		
			),\n";
	else 
		echo "\t\t'".$column->name."',\n";
}
if($count>=10) 
	echo "\t\t*/\n";
?>
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
