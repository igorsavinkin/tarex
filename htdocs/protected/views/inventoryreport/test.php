<h1>Report on Warehouse</h1>
<div class="wide form">
<label><?php echo Yii::t('general','Warehouse'); ?></label> 
	<?php 
		if (!Yii::app()->user->checkAccess(User::ROLE_ADMIN)) 
			$condition = 'organizationId = ' . Yii::app()->user->organization;
		else
			$condition = '1=1'; 
	    $this->widget('ext.select2.ESelect2', array(
			//'model'=> $model,
			'name'=> 'Subconto1',
			'data' => CHtml::listData(Warehouse::model()->findAll($condition), 'id','name'),
			'options'=> array('allowClear'=>true, 
							    'width' => '150', 'select'=>'js: function(e) {
					console.log(e);
					console.dir(e);
					console.dir(this);
					alert(this);
			}',		
								'placeholder' => ''),
							
			//'select'=>'js: alert(this)',	   	 			
		));	
		echo '&nbsp;', CHtml::Link(Yii::t('general','Edit Warehouses') , array('warehouse/admin'), array('target'=>'_blank')); 
		?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'report-grid',
	'dataProvider'=>$dataProvider,
	'cssFile' => Yii::app()->baseUrl . '/css/gridview.css',
	'summaryText' => Yii::t('general','Elements') . " {start} - {end} " . Yii::t('general','out of') . " {count}.",
	'selectableRows'=>1,  
	'selectionChanged'=>'function(id){  
		/*** location.href = "' . $url .'/id/"+$.fn.yiiGridView.getSelection(id); ***/
		}',
));
?>
</div><!-- from -->
