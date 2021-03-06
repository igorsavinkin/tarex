<h1><?php echo Yii::t('general','Special Offer items'); ?></h1>
<?php 
	echo CHtml::form();
	if (Yii::app()->user->checkAccess(User::ROLE_MANAGER)) 
	{
		echo CHtml::link(Yii::t('general','Load articles of special offer from file'), array('loadSpecialOffer'), array('class' => 'btn-win'));  
		echo CHtml::/*ajax*/SubmitButton(Yii::t('general','Bulk remome Special Offer mark'), /* '','',*/ array( 'name'=>'bulk-remome-special-offer', 'class' => 'red', 'style'=>'float:right'));  
	}
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'assortment-grid-analogs',		 
		'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',		
		'dataProvider'=>$model->search(1), // we set the Special Offer flag - search(1)
	    'filter'=>$model,  
	    'selectableRows'=>2,
		//'pagination'=> array('pageSize'=>'20'),
		'columns'=>array(
			// 'id',
			'agroup',
			//'subgroup',//'depth',
			'title',
			//'country',
			//'measure_unit',
			'article',
			'oem',
			'manufacturer',
			'availability',
			'info'=>array(
				'header'=>Yii::t("general",'Info'),
				 'type'=>'html',
				'value'=>array($this, 'info'), 
			 ),	
		 /*   'foto'=>array( 
				'header'=>Yii::t("general",'Foto'),
				'type'=>'html',
				'value'=>'(!empty($data->image)) ?  "<span class=\"picture-icon\"></span>"  :Yii::t("general", "no image")', //'<span class="info-picture"></span>',
		    	'htmlOptions' => array('style' => 'text-align:center; width: 20px'),
			), 
			'showInSchema'=>array(
				'header'=>Yii::t("general",'Show in schema'),
				 'type'=>'html',
				'value'=>'(isset($data->schema)) ?  "<span class=\"picture-icon schema\"></span>"  :Yii::t("general", "schema is not yet ready")',
				//'<span class="info-picture"></span>',
		    	'htmlOptions' => array('style' => 'text-align:center; width: 20px'),
			),*/
			/*'availability2' => array(
						'name' => 'availability',
						'value' => '($data->availability==1) ? Yii::t("general", "yes") : Yii::t("general", "no")',
						'filter' => array(0 =>Yii::t('general', 'no'), 1=>Yii::t('general', 'yes')),
						'htmlOptions' => array('style' => 'text-align:center; width: 20px'),
						),*/
			//'priceS',
			//'currentPrice',
			array(
				'value'=>'$data->getPrice()',
				'header' => Yii::t('general', 'Price'),
			),
			// new for getting into cart			
			array('header'=> CHtml::dropDownList('pageSize', 
				$pageSize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100, 10000=>Yii::t('general', 'all items')),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val(); ",
				'options' => array('title'=>'Click me'),
				)),    //Yii::t("general",'Add to cart'),
				'type'=>'raw',
				'value'=>array($this, 'amountToCartAjax'), //	'htmlOptions'=>array('width'=>'90px'),
			), 		
			 array(
				'class' => 'CCheckBoxColumn',
				'id' => 'Assortment[id]',	 
			),  
			
		//	'price',
	  /*		array(
					'class'=>'ButtonColumn',
					'evaluateID'=>true,
					'template'=>'{' . Yii::t("general","add to cart") . '}', 
					'visible'=>Yii::app()->user->checkAccess(User::ROLE_SENIOR_MANAGER),		
					'header'=>CHtml::dropDownList('pageSize', 
						$pageSize,
						array(' '=>  Yii::t('general', 'items on page') ,  50=>50, 100=>100),
						array('onchange'=>"$.fn.yiiGridView.update('assortment-grid-analogs',{ data:{pageSize: $(this).val() }, url:'{$url}' })" )
						),
					'buttons'=>array(       
							'update' => array(
							  'url'=>'Yii::app()->controller->createUrl("assortment/update", array("id"=>$data[id]))',
							),
							'delete' => array(
							  'url'=>'Yii::app()->controller->createUrl("assortment/delete", array("id"=>$data[id],"command"=>"delete"))',
							  'visible'=>Yii::app()->user->checkAccess('4'), // ������� ���������� ������������ ����� ������ ������� ��������
							), 
							Yii::t('general','add to cart') => array(
								'url'=>'"#"', //'Yii::app()->controller->createUrl("/assortment/index2", array("assort"=>$data[id], "id"=>"'. $parent . '" ))',
								 'imageUrl' => Yii::app()->baseUrl . '/img/cart.gif',
								'options'=>array( 'id'=>'\'some-class-\'.$data->id', 'class'=>"to-cart"),
							    'visible'=>'$data->availability != 0',
							    'click'=>"js:function(){
									$.fn.yiiGridView.update('assortment-grid', { 
										type:'POST',
										url:$(this).attr('href'),
										data['YII_CSRF_TOKEN'] = ". Yii::app()->request->getCsrfToken() . ";
									});
									return false;
								  }
								",  
							),
							
							//data['YII_CSRF_TOKEN'] = ". Yii::app()->request->csrfToken . ";
					),
				), */
		),
	));	
	echo CHtml::endForm();
	?>