<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo 'Error message: ', CHtml::encode($message); ?>
<?php echo '<br/>Error file: ',CHtml::encode($file); ?>
<?php echo '<br/>Error line: ', CHtml::encode($line); ?>
</div>