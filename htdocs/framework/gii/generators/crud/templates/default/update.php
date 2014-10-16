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
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	Yii::t('general','Update'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('general','List <?php echo $this->modelClass; ?>'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Create <?php echo $this->modelClass; ?>'), 'url'=>array('create')),
	array('label'=>Yii::t('general','View <?php echo $this->modelClass; ?>'), 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>Yii::t('general','Manage <?php echo $this->modelClass; ?>'), 'url'=>array('admin')),
);

?>
<h1><?php echo "<?php echo "; ?>Yii::t('general','View <?php echo $this->modelClass ."') . ' <em><u>'. \$model->{$this->tableSchema->primaryKey} . '</u></em>'; ?>"; ?></h1>
<h1><?php// echo "<?php echo ". Yii::t('general','Update') . $this->modelClass." <?php echo \$model->{$this->tableSchema->primaryKey}; ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>