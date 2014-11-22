<?php
/* @var $this UserController */
/* @var $model User 
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>
<h1><?php  echo Yii::t('general','Employees'); ?></h1><br />
<?php //echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button'));
echo CHtml::link(Yii::t('general','Create'), array('create'), array('class' => 'btn-win')); ?>
<div class="search-form" style="display:none">
<?php /*
$this->renderPartial('_search',array(
	'model'=>$model,
)); */ ?>
</div><!-- search-form -->
<?php 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=> $model->search(1), // Employees
	'filter'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){  		
		location.href = "'. $this->createUrl('update') .'/id/"+$.fn.yiiGridView.getSelection(id);	
	}',
	'columns'=>array( 
 		/*array(
                'header' => '№',
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),*/
		'id',
		'email',
		//'password',  
		'username'=>array(
			'header'=>Yii::t('general', 'Client'),
			'name'=>'username'
			),	  
		//'created', 
		'created'=> array(
				'name'=>'created',
				//'header'=>'Родитель',
				'filter'=>$model,
				'value'=>'substr($data->created, 0 , 10)',
			),
		'parentId' => array(
				'name'=>'parentId',
				'filter'=>CHtml::listData(User::model()->findAll('role = '. User::ROLE_SENIOR_MANAGER .' OR role = ' . User::ROLE_MANAGER), 'id', 'username'), 
				'value'=>'User::model()->findByPk($data->parentId)->username',
			),
		'role' => array(
				'name'=>'role',
			//	'header'=>'Роль',
				'filter'=>CHtml::listData(UserRole::model()->findall(), 'id', 'name'),
				'value'=>'UserRole::model()->findByPk($data->role)->name',
			),
		'isLegalEntity' => array(
			'name' => 'isLegalEntity',
			'value' => '($data->isLegalEntity == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")), //'нет', 'да'
		//	'header' => 'Активен',			
			),
		'organization'  => array(
				'name'=>'organization',
				'header'=>'Организация', 
				'filter'=>CHtml::listData(Organization::model()->findall(), 'id', 'name'),
				'value'=>'$data->organization ? Organization::model()->findByPk($data->organization)->name : "" ',
				'visible' => Yii::app()->user->checkAccess('1'),
			),
		'discount',  
/**/   'isActive' => array(
			'name' => 'isActive',
			'value' => '($data->isActive == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")),
			//'header' => 'Активен',			
			), 
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'visible'=> Yii::app()->user->checkAccess(User::ROLE_ADMIN), 
		),
	),
));  
?>
