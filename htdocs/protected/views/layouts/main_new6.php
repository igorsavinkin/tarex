
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />		

	<meta name="keywords" content="" />
	<meta name="description" content="" />
	
	<title>Tarex v.2.5.6</title>
	
    <link rel="shortcut icon" type="image/ico" href="/app2/img/favicon.ico">

	<!-- blueprint CSS framework --> 
	<link rel="stylesheet" type="text/css" href="/app2/css/form.css" /> 
	<link rel="stylesheet" type="text/css" href="/app2/css/style_n.css" />
	
	<script type="text/javascript" src="assets/35648952/jquery.js"></script>
	<script type="text/javascript" src="assets/35648952/jquery.yii.js"></script> 
 	
	<script type="text/javascript" src="/app2/css/SearchByVin.js"></script>
	<!--script src="js/slider.js"></script>
	<script src="js/jquery.flexislider.js" type="text/javascript">	</script--> 
	
</head>
<body>

<div class="wrapper">

	<div class="header" > 
		<div id="logo"> 
			<a href='index.php?r=site'><img src="images/background/transparent_logo1.png" align="left" height='110px'> </a>
		</div>   
		<div id="header-content">	
			<div id="header-content-enter-btn">
			<?php if (Yii::app()->user->isGuest) : ?>
				<a href="index.php?r=site/login" class="enter-btn"><font face="Helvetica"><?php echo Yii::t('general', 'Enter'); ?></font></a> 
				    <?php else :  echo '<b>' , Yii::app()->user->name , '</b> - ' , Yii::app()->user->email;
					echo  '<br>', CHtml::Link(Yii::t('general', 'Profile'), array('/user/update', 'id'=>Yii::app()->user->id) ), ' | ' , CHtml::Link(Yii::t('general', 'Logout'), array('/site/logout') );	
				   endif; ?>
			</div>
			
			<div class="header-content-item">
				<?php $this->widget('LangBox'); ?>	
				<?php  $this->widget('CityByIP'); ?>			 
			</div>
			
			<div class="header-content-item">
				<?php $this->widget('Cart');?>
			</div> 
			
			<!--div class="header-content-item">
				<?php //$this->widget('SearchByVin'); ?>
			</div-->
			<!--div class="header-content-item">
				<font size="+0" color="#222" face="Helvetica"><i>
					г. Москва, ул. Складочная д. 1, стр. 10,<br>   
					тел: +7 (495) 785-88-50 (многоканальный) 
					<br> 
					<a href='mailto:info@tarex.ru' >info@tarex.ru</a></i>
				</font> 
			</div-->
			
			<div class="header-content-left">
				<div id="header-content-address">
					<font size="+0" color="#222" face="Helvetica"><i>
					г. Москва, ул. Складочная д. 1, стр. 10,<br>   
					тел: +7 (495) 785-88-50 (многоканальный) 
					<br> 
					<a href='mailto:info@tarex.ru' >info@tarex.ru</a></i>
					</font> 
				</div>	
			</div>
		</div><!-- #header-content -->	
		<div id='find-by-oem-main'>
		<?php 	
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=> Yii::t('general','Find a spare part by OEM, Article or Key word including Analogs') ,
				));
				$this->widget('FindByOEM', array('hint'=>'1')); 
			$this->endWidget(); 
		?>
		</div><!-- find-by-oem-main --> 
	</div><!-- .header--> 
<div style='clear:both;'></div>

<div class="middle"> 
<div class="container">

<div class="content"><?php 
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) 
{
    echo '<br><ul class="flashes">';
    foreach($flashMessages as $key => $message) {
        echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
    }
    echo '</ul>';
} 	
?>



<div id="kategor">
<div id='center-wrapper'>  
<table><tr><td valign='top'>
	<div id="country" > 
	
	
	<?php 
		/*
		
		echo Yii::t('general','Search by Vin').': '.Chtml::form(Yii::app()->createUrl('assortment/index'),'get');
		echo Chtml::textField('vin', 'WAUBH54B11N111054');
		echo CHtml::submitButton(Yii::t('general','Search'), array('class'=>'red')); 
		//$this->endWidget();
		echo Chtml::endForm();
*/
	?>
	
			<h2 align='center'><font face="Helvetica">Производители</font></h2> <br/>
			<ul class="menu" style='list-style-type: none;'>
			<?php 
				$criteria = new CDbCriteria;
				$criteria -> order = 'id ASC';
				$criteria -> condition = 'depth =1';
			
				foreach (Assortment::model()->findAll($criteria) as $assort)
					{	  
						$lowerClass = strtolower($assort->title); 
						echo "<li class='{$lowerClass}' ><a href='" . Yii::app()->createUrl('site/index' , array( 'id'=>$assort->id )) . "'><font size='+1' face='Helvetica' >" . Yii::t('general', $assort->title) . "</font></a></li>";	
					}  
				?>
				<li><?php echo "<a href='" . Yii::app()->createUrl('site/index') . "'><font size='+1' face='Helvetica' >" . Yii::t('general', 'ALL MAKES') . "</font></a>"; ?></li>
			</ul> 
	 </div><!-- .country --> 
	 
</td><td valign='top'> 
	
	<div class="makes">
		<center><b><font size="+1" face="Helvetica">Марки машин</font></b></center> 
		<br>
		<table width=750  RULES=none >
			 <tr align="left"> 
			<?php
			echo $content;
			
			
			$criteria = new CDbCriteria;
			$criteria->compare('depth', 2);	
			$criteria->order = 'title ASC';
			
			$manufacturers = Assortment::model()->findAll($criteria);
			$country = Assortment::model()->findByPk($_GET['id'])->title;
			
			foreach($manufacturers as $m)
			{
				if (!$_GET['id'])	{
					$Parent=Assortment::model()->findByPk($m->parent_id);
					//echo 'title '.$Parent->title;
					
					if($Parent->title=="ГРУЗОВИКИ"){
						$makesgr[$m->id] =  $m->title; 
					}else{
						$makes[$m->id] =  $m->title; 
					}
						
				}
				elseif ($m->parent_id == $_GET['id']) {
					$makes[$m->id] = $m->title; 
				}
			}			
			$i=1;
			if ($makes) 
			{			
				//echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">Легковые:';
				//echo '</font></div></td>';  
					//if (($i++ % 3 ) == 0) echo '</tr><tr>';
				echo 'Легковые:<br>';	
				
					
				foreach ($makes as $key => $make) 
				{ 
					//if ( strtolower($make) == 'range rover' ) continue;
				 	echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">';
					echo  CHtml::Link( $make, array('assortment/index', 'id'=>$key));
					echo '</font></div></td>';  
					if (($i++ % 3 ) == 0) echo '</tr><tr>';
				}
			} 
			
			echo '</tr><td>Грузовые</td><tr>'; $i=1;
			echo '</tr><tr>';
			if ($makesgr) 
			{			
				//echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">Грузовые:';
				//echo '</font></div></td>';  
				//echo '<br>Грузовые:<br>';	

				
				foreach ($makesgr as $key => $make) 
				{ 
					//if ( strtolower($make) == 'range rover' ) continue;
				 	echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">';
					echo  CHtml::Link( $make, array('assortment/index', 'id'=>$key));
					echo '</font></div></td>';  
					if (($i++ % 3 ) == 0) echo '</tr><tr>';
				}
			} 
			
			
			
			
			
			
			?>
			</tr>
		</table >
	</div><!-- makes -->
</tr></table> 	
	
</div><!-- .center-wrapper -->
<br ><br >
<!--div id="bottom-wrapper"-->
<TABLE RULES=NONE width=100%>
<TR >
<TD >
<!--font size="+2" face="Helvetica">Специальные предложения в Москве </font-->
<b><font size="+1" face="Helvetica">&nbsp;&nbsp;&nbsp;&nbsp;Специальные предложения</font></b> 
<br>

<div class="slider">
		<div class="slide-list">
			<div class="slide-wrap">
				<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					<span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>BMW 3er V (E9x),  2011</a><br> 830 000 р.</center></span>
				</div>
				<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Mercedes-Benz GL-klasse ,  2008 </a><br> 1 195 000 р.</center></span>
				</div>
				<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Citroen C-Elysee, 2013 </a><br> 399 000 р.</center></span>
				</div>
				<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Lexus LS IV,  2008 </a><br> 1 245 000 р.</center></span>
				</div>
				<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Nissan Primera I (P10), 1993 </a><br>59 000 р.</center></span>
				</div>
                                <div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Ford Focus III, 2012 </a><br>500 000 р.</span>
				</div>
				<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Chevrolet Cruze I Рестайлинг, 2014 </a><br>456 000 р.</center></span>
				</div>
						<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Porsche Cayenne I (955), 2003 </a><br>515 000 р.</center></span>
				</div>
						<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Lifan X60, 2014 </a><br>449 900 р.</span>
				</div>
						<div class="slide-item">
					<!--img width="190" height="110" src="  " alt="" /-->
					 <span class="slide-title"><a href="#"><font size="+1" face="Helvetica"><center>Mercedes-Benz S-klasse V..., 2009 </a><br>1 590 000 р.</center></span>
				</div>
				
			</div></font>
			<div class="clear"></div>
		</div>
		<div class="navy prev-slide"></div>
		<div class="navy next-slide"></div>
		
	</div>
</TD>
</TR>
</TABLE>
<!--/div><!-- .bottom-wrapper -->

</div>

<!--div id="partner"></div-->

</div><!-- .content-->

</div><!-- .container--> 

<div class="right-sidebar"> 
	<?php echo Advertisement::model()->findByPk(1)->content; ?>
	<?php echo Advertisement::model()->findByPk(2)->content; ?>
	<?php echo Advertisement::model()->findByPk(3)->content; ?> 
	<!-- img src="images/bun3.jpg" width="250" -->  
</div><!-- .right-sidebar -->



</div><!-- .middle-->

	







<!--div class="footer">
<table width=800 height=100 >
  <tr>
   <td ><a href='#'><font size="+1" color="" face="Helvetica"> Оригинальные автозапчасти</font> </a></td>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> Аналоги</font>   </a></td>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> Все каталоги </font></a></td>
  </tr>
 <tr>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> О компании </font></a></td>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> Контактные данные</font>  </a></td>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> Партнерская сеть</font> </a></td>
  </tr>
  <tr>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> Оптовикам</font> </a></td>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> Постовщикам</font> </a></td>
   <td ><a href='#'><font size="+1"color="" face="Helvetica"> Как работать с сайтом</font> </a></td>
  </tr>
</table>

</div><!-- .footer -->

</div><!-- .wrapper -->


<script type="text/javascript">
	jQuery(function($) {
		$('#compose').click(function(){ 
			var _href = $(this).attr('href');
			var selected = $('#Pricelistsettings_TemplateName').val();
			$(this).attr('href', _href + '&template=' + selected );	
		});

		jQuery('body').on('change','#_lang',function(){jQuery.yii.submitForm(this,'',{});return false;});
	});
	/*]]>*/
</script>

</body>

</html>