<?php   
$columns=array('manufacturer', 'article2', 'title', 'Price', 'availability', 'make', 'oem', 'MinPart'); // ФИРМА  АРТИКУЛ  ОПИСАНИЕ  ЦЕНА(RUB)  КОЛИЧЕСТВО  МОДЕЛЬ ОРИГИНАЛЬНЫЙ_№  МИН_ПАРТИЯ
Yii::app()->clientScript->registerScript('jqueryui-sortable', "
   $(function() {
    $( '#sortable1, #sortable2' ).sortable({
      connectWith: '.connectedSortable'
    }).disableSelection();
  });
  
 $( '#sortable2'  ).sortable({
	remove: function( event, ui ) { 
		//console.dir(ui.item[0].getAttribute('name')); 
		var items = $(this).children('li').map(function(i,el){return el.getAttribute('name');}).get().join(','); 
		$('#PriceListSetting_columns').val(items);		
		console.log('remove: ' + items);
	},
    update:  function( event, ui ) { 
		//console.dir(ui.item[0].getAttribute('name')); 
		var items = $(this).children('li').map(function(i,el){return el.getAttribute('name');}).get().join(','); 
		$('#PriceListSetting_columns').val(items);		
		console.log('update: ' + items);
	}  
});
  
");
?><em><h5>Перетащите колонки вправо в порядке в котором они должны быть в прайсе. <br>Если ни одна колонка не задана, то выведутся все 8 колонок в прайсе.<h5></em>
<div class='pad'></div>
<ul id="sortable1" class="connectedSortable" style=''>
<center><label>Колонки для прайса</label></center><br>
<?php  
foreach($columns as $value)
{
	echo '<li name="'. $value .'" >', Assortment::model()->getAttributeLabel($value), '</li>';
} 
?>
</ul>
<div style='float:left;'>
	<center><label style='margin: 7px 0px 15px;'>Колонки в прайсе</label></center>
	<ul id="sortable2" class="connectedSortable">
	<?php 
	 if($model->columns) 
		foreach(explode(',' , $model->columns) as  $value)
			echo '<li name="'. $value .'" >', Assortment::model()->getAttributeLabel($value), '</li>';
	?>
	</ul>
</div>
 <style>

  </style>