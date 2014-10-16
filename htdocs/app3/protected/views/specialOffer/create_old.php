<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */

$this->breadcrumbs=array(
	'Special Offers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SpecialOffer', 'url'=>array('index')),
	array('label'=>'Manage SpecialOffer', 'url'=>array('admin')),
);
?>

<h1>Create SpecialOffer</h1>
<h2><?php echo Yii::t('general','Create a model instance with the advanced template'); ?></h2>
<?php $this->renderPartial('_form_advanced', array('model'=>$model)); ?>