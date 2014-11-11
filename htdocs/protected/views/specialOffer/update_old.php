<?php
/* @var $this SpecialOfferController */
/* @var $model SpecialOffer */

$this->breadcrumbs=array(
	'Special Offers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SpecialOffer', 'url'=>array('index')),
	array('label'=>'Create SpecialOffer', 'url'=>array('create')),
	array('label'=>'View SpecialOffer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SpecialOffer', 'url'=>array('admin')),
);
?>

<h1>Update SpecialOffer <?php echo $model->id; ?></h1>
<h2><?php echo Yii::t('general','Update model instance with the advanced template'); ?></h2>

<?php $this->renderPartial('_form_old', array('model'=>$model)); ?>