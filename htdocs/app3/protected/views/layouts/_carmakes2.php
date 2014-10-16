<div class='row'> 
	<div class='col-md-12' style='background: #E5F5FF; padding: 6px 0 6px 6px;'>
		<div class="tar_cat_bot_title"><?php echo Yii::t('general', 'Car makes');?></div>
	  		<div class='tar_cat_bot_form'><b>Легковые:</b></div>
				<div class='tar_cat_bot_lists'>					 
					<ul style='float: left;'>
				<?php 
					$criteria = new CDbCriteria;
					$criteria->compare('depth', 2);	
					$criteria->order = 'title ASC';			
					$criteria->select = array('title', 'id');			
					$manufacturers = Assortment::model()->findAll($criteria);
					$makesgr=array(); $makes=array();												
					foreach($manufacturers as $m)
					{ 
						$Parent=Assortment::model()->findByPk($m->parent_id);
						if($Parent->title=='ГРУЗОВИКИ')
							$makesgr[$m->id] =  $m->title; 
						else 
							$makes[$m->id] =  $m->title; 
					}			
					$i=1;
					if (!empty($makes)) 
					{		  											
						foreach ($makes as $key => $make) 
						{  
							echo '<li>' ,CHtml::Link($make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment')), '</li>'; 
							if (($i++ % 5 ) == 0) echo "</ul><ul style='float:left;'>";
						}
					}  ?>
					</ul>
				</div><!-- tar_cat_bot_lists -->
				<div class='pad'></div>
				<div class='tar_cat_bot_form'><b>Грузовые:</b></div>
				<div class='tar_cat_bot_lists'>												
					<ul style='float: left;'>
					<?php 
					if (!empty($makesgr)) 
					{			
						$i=1;													
						foreach ($makesgr as $key => $make) 
						{ 														
							echo '<li>' ,CHtml::Link( $make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment')), '</li>'; 
							if (($i++ % 2 ) == 0) echo "</ul><ul style='float: left;'>";
						}
					}  ?>  
				 </ul>                                             
			 </div><!-- tar_cat_bot_lists-->
		 <div class='pad'></div>
	</div><!-- col-md-12 -->
</div>  