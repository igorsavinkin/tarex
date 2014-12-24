<?php 
   $arr = explode('-', $data); 
   // подключаем EMagnificPopup если эта карта товара с изображением
   if('image'==$arr[0]) {
	  // if(!Yii::app()->clientScript->isScriptFileRegistered('jquery.magnific-popup.js')) 
			 $this->widget("ext.magnific-popup.EMagnificPopup", array('target' => '.test-popup-link'));
	  } 
   $item = Assortment::model()->findByPk((int)$arr[1]); 
?>

<div class="tar_image_form" id='info-popup-window'> 
        <!--div class="tar_in_head">
            <span><?php //echo Yii::t('general','Detailed Info'); ?></span>
            задесь была кнопка "закрыть"
            <div class="pad"></div>
        </div-->
        <div class="tar_image_in_form">
			<a style='float:right;padding:2px;' href="#" onclick="js:{ $('#info-popup-window').remove(); /* полностью удаляем(разрушаем) DOM элемент */ return false; }">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_x.png">
            </a>
            <div class="tar_in_text_1">  <?php  echo $item->title; ?>
            </div>
		<p class="tar_in_text_2"></p> 
		<?php  // если есть картинка то выводим её
			if ('image'==$arr[0]) : ?>
			<div style="border: 1px solid #344756; margin:0 0 0 3px; padding: 1px;float:left;"> 
				<?php
					if(!$item->Misc)
					{	// формируем тег ALT "на лету" если он пустой
						$item->Misc = $model->title .' - ' .$item->make . ' - ' . $item->model;
						$item->save(false);
					}
					$src= Yii::app()->baseUrl. '/img/foto/'. $item->article2 . '.jpg' ;
					echo "<a class='test-popup-link' href='{$src}'>" . CHtml::image($src , $item->Misc ,array("width"=>350)) . '</a>'; 
			    ?> 
			</div> 
	   <?php endif;?>
	<table style='float:left;margin:0 10px;'><tr class='odd-row' >
		<td style='width: 200px;'> 
		<b><?php echo $item->getAttributeLabel('model') ?>:</b></td><td> 
		<?php echo $item->model ?>
		
		</td></tr><tr><td> 
		<b><?php echo $item->getAttributeLabel('make') ?>:</b></td><td> 
		<?php echo $item->make ?>
		
		 </td></tr><tr class='odd-row'><td> 
		<b><?php echo $item->getAttributeLabel('measure_unit') ?>:</b></td><td> 
		<?php echo $item->measure_unit ?>
		
	</td></tr><tr><td> 
		<b><?php echo Yii::t('general', "Price"), ', ',Yii::t('general', "RUB"); ?>:</b></td><td> 
		<?php echo $item->getPrice(); ?>
		  
	</td></tr><tr class='odd-row'><td> 
		<b><?php echo $item->getAttributeLabel('warehouse') ?>:</b></td><td> 
		<?php echo $item->warehouse ?>
		
	</td></tr><tr><td> 
		<b><?php echo $item->getAttributeLabel('article2') ?>:</b></td><td> 
		<?php echo $item->article2 ?>
		 
	</td></tr><tr class='odd-row'><td> 
		<b><?php echo $item->getAttributeLabel('oem') ?>:</b></td><td> 
		<?php echo $item->oem ?>
		 
	</td></tr><tr><td> 
		<b><?php echo $item->getAttributeLabel('manufacturer') ?>:</b></td><td> 
		<?php echo $item->manufacturer ?>
		 
	</td></tr><tr class='odd-row'><td> 	
		<b><?php echo $item->getAttributeLabel('availability') ?>:</b></td><td> 
		<?php echo $item->availability - $item->reservedAmount; ?>
		
	 </td></tr><tr><td> 
		<b><?php echo $item->getAttributeLabel('country') ?>:</b></td><td> 
		<?php echo $item->country ?>
		</td> 
	</tr> 
	</table> 		   
</div><!-- tar_image_form -->	
 