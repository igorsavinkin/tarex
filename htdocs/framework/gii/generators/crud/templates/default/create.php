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
	Yii::t('general','Create'),
);\n"; ?>

$this->menu=array(
	array('label'=>Yii::t('general','List <?php echo $this->modelClass; ?>'), 'url'=>array('index')),
	array('label'=>Yii::t('general','Manage <?php echo $this->modelClass; ?>'), 'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo "; ?>Yii::t('general','Create <?php echo $this->pluralize($this->class2name($this->modelClass)); ?>'); <?php echo '?>' ?></h1>

<?php echo "<?php \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
