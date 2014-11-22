<div class='col-md-12 tar_cat_bot2' >
	<!--div class="tar_cat_bot_title"><?php echo Yii::t('general', 'Car makes');?></div style='background: #f0f3f5; padding: 0 0 6px 6px;'  -->
		<div class='tar_cat_bot_form'><b>Легковые:</b></div>
			<div class='tar_cat_bot_lists'>					 
				<ul style='float: left;'>
			<?php 
				$criteria = new CDbCriteria;
				$criteria->compare('depth', 2);	
				$criteria->order = 'title ASC';			
				$criteria->select = array('title', 'id', 'parent_id');			
				$manufacturers = Assortment::model()->findAll($criteria);
				$makesgrAll=array(); $makesAll=array();												
				foreach($manufacturers as $m)
				{ 
					// все данные
					$Parent=Assortment::model()->findByPk($m->parent_id);
					if($Parent->title=='ГРУЗОВИКИ')
						$makesgrAll[$m->id] =  $m->title; 
					else 
						$makesAll[$m->id] =  $m->title; 
				/*	// находим все $makesgr и $makes для показа для отдельного производителя
					if (isset($_GET['id']) && 'site'==Yii::app()->controller->id ) 
					{
						if ($m->parent_id == $_GET['id']) 
						{ 
							if("ГРУЗОВИКИ"==$Parent->title)
								$makesgr[$m->id] =  $m->title; 
							else
								$makes[$m->id] =  $m->title;
						}	
					}
					*/ 						
				}			
				$i=1;
				if (!empty($makesAll)) 
				{		  											
					foreach ($makesAll as $key => $make) 
					{  
						echo '<li>' ,CHtml::Link($make, array('assortment/index', 'id'=>$key /*, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment'*/ )), '</li>'; 
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
				if (!empty($makesgrAll)) 
				{			
					$i=1;													
					foreach ($makesgrAll as $key => $make) 
					{ 														
						echo '<li>' ,CHtml::Link( $make, array('assortment/index', 'id'=>$key /*, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment'*/ )), '</li>'; 
						if (($i++ % 2 ) == 0) echo "</ul><ul style='float: left;'>";
					}
				}  ?>  
			 </ul>                                             
		 </div><!-- tar_cat_bot_lists-->
	 <div class='pad'></div>
</div><!-- col-md-12 -->