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

<div class="form">
<table><tr>
<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p class="note"><?php echo "<?php echo Yii::t('general','Fields with'); ?>"; ?><span class="required"> * </span><?php echo "<?php echo Yii::t('general','are required') .'.'; ?>"; ?></p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
$i = 0;
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?> 
	<td>
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>"; ?> 
		<?php //
		// если стоит слово 'noecho' в начале вывода функции, то тогда мы его отсекаем и выводим этот же шаблон ActiveField без 'есho' перед ним
		if (substr($this->generateActiveFieldCustom($this->modelClass,$column), 0, 6) == 'noecho')  
			echo "<?php ". substr($this->generateActiveFieldCustom($this->modelClass,$column), 6)."; ?>\n";			
		else 
			echo "<?php echo ".$this->generateActiveFieldCustom($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
	</td>

<?php
$i++; if(($i % 3) == 0) echo '</tr><tr>';
}
$controller=$this->class2name($this->modelClass);
$grid_id=$this->class2id($this->modelClass);
?>
	
	<td>	<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save')); ?>\n"; ?>
	</td>
	<td>	<?php echo "<?php echo CHtml::ajaxSubmitButton('ajaxSubmitButton', array('{$controller}/update', 'id'=> \$model->{$this->tableSchema->primaryKey}), array('success'  => 'js: function(data) { $(\"#locator\").html(data); } 
		function() { $.fn.yiiGridView.update(\"#{$grid_id}-grid\");}'
		)); ?>\n"; ?>
	</td>
</tr></table> 
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->