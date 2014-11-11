<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<div class="wide form">
<table><tr>
<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php 
$i = 0;
foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<td>
		<?php echo "<?php echo \$form->label(\$model,'{$column->name}'); ?>\n"; ?>
		<?php 
		// если впереди стоит слово 'noecho' в начале вывода функции, то тогда мы его отсекаем и выводим этот же шаблон ActiveField без 'есho' перед ним
		if (substr($this->generateActiveFieldCustom($this->modelClass,$column), 0, 6) == 'noecho')  
			echo "<?php ". substr($this->generateActiveFieldCustom($this->modelClass,$column), 6)."; ?>\n";			
		else 
			echo "<?php echo ".$this->generateActiveFieldCustom($this->modelClass,$column)."; ?>\n"; ?>
	</td>

<?php
$i++; if(($i % 3) == 0) echo '</tr><tr>';
 endforeach; ?>
	<td>
		<?php echo "<?php echo CHtml::submitButton(Yii::t('general','Search')); ?>\n"; ?>
	</td>
</tr></table> 
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- search-form -->