<?php 
/* @var $this AssortmentController */
/* @var $model Assortment */ 
$this->widget("ext.magnific-popup.EMagnificPopup", array('target' => '.test-popup-link'));

/********************************** start of the Dialog box ******************************/
?>
<div id='cart' class="tar_add_form"> 
	<div class="tar_in_head">
		<span><?php echo Yii::t('general','Add the assortment to a cart'); ?> </span>
		<a href="#" id='close' >
				<img src="images/tar_x.png">
		</a> 
	</div>
	<div class="tar_add_in_form" >
		<div class='tar_in_text_1'> 	
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'assortment-form',
				'enableAjaxValidation'=>false,
				'method'=>'post', 
			)); 
			echo $form->hiddenField($model, 'id'); ?>
	 
			<?php echo $form->labelEx($model, Yii::t('general','Amount')), '&nbsp;';  
			$data = array(); for($i=1; $i <= 100; $i++ ) { $data[$i] = $i; }		
			$this->widget('ext.select2.ESelect2', array(
					'model'=> $model,
					'attribute'=> 'amount',
					'data' => $data,
					'options'=> array(
						'allowClear'=>true, 
						'width' => '100', 
						'placeholder' => '', 
						),
				));	
			echo CHtml::submitButton(Yii::t('general', 'Add'), array('class'=>'red btn-medium btn-primary', 'style'=> ' margin-top: 15px;valign:middle;')); 
			$this->endWidget(); ?>	 
		</div><!-- tar_in_text_1-->
	</div><!-- tar_recover_in_form --> 
</div><!-- id='cart' -->
<style>

</style>
<?php
//********************** script for the popup Dialog **********************//
Yii::app()->clientScript->registerScript('dialog', "
$('#close').click(function(){	
	$('#cart').hide(); 
});

$('.to-cart').click(function(data){		
	
	//$('#cart').dialog('open');
	$('#cart').show();
	// we put the id value into the field
	var rx = /(\d+)$/;	
    var arr = rx.exec($(this).attr('id'));
	$('#Assortment_id').val(arr[1]);	

	return false;
});", CClientScript::POS_END);
 

/* Прежнее окно для ввода количества

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'cart',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>Yii::t('general','Add the assortment to a cart'),
        'autoOpen'=>false,
    ),
));
echo Yii::t('general', 'Enter the amount of this assortment item');?>

<div class="form ">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assortment-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'htmlOptions' => array(
       // 'enctype' => 'multipart/form-data',
    ),
)); 
	echo $form->hiddenField($model,'id'); ?>
	<div class="row"> 
	<?php echo $form->labelEx($model, Yii::t('general','Amount'));  
		$data = array(); for($i=1; $i <= 100; $i++ ) { $data[$i] = $i; }		
		$this->widget('ext.select2.ESelect2', array(
				'model'=> $model,
				'attribute'=> 'amount',
				'data' => $data,
				'options'=> array(
					'allowClear'=>true, 
					'width' => '100', 
					'placeholder' => '',
					//'minimumInputLength' => 3
					),
			));	
	echo CHtml::submitButton(Yii::t('general', 'Add'), array('class'=>'red btn-medium btn-primary', 'style'=> 'float:right;')); ?>
	</div>
</div>
<?php $this->endWidget();  

$this->endWidget('zii.widgets.jui.CJuiDialog');*/
/******************************** end of the Dialog box *************************************/
if ((Assortment::model()->findByPk($parent)) ) {
	$make =   Assortment::model()->findByPk($parent)->title; // echo 'make =' , $make;
	$add =Assortment::model()->findByPk($parent)->parent_id;
	$par =Assortment::model()->findByPk($add);
}
if ($parent && !isset($_GET['country']) ) 
{    
	$this->breadcrumbs=array( 
		//Yii::t( 'general', 'All makes') => array('/myFrontend', 'r'=>''),
		//$par->title => array('carbodynew', 'id'=>$par->id),
		$make
	);
} 
/*echo 'make = ' ,  $make->title, '<br/>';print_r($carModels);*/

//$this->renderPartial('_carmakes'); 
?> 


<div class='shift-right40'> 
	<h1 ><?php  echo Yii::t('contact','Assortment list'); ?></h1>
	<div class="search-form" style="display:block; padding-left:40px;"> 
	<?php $this->renderPartial('_search',array('model'=>$model, 'bodies'=>$bodies )); ?>
	</div><!-- search-form -->
</div><!-- shift-right40 --> 
<?php  
//  echo '<br> DProvider in view 1  count(<b>' , $dataProvider->itemCount , '</b>) = ' ; print_r($dataProvider->criteria); 
 
  	if (!empty($criteria) && !$dataProvider->itemCount /*&& $mainAssotrmentItem*/)	{
		//echo 'criteria '.$criteria->condition.'<br>';
		//print_r ($criteria->params);
		//$criteria->mergeWith($dataProviderOriginal->criteria);
		
		
		$dataProvider = new CActiveDataProvider('Assortment', array(
			'criteria'=>$criteria,
			 'pagination' => array(							
				'pageSize' =>isset($pagesize) ? $pagesize : Yii::app()->params['defaultPageSize'],
			 ),
		));		
	} 
	
	if(!empty($CriteriaAnalog) && $dataProvider->itemCount /*&& !$mainAssotrmentItem*/){
		$dataProvider = new CActiveDataProvider('AssortmentFake', array(	//'criteria'=>$criteria,
						'pagination' =>false, /* array(						
							'pageSize' =>$this->pagesize ? $this->pagesize : Yii::app()->params['defaultPageSize'],
						 ),*/ 
		));	
	
		$dataProviderAnalog = new CActiveDataProvider('Assortment', array(
						'criteria'=>$CriteriaAnalog,
						'pagination' =>false, /* array(						
							'pageSize' =>$this->pagesize ? $this->pagesize : Yii::app()->params['defaultPageSize'],
						 ),*/ 
		));	
	}

		
		
if ($dataProvider->itemCount)  
{   
	// echo '<br> DProvider in view before table = '; print_r($dataProvider->criteria);
	//echo '<br ><br >$dataProvider->getData() = '; print_r($dataProvider->getData()); //print_r($dataProvider->getData()); 
	
	//echo '<h1>' , Yii::t('general','Search item') , '</h1>'; // search element
	if (isset($_GET['findbyoem-value'])) echo '<h2>' , Yii::t('general','Requested number') , '</h2>'; // search element

	$url = CController::createUrl('index', array('id'=>isset($_GET['id']) ? $_GET['id'] :''));
	$findbyoemvalue = isset($_GET['findbyoem-value']) ?  $_GET['findbyoem-value'] : ''; 
	$findbyoemvalue = (isset($_GET['findbyoemvalue']) && $findbyoemvalue=='') ?  $_GET['findbyoem-value'] : ''; 
	//$_GET['findbyoemvalue'];	// Yii::app()->request->getParam('findbyoem-value');
	
	echo CHtml::Form();
	$url = Yii::app()->user->checkAccess(User::ROLE_SENIOR_MANAGER) ? $this->createUrl('update') : $this->createUrl('view'); 
	
	$this->widget('zii.widgets.grid.CGridView', array( 
		'id'=>'assortment-grid',
		'dataProvider'=>$dataProvider, /*,/*$model->search()*/
	//	'filter'=>$model,
		//lets tell the pager to use our own css file
        // 'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/gridview.css'),
        // the same for our entire grid. Note that this value can be set to "false"
        // if you set this to false, you'll have to include the styles for grid in some of your css files
        //'cssFile'=>false,
        'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',		
		'ajaxUrl'=>array('assortment/index'),
		//'pagination'=> array('pageSize'=>'20'),
		//'rowCssClassExpression' => '$data->color',
		'selectableRows'=>1,
		'selectionChanged'=>'function(id){  		
			location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id);	
		}',
		'columns'=>array(
			// 'id',
			'agroup',
			'groupCategory'=>array(
				'name'=>Yii::t('general', 'groupCategory') ,  
				'value'=>array($this, 'getCategoryById'),
			),
			//	'subgroup',
			//'depth',
			'title', 
		/*	'model',
			'series.series2', */
			//'country',
			//'measure_unit',
		  // 'article',
		    'article2'=>array(
				'name'=>'article2',
				'header'=>Yii::t('general','Article'),
			),
			'oem',
			'manufacturer',
			array(
				'value'=>'$data->getPrice()',
				'header' => Yii::t('general', 'Price'),
			),	 
			'availability'=>array(
				'name'=>'availability', 
			    'htmlOptions'=>array('style'=>'text-align:center'),
			  ),
		/*	'information'=>array(
				'header'=>Yii::t("general",'Foto'),
				'type'=>'html',
				'value'=>'(!empty($data->image)) ?  "<span class=\"picture-icon\"></span>"  . (!empty($data->schema)) ?  "<span class=\"picture-icon schema\"></span>"  ', //'<span class="info-picture"></span>',
		    	'htmlOptions' => array('style' => 'text-align:center; width: 20px'), 
			),*/
			
	    	'info'=>array(
				'header'=>Yii::t("general",'Info'),
				 'type'=>'html',
				'value'=>array($this, 'info'), 
			 ),	
	/*		 'foto'=>array(
				'header'=>Yii::t("general",'Foto'),
				 'type'=>'html',
			  'value'=>array($this, 'getImage'), 
			 //'value'=>'CHtml::tag("img", array("src" =>"/app3/img/foto/" . $data->article2 . ".jpg", "height"=>30, "width"=>30))',
			//'value'=>'CHtml::tag("img", array("src" =>"/app3/img/foto/thumbnails/AD01.5213.10.jpg.thumb_31x50.jpg", "height"=>30, "width"=>30))', 
			 //     'value'=>'(!empty($data->imageUrl)) ?  "<span class=\"picture-icon\"></span>"  :Yii::t("general", "no image")', //'<span class="info-picture"></span>',
		    	 'htmlOptions' => array('style' => 'text-align:center; width: 50px'),
			), 
			'showInSchema'=>array(
				'header'=>Yii::t("general",'Show in schema'),
				 'type'=>'html',
				'value'=>'(isset($data->schema)) ?  "<span class=\"picture-icon schema\"></span>"  :Yii::t("general", "schema is not yet ready")',
				//'<span class="info-picture"></span>',
		    	'htmlOptions' => array('style' => 'text-align:center; width: 20px'),
			),	*/
// new for getting into cart			
			array('header'=> CHtml::dropDownList('pageSize', 
				$pageSize,
				array( ' '=>  Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100, 10000=>Yii::t('general', 'all items')),
				array('onchange'=>"window.location.href = window.location.href + '&pageSize=' + $(this).val(); ",
				'options' => array('title'=>'Click me'),
				)),    //Yii::t("general",'Add to cart'),
			//	'visible'=>!($dataProvider->itemCount == 1 && $dataProvider->getData()[0]->avaliability == 0) , // видима если есть в наличии 
				
				'type'=>'raw',
				'value'=>array($this, 'amountToCartAjax'), //	'htmlOptions'=>array('width'=>'90px'),
			), 
			array('type'=>'raw',
				'value'=>'CHtml::hiddenField("BulkDelete[$data->id]",false,array(\'value\'=>$data->priceS))',
				'htmlOptions'=>array('style'=>'width:0%; display:none'),
				'headerHtmlOptions'=>array('style'=>'width:0%; display:none')
			),
			
			array(
				'class' => 'CCheckBoxColumn',
				'id' => 'Assortment[id]',	 
			), 
		/*	array( 
					'class'=>'ButtonColumn',
					'evaluateID'=>true,
					'template'=>'{' . Yii::t("general","add to cart") . '}', 
					'visible'=>Yii::app()->user->checkAccess(User::ROLE_SENIOR_MANAGER),
					'header'=>CHtml::dropDownList('pageSize', 
						$pageSize,
						array(' '=> Yii::t('general', 'items on page'), 20=>20, 50=>50, 100=>100),
						array('onchange'=>"window.location.href = document.URL + '&pageSize=' + $(this).val(); ",
						'options' => array('title'=>'Click me'),
						)), 
					'buttons'=>array(       
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
					),
				),*/  
		),
	));  
	echo CHtml::endForm();
}  
if (isset($dataProviderAnalog) && isset($dataProviderAnalog->itemCount) )
{
	//echo 'analogs';
	/*
	$show_msg = Yii::t('general', 'Show analogs');// will be used in 
	$hide_msg = Yii::t('general', 'Hide analogs');
	echo '<h3>', CHtml::Link($show_msg, '' , array('id'=>'show-analogs', 'class'=>'btn-win', 'style'=>'float:right;')); 
*/
?> 
	<div class="analogs-form" style="display:block">
	<?php $this->renderPartial('_analogs',array('model'=>$model,  'dataProviderAnalog'=>$dataProviderAnalog )); 		
	?></div>
	<!--/div><!-- search-form -->
<?php 
}  
/*if (!$dataProviderAnalog->itemCount && !$dataProvider->itemCount ) { 
	echo '<br /><div style="clear:both"></div>', Yii::t('general', 'There are no items corresponding to your request'), ' <b>', $_POST['findbyoem-value'], '</b>'; 
}*/
