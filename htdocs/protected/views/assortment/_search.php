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

Yii::app()->clientScript->registerScript('search2', "
$('input[id^=\"series_\"]').on('change', function() { 

			name = $(this).attr('id').split('_')[1]; console.log( name  ); 			
			tr = $('#tr_'+name);
			tr.toggle();   // это надо для раскрытия/скрытия соответствующего tr
			var checked = $(this).is(':checked'); 
			if ( checked == false ) {  tr.find('input').removeAttr('checked')  } // здесь мы убираем галочки со всех чекбоксов
			
	});  	
", CClientScript::POS_END);
?>
<table width='300'><tr>
		<td valign="top"  width='110' style='padding:0 15px 0 15px'>
		<?php 		
			echo Yii::t('general','Part name'), '</br>'; // width="30%"
			echo $form->textField($model,'title').'</br>'; 
			?>
		</td>
		<!--td width='110' style='padding:0 15px 0 15px'> 
		<?php /*
			echo 'OEM </br>'; 
			echo $form->textField($model,'oem').'</br>';		
					*/
		?>
		</td-->
		<td width='110' style='padding:0 15px 0 15px'> 
		<?php
			echo Yii::t('general','Article'), '</br>';
			echo $form->textField($model,'article').'</br>'; ?>
		</td>
		<!--td width='110' style='padding:0 15px 0 15px'> 
		<?php  /*
		    $criteria = new CDbCriteria;
			$criteria->distinct = true;
			$criteria->order = 'subgroup ASC';
			$criteria->select = array('subgroup');
			$subs = Assortment::model()->findAll($criteria);  
			$translate=array_flip( array('OPTICS'=>'ОПТИКА',  
									'BRAKES'=>'ТОРМОЗНАЯ СИСТЕМА',  
									'ELECTRICS'=>'ЭЛЕКТРИКА',  
									'CAR BODY'=>'ДЕТАЛИ КУЗОВА',   
									'COOLING SYSTEM'=>'СИСТЕМА ОХЛАЖДЕНИЯ',    
									'CHASSIS SYSTEM'=>'ХОДОВАЯ СИСТЕМА',  
									'SUSPENSION SYSTEM'=>'СИСТЕМА ПОДВЕСКИ',  
									'HYDRAULIC SYSTEM'=>'ГИДРАВЛИЧЕСКАЯ СИСТЕМА'));
			
			if (Yii::app()->language == 'en_us' ) 
			{ 
				//echo 'Yii::app()->language  = ', Yii::app()->language ;
				$subsdata=array();
				foreach($subs as $sub)
				{
					$subsdata[$sub->subgroup] = isset($translate[$sub->subgroup]) ? $translate[$sub->subgroup] : $sub->subgroup; 
				} 
			}
			echo Yii::t('general','SubGroup'), '</br>';
			$this->widget('ext.select2.ESelect2', array(
			  'model'=> $model,
			  'attribute'=> 'subgroup',
			  'data' => isset($subsdata) ? $subsdata : CHtml::listData($subs , 'subgroup', 'subgroup'),
			  'options'=> array('allowClear'=>true, 
			   'width' => '200', 
			   'placeholder' => '', 
			   ),
			));  */ ?>
		</td-->
		<td width='110' style='padding:0 15px 0 15px'> 
		 <?php  echo Yii::t('general','SubGroup'), '</br>';
					$this->widget('ext.select2.ESelect2', array(
						'model' => $model,
						'attribute' => 'groupCategory',     
						'data' => Category::getCategoryLocale(),    
						'options'=> array('allowClear'=>true, 
							'width' => '250', 
				 			'placeholder' => ''), 
					)); ?> 
		</td>
		<td width='110'><br />		
		<?php echo CHtml::submitButton(Yii::t('general','Find'),  array('class'=>'red', 'name'=>'find-with-filter' )); ?>
		</td>
	</tr>
</table>
<?php

	if(isset($_GET['id'])) 	
	{
	    echo "<input name='id' type='hidden' value='{$_GET['id']}'>";  	
	    $nodes = Assortment::model()->findAllByAttributes(array('depth'=>3, 'parent_id'=>$_GET['id'], 'measure_unit'=>''));
	}
	$seriesnodes = array();
	$simplenodes = array();
	$ar = array();
	if(isset($nodes))
	{
		foreach($nodes as $ser)
		{
			$subs = Assortment::model()->findAllByAttributes(array('depth'=>4, 'parent_id'=>$ser->id, 'measure_unit'=>'')); 
			if ($subs) 
				$seriesnodes[] = $ser; 
			else 
				$simplenodes[] = $ser;
		}
	}
	?>
	<?php
//	print_r($seriesnodes);
	// вывод кузовов без серий
	if (count($simplenodes)) {
		echo '<div>';
		foreach($simplenodes as $mod)
		{ 
			echo '<div style="float:left" >';
			
			$checked=0;
			if (isset($_GET['Body']) && in_array($mod->title, $_GET['Body'])) {
				$checked=1;
			}
			
			echo CHtml::label($mod->title ,"model_{$mod->title}");
			echo CHtml::checkBox("Body[{$mod->title}]", $checked , array('value'=>$mod->title,'uncheckValue'=>'0',  'id'=>"model_{$mod->title}"));
			echo "</div>";	 
		}
		echo "</div>"; 
		//<div style='clear:both; margin-bottom:5px; border-top: solid 1px black'></div>"; 	
	}
?> 
	 
<?php
	// вывод кузовов посерийно
	if (count($seriesnodes)) 
	{  
		foreach($seriesnodes as $mod)
		{ 
			echo '<div style="float:left; font:inherit; border:0;  margin:0; vertical-align:baseline">';
			
			$checked=0;
			$display = 'none';
			if (isset($_GET['Series']) && in_array($mod->title, $_GET['Series'])) {
				$checked=1;			
				$display = 'block';
			}
			
			$minifiedTitle = str_replace(' ', '', $mod->title); // мы удаляем пробелы из названия чтобы потом не было пробелов в id = 'series_<$minifiedTitle>'
			echo CHtml::label($mod->title ,"series_{$mod->title}");
			echo CHtml::checkBox("Series[{$mod->id}]", $checked , array('value'=>$mod->title,  'id'=>"series_{$minifiedTitle}"));
			/*
				// здесь мы выводим под-чекбоксы для кузовов
				$subnodes = Assortment::model()->findAllByAttributes(array('depth'=>4, 'parent_id'=>$mod->id, 'measure_unit'=>''));
				if( $subnodes ) {
				
					echo "<div style='display:{$display};'>";
					
					
					foreach($subnodes  as  $item)
					{
						//echo 'title '.$item->title;
						echo '<div>';
						$checked=0;
						if ($_GET['Body'] && in_array($item->title, $_GET['Body'])) {
							$checked=1;
						}
						echo '&nbsp;&nbsp;', CHtml::label($item->title, "body_{$item->title}"  );
						
						echo CHtml::checkBox("Body[{$item->title}]", $checked , array('value'=>$item->title, 'id'=>"body_{$item->title}") ) , '<br>';
						//echo CHtml::checkBox("Body[{$item->title}]", $checked , array('value'=>$item->title, 'uncheckValue'=>'0' , 'id'=>"body_{$item->title}") ) , '<br>';
						
						echo '</div>';
					}
					echo '</div>'; // конец под-чекбоксов  
				}  		*/
			echo "</div>";	 
		}
		echo "</div>
		<div style='clear:both; margin-bottom:5px; border-top: solid 1px black'></div>";  // конец вывода кузовов посерийно 
	}
	?>
		
	<?php
// начало нового вывода	
	if (!empty($seriesnodes)) 
	{
		echo "<div id='inline-output' class='wide form' ><table>";
		foreach($seriesnodes as $key => $mod)
		{
			$display = 'none';
			if (isset($_GET['Series']) && in_array($mod->title, $_GET['Series'])) {		
				$display = 'block';
			} 
			?>
			<tr id='tr_<?php echo str_replace(' ', '', $mod->title); ?>' style='display:<?php echo $display; ?>;' ><td valign='top'>
			<?php 
				echo $mod->title;
			?> 
			</td><td valign='top'> 
			<?php
			// здесь мы выводим под-чекбоксы для кузовов
			$subnodes = Assortment::model()->findAllByAttributes(array('depth'=>4, 'parent_id'=>$mod->id, 'measure_unit'=>''));      
				if( $subnodes ) {
					//echo "<div style='display:block;'>"; 
					foreach($subnodes as $item)
					{ 
						echo '<div style="float: left; display:inline-block;">';
						$checked=0;
						if (isset($_GET['Body']) && array_key_exists($item->title, $_GET['Body'])  /*in_array($item->title, $_GET['Body'])*/ ) {
							$checked=1;
						} 
						echo/* '&nbsp;&nbsp;', */ CHtml::label($item->title, "body_{$item->title}"  );
						
						echo CHtml::checkBox("Body[{$item->title}]" /* $item->title*/,  $checked , array('value'=>$mod->id /*$item->title */, 'id'=>"body_{$item->title}") ) ; //, '<br>';
						//echo CHtml::checkBox("Body[{$item->title}]", $checked , array('value'=>$item->title, 'uncheckValue'=>'0' , 'id'=>"body_{$item->title}") ) , '<br>';
						
						echo '</div>'; 
					}
					//echo '</div><br/><br>'; // конец под-чекбоксов   
				} 
				?>
			</td></tr>	
			<?php
			//echo '</div>';		
		} 
		echo '</table></div>';// end id=inline-output
	} 	

$this->endWidget(); ?>
</div>