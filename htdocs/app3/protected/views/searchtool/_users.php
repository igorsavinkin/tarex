<br><h2><?php  echo Yii::t('general','Customers'); ?></h2><?php
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$dataProviderUser,//$user->search(), //, //$model->search(),
	'filter'=>$user,
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){  		
		$.get("index.php?r=user/returnUsername&id="+$.fn.yiiGridView.getSelection(id) , 
				function(data) {
				  $( "#customerName" ).html("<em style=\'color:#b00000;\'>"+data+"</em>");	
				  $( "#customerName" ).parent().css({"border" : "2px solid #b00000", "padding": "3px 0px 3px 5px"});	
			  // добавляем id пользователя к ссылке создания заказа
				  var _href = $("#create-order").attr("href") + "&contractorId=" + $.fn.yiiGridView.getSelection(id);
				  $("#create-order").attr("href", _href);
			  // переходим к элементу на странице с id = "customerName"
				  jump("customerName");
				});
		return false;
	}',
    'columns'=>array( 
 		array(
                'header' => Yii::t('general', '#'),
                'value' => '$row + 1 +
                    $this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize',
            ),
		'id',		
		//'password',  
		'username'=>array(
			'header'=>Yii::t('general', 'Client'),
			'name'=>'username'
			),	  
		//'created', 
	/*	'created'=> array(
				'name'=>'created',
				//'header'=>'Родитель',
				'filter'=>$user,
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
			),*/
		'debtLimit'=>array(
			'header'=>Yii::t('general', 'Credit limit'),
			'name'=>'debtLimit',
			),	  
		'organization'  => array(
				'name'=>'organization', 
				'filter'=>CHtml::listData(Organization::model()->findall(), 'id', 'name'),
				'value'=>'$data->organization ? Organization::model()->findByPk($data->organization)->name : "" ',
				'visible' => Yii::app()->user->checkAccess(User::ROLE_ADMIN),
			),
	   'discount',  
   /*    'isActive' => array(
			'name' => 'isActive',
			'value' => '($data->isActive == 1) ? Yii::t("general", "yes") : Yii::t("general", "no") ',
			'filter' => array(1 => Yii::t("general", "yes") , 0 => Yii::t("general", "no")),
			//'header' => 'Активен',			
			), */
		'phone',
	//	'email',
		'address', 
	),
)); 

?>