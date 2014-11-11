<div class='row'> 
<div class='col-md-12' style='background: #f0f3f5; padding: 16px 0 0 10px;'>
	  
	     <div class='tar_brands_car'> 
	         <div class='tar_cat_bot'>
				<div class='tar_cat_bot_title'>
					 <?php echo Yii::t('general', 'Car makes'); ?>
				</div>
				<div class='tar_cars'>
				<div class='tar_cat_bot_form'><b>Легковые:</b></div>
				<div class='tar_cat_bot_lists'>												
					<ul style='float: left;'>
				<?php 
					$criteria = new CDbCriteria;
					$criteria->compare('depth', 2);	
					$criteria->order = 'title ASC';			
					$manufacturers = Assortment::model()->findAll($criteria);
					$makesgr=array(); $makes=array();												
					foreach($manufacturers as $m)
					{
						if (!isset($_GET['id'])) {
							$Parent=Assortment::model()->findByPk($m->parent_id);
							if($Parent->title=='ГРУЗОВИКИ'){
								$makesgr[$m->id] =  $m->title; 
							}else{
								$makes[$m->id] =  $m->title; 
							}															
						}
						elseif ($m->parent_id == $_GET['id']) {
							$Parent=Assortment::model()->findByPk($m->parent_id);
							if($Parent->title=='ГРУЗОВИКИ'){
								$makesgr[$m->id] =  $m->title; 
							}else{
								$makes[$m->id] =  $m->title; 
							}														
						}
					}			
					$i=1;
					if (!empty($makes)) 
					{		  											
						foreach ($makes as $key => $make) 
						{  
							echo '<li>' ,CHtml::Link( $make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment')), '</li>'; 
							if (($i++ % 6 ) == 0) echo "</ul><ul style='float:left;'>";
						}
					} 
					echo '</ul>'; ?>
				</div>
				<div class='pad'></div>
				<div class='tar_cat_bot_form'><b>Грузовые:</b></div>
				<div class='tar_cat_bot_lists'>												
					<ul style='float: left;' >
					<?php
					if (!empty($makesgr)) 
					{			
						$i=1;													
						foreach ($makesgr as $key => $make) 
						{ 														
							echo '<li>' ,CHtml::Link( $make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment')), '</li>'; 
							if (($i++ % 3 ) == 0) echo '</ul><ul>';
						}
					}  	 				
					echo '</ul>';?>                                               
				</div><!-- tar_cat_bot_lists-->
				<div class='pad'></div>
			</div>
		</div><!-- tar_cat_bot -->
	</div> <!-- tar_brands_car-->	
</div><!-- col-md-12 -->
</div>	