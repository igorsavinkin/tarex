<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name; 
if (!Yii::app()->user->isGuest) echo '<div class="tar_adv tar_adv_second">';
?>
<div class="tar_cat_top">
	<div class="tar_cat_top_in">
		<div class="tar_cat_top_title">
		   <?php echo Yii::t('general', 'Manufacturers'); ?> 
		</div>
		<div class="tar_cat_top_lists">
			<ul class="tar_list_1">
			<?php 
			$criteria = new CDbCriteria;
			$criteria->order = 'id ASC';
			$criteria->condition = 'depth =1';	
			$i=0;											
			foreach (Assortment::model()->findAll($criteria) as $assort)
				{	   
					if (($i % 5) == 0 && $i>0) echo '</ul><ul class="tar_list_2">';
					$i++; 
					echo "<li><a href='" . Yii::app()->createUrl('site/index' , array( 'id'=>$assort->id )) . "'> " . Yii::t('general', $assort->title) . "</a></li>";	 
				}  ?>
				<span class="tar_cat_line"></span><?php										
			echo "<li><a href='" . Yii::app()->createUrl('site/index') . "'><font size='+1' face='Helvetica' >" . Yii::t('general', 'ALL MAKES') . "</font></a></li>";  ?> 
			</ul> 
			<div class="pad"></div>
		</div>
	</div>
</div>

<?php if(!Yii::app()->user->isGuest) echo '</div><!-- tar_adv tar_adv_second-->
<div class="tar_catalog_goods tar_catalog_goods_second" style="margin-left: 269px;">'; 
?>

<div class="tar_cat_bot">
	<div class="tar_brands_car">
		<div class="tar_cat_bot_title">
			 <?php 
				if (isset($_GET['id'])) 
				{ 
					$this->widget('zii.widgets.CBreadcrumbs', array(
						'links'=>array(Yii::t( 'general', 'All makes') => array('site/index'), 
							Assortment::model()->findByPk($_GET['id'])->title)
					));	
				} else 
					echo Yii::t('general', 'Car makes'); 
			?>
		</div>
			<div class="tar_cars">
				<div class="tar_cat_bot_form"><b>Легковые:</b></div>
				<div class="tar_cat_bot_lists">												
					<ul>
			<?php 
				$criteria = new CDbCriteria;
				$criteria->compare('depth', 2);	
				$criteria->order = 'title ASC';	
				$criteria->select = array('title', 'id', 'parent_id' );				
				$manufacturers = Assortment::model()->findAll($criteria);
				$makesgr=array(); $makes=array();												
				foreach($manufacturers as $m)
				{
					if (!isset($_GET['id'])) {
						$Parent=Assortment::model()->findByPk($m->parent_id);
						if($Parent->title=="ГРУЗОВИКИ"){
							$makesgr[$m->id] =  $m->title; 
						}else{
							$makes[$m->id] =  $m->title; 
						}															
					}
					elseif ($m->parent_id == $_GET['id']) {
						$Parent=Assortment::model()->findByPk($m->parent_id);
						if($Parent->title=="ГРУЗОВИКИ"){
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
						if (($i++ % 6 ) == 0) echo '</ul><ul>';
					}
				} 
				echo '</ul>'; ?>
			</div>
			<div class='pad'></div>
			<div class="tar_cat_bot_form"><b>Грузовые:</b></div>
				<div class="tar_cat_bot_lists">												
					<ul>
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
			<div class="pad"></div>
		</div>
	</div>
	<div class="pad"></div>
</div>
<?php if(!Yii::app()->user->isGuest) echo '</div><!-- tar_catalog_goods tar_catalog_goods_second -->'; ?>