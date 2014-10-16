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

Yii::app()->clientScript->registerScript('search', "
$('input[id^=\"series_\"], input[id^=\"model_\"]').on('change', function() {
			$(this).next().toggle(); // это надо для раскрытия/скрытия под-чекбоксов
			var checked = $(this).is(':checked');
			if (checked == false ) {  $(this).next().find('input').removeAttr('checked')  }
			
	});  
");
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
		<td width='110'><br />		
		<?php echo CHtml::submitButton(Yii::t('general','Find'),  array('class'=>'red' )); ?>
		</td>
	</tr>
</table>
<?php

	if(isset($_GET['id'])) echo "<input name='id' type='hidden' value='{$_GET['id']}'>";  
	
	$nodes = Assortment::model()->findAllByAttributes(array('depth'=>3, 'parent_id'=>$_GET['id'], 'measure_unit'=>''));
	
	$seriesnodes = array();
	$simplenodes = array();
	$ar = array();
	
	foreach($nodes as $ser)
	{
		$subs = Assortment::model()->findAllByAttributes(array('depth'=>4, 'parent_id'=>$ser->id, 'measure_unit'=>'')); 
		if ($subs) 
			$seriesnodes[] = $ser; 
		else 
			$simplenodes[] = $ser;
	}
	
	// вывод кузовов без серий
	echo '<div>';
	foreach($simplenodes as $mod)
	{ 
		echo '<div style="float:left" >';
		
		$checked=0;
		if ($_GET['Body'] && in_array($mod->title, $_GET['Body'])) {
			$checked=1;
		}
		
		echo CHtml::label($mod->title ,"model_{$mod->title}");
		echo CHtml::checkBox("Body[{$mod->title}]", $checked , array('value'=>$mod->title,'uncheckValue'=>'0',  'id'=>"model_{$mod->title}"));
		echo '</div>';	 
	}
	echo '</div>'; 	
?> 
	<div style='clear:both; margin-bottom:5px; border-top: solid 1px black'> 
<?php
	// вывод кузовов посерийно
	echo '<div>';
	foreach($seriesnodes as $mod)
	{ 
		echo '<div style="float:left; font:inherit; border:0;  margin:0; vertical-align:baseline">';
		
		$checked=0;
		$display = 'none';
		if ($_GET['Series'] && in_array($mod->title, $_GET['Series'])) {
			$checked=1;			
			$display = 'block';
		}
		
		echo CHtml::label($mod->title ,"series_{$mod->title}");
		echo CHtml::checkBox("Series[{$mod->title}]", $checked , array('value'=>$mod->title,  'id'=>"series_{$mod->title}"));
		
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
			}  		
		echo '</div>';	 
	}
	echo '</div>';  // конец вывода кузовов посерийно 
	
	//echo CHtml::checkBox("Body[test]",0);
	

$this->endWidget(); ?>
</div>