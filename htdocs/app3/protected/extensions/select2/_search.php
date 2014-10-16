<?php
/* @var $this AssortmentController */
/* @var $model Assortment */
/* @var $form CActiveForm */
?>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));	

echo '<table border="0" width="100%"><tr><td >';	
			echo 'Марка автомобиля</br>';
			$GroupArray = CHtml::listData(AssortmentGroups::model()->findAll(), 'id', 'name');
			//echo $form->CheckBoxList($model, 'agroup', $GroupArray/*,  array('multiple'=>'multiple',) */);
				// Working with model SELECT2 
				   $this->widget('ext.select2.ESelect2',array(
				  // 'id' => 'e18_2',
				 'name' => 'Assortment[agroup]',
			     'model'=>$model,
				 'options'=> array('allowClear'=>true,/* 'multiple'=> true , 'tags' => ''*/
											'width' => '200', 
											'placeholder' => '',
											'minimumInputLength' => 3),
				 'data'=>$GroupArray,
				  'htmlOptions'=>array( 
						 'multiple'=>'multiple',
					   ),  
				));   
				?>
		</td>
		<td valign="top" style='padding:0 15px 0 15px'>
			<?php echo '   Категория запчасти</br>';
			$SubgroupArray = CHtml::listData(AssortmentSubgroups::model()->findAll(), 'name', 'name');
			 $this->widget('ext.select2.ESelect2',array(
				 'name' => 'Assortment[subgroup]',
			     'model'=>$model,
				  'options'=> array('allowClear'=>true, 
											   'width' => '200', 
											   'placeholder' => '',
											   'minimumInputLength' => 3),
				  'data'=>$SubgroupArray,
				  'htmlOptions'=>array( 
						 'multiple'=>'multiple',
					   ),  
				)); 
			//echo $form->textField($model, 'subgroup'); 
			//echo $form->dropDownList($model, 'subgroup', $SubgroupArray);//CheckBox?>
		</td>
		
		<td >
		<?php echo '   Наименование</br>'; // width="30%"
			$TitleArray = CHtml::listData(Assortment::model()->findAll(), 'title', 'title');
			 $this->widget('ext.select2.ESelect2',array(
				'name' => 'Assortment[title]',
			    'model'=>$model,
				
				'options'=> array('allowClear'=>true, 
											'width' => '200', 
											'placeholder' => '',
											'minimumInputLength' => 3,),
				'data'=>$TitleArray,
				 /* 'htmlOptions'=>array( 
						 'multiple'=>'multiple',
					   ),  */
				)); 
			//echo $form->textField($model, 'subgroup'); 
			//echo $form->dropDownList($model, 'subgroup', $SubgroupArray);//CheckBox?>
		</td>
	</tr>
</table>
<?php echo '</br>'. CHtml::submitButton('Выбрать', array('class' => 'btn btn-small btn-info'/*,'style'=> 'float:right;'*/)); ?>
<?php $this->endWidget(); ?>

</div><!-- search-form -->