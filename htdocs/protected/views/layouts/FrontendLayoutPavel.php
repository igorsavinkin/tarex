<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en" />
 
	<link rel="shortcut icon" type="image/ico" href="/app2/img/favicon.ico">
	
	<link rel="stylesheet" type="text/css" href="/app2/css/form.css" />
	<link rel="stylesheet" type="text/css" href="css/style_n.css" />
	<?php
			$Messages = array();
		//$Messages = json_encode(Yii::t_all_pavel('general'));
		//$Messages = json_encode(Yii::t_all_pavel('general'));
		    $RoleId=Yii::app()->user->role;
			$UserName=Yii::app()->user->name;
			$UserId=Yii::app()->user->id;
			$OrganizationId=Yii::app()->user->organization;			
			
			$Language = isset($_GET['Language']) ? $_GET['Language'] : Yii::app()->getLanguage();
			echo "<script language='javascript'> 		 
				var RoleId=".$RoleId."; 
				var UserName='".$UserName."'; 
				var UserId='".$UserId."'; 
				var OrganizationId='".$OrganizationId."'; 
				var Language='".$Language."'; 
				";
			echo "//console.log('Language '+Language);";
			echo "</script>";
		?>

		<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/gridview.css" media="screen, projection" />
	<!--link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" /> 
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" /-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<!--link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style_n.css" /--> 

	<title><?php echo CHtml::encode($this->pageTitle); 
	
	
	
	?></title>

	
</head>

<body>  
<!--div class="header" -->
 <table  border=0  cellspacing=0 cellpadding=0 width=100%> 
	<tr> 
		<td style='padding: 0px 5px;'> 
		
		<div id="logo"> 
			<a href='index.php'><img src="images/background/transparent_logo1.png" align="left" height='110px'> </a>
		</div>   
		
		</td><td>
		
		<div id="header-content">				 
			 
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
		</td><td>		  
			 <?php // $this->widget('SearchByVin'); ?>	
		</td><td>		  
			 <?php  $this->widget('CityByIP');?>		
		</td><td>
			<?php  $this->widget('Cart');?>
		</td><td style='padding: 0px 10px'> 
			<?php 				
				if (!Yii::app()->user->isGuest)
				{
					echo '<b>' , Yii::app()->user->username , '</b> - ' , Yii::app()->user->email , '<br> role: ', Yii::app()->user->role,  ' | org: ' , Yii::app()->user->organization, ' | ' , CHtml::Link(Yii::t('general', 'Profile'), array('/user/update', 'id'=>Yii::app()->user->id) ), ' | ' , CHtml::Link(Yii::t('general', 'Logout'), array('/site/logout') );				
				} ?>
		  <?php $this->widget('LangBox'); ?> 
		</td>
	</tr>
</table>			
<div id='find-by-oem-main'>
<?php 	
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=> Yii::t('general','Find a spare part by OEM, Article or Key word including Analogs') ,
		));
		$this->widget('FindByOEM', array('hint'=>'1')); 
	$this->endWidget(); 
?>
</div><!-- find-by-oem-main --> 
	<!--/div><!-- .header--> 
<div style='clear:both;'></div>


<table  border=0  cellspacing=0 cellpadding=0 width=100%> 
	<tr> 
			<td style='padding: 0px 5px;'> 
				<div id="logo"><?php echo CHtml::encode(Yii::app()->name).' MOBILE version '; ?></div>
			</td> 
	</tr> 
    <tr >
 
   <td colspan=2 valign=top style='padding-left: 20px;'>  
	<?php 
		//Подсистемы
		//echo Yii::t('general','Subsystems').'<br>';
		
		$Subsystem= Yii::app()->session['Subsystem'];
		$Reference=  Yii::app()->session['Reference'];
		//echo '$Subsystem = ', $Subsystem, '<br>$Reference = ' , $Reference;
		
		$RoleId = Yii::app()->user->role;
		$OrganizationId = Yii::app()->user->organization;
		
		$MainMenu=MainMenu::model()->FindAll(
			array(
				'select'=>'Subsystem,Img',
				'order'=> 'DisplayOrder',
				'distinct'=>true,
				'condition'=>'RoleId  LIKE :RoleId',
				'params'=>array(':RoleId'=>'%'.$RoleId.'%'),
			)
		
		);
		
		foreach ($MainMenu as $r){
			$Img=$r->Img;
			//echo 'Img '$Img
			if ($Subsystem==$r->Subsystem){
				//echo '<strong>'.Yii::t('general', $r->Subsystem).'</strong> | ';
				
				if($Img != '') {
				
					echo "<img src='images/icons/".$r->Img."' alt='".Yii::t('general', $r->Subsystem)."' title='".Yii::t('general', $r->Subsystem)."'>  | ";
				}else{

					echo '<strong>'.Yii::t('general', $r->Subsystem).'</strong> | ';
				}
				
			}else{
				if($Img != '') {
					echo CHtml::Link("<img src='images/icons/".$r->Img."' alt='".Yii::t('general', $r->Subsystem)."' title='".Yii::t('general', $r->Subsystem)."'>", array('MyFrontend/index', 'Subsystem'=>$r->Subsystem))." | ";
				}else{
					echo '<strong>'.CHtml::Link(Yii::t('general', $r->Subsystem), array('MyFrontend/index', 'Subsystem'=>$r->Subsystem)).'</strong> | '; 
				}
				
				
				
			}
		}
		
	?>
	<?php
		$flashMessages = Yii::app()->user->getFlashes();
		if ($flashMessages) {
			echo '<ul class="flashes">';
			foreach($flashMessages as $key => $message) {
				echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
			}
			echo '</ul>';
		}

		//echo 'Yii::app()->controller->id = ', Yii::app()->controller->id;
	?><br>&nbsp; 
	
  </td> 
 </tr>
 <tr >
  <td width='20%' valign='top' style='padding-left: 30px;'>
	
	<?php
		//echo Yii::t('general', 'Left menu').'<br>';
		
		
		if (!empty($Subsystem)){
			//Левое меню
			//echo ('$Subsystem '.$Subsystem);
			$LeftMenu=MainMenu::model()->FindAll(
				array(
					'order'=> 'DisplayOrder',
					'condition'=>'Subsystem=:Subsystem AND RoleId  LIKE :RoleId',
					'params'=>array(':Subsystem'=>$Subsystem, ':RoleId'=>'%'.$RoleId.'%'),
				)
			);
			
			foreach ($LeftMenu as $r){
				$Img=$r->ReferenceImg;
				$action = 'admin';
				//if ($r->Link == 'Assortment') $action = 'index';// для Assortment мы выбираем действие 'index'  
				if ($Reference==$r->Reference){
					if($Img != '') {		 			
						
						echo "<img src='images/icons/".$r->ReferenceImg."' alt='".Yii::t('general', $r->Reference)."' title='".Yii::t('general', $r->Reference)."'> ".CHtml::Link(  Yii::t('general', $r->Reference ), 
						array($r->Link."/{$action}" /*_frontend*/, 'Subsystem'=>$r->Subsystem ,'Reference'=>$r->Link), array('class'=>'btn-win btn-colored')).' <br><br>';
						/*echo "<img src='images/icons/".$r->ReferenceImg."' alt='".Yii::t('general', $r->Reference)."' title='".Yii::t('general', $r->Reference)."' > <strong>".Yii::t('general', $r->Reference)."</strong> <br><br> ";*/
					 	
					}else{
						echo '<strong>'.CHtml::Link(Yii::t('general', $r->Reference), array($r->Link."/{$action}", 'Subsystem'=>$r->Subsystem, 'Reference'=>$r->Reference, array('class'=>'btn-win btn-colored'))).'</strong> <br> ';
						//echo '<strong>'.Yii::t('general', $r->Reference).'</strong> <br><br>';
					}	
			
				}else{
					if($Img != '') {
						$action = 'admin';
					//	if ($r->Link == 'Assortment') $action = 'index';
						echo "<img src='images/icons/".$r->ReferenceImg."' alt='".Yii::t('general', $r->Reference)."' title='".Yii::t('general', $r->Reference)."'> ".CHtml::Link(  Yii::t('general', $r->Reference ), 
						array($r->Link."/{$action}" /*_frontend*/, 'Subsystem'=>$r->Subsystem ,'Reference'=>$r->Link), array('class'=>'btn-win')).' <br><br>';
					
					}else{
						echo '<strong>'.CHtml::Link(Yii::t('general', $r->Reference), array($r->Link."/{$action}", 'Subsystem'=>$r->Subsystem, 'Reference'=>$r->Reference, array('class'=>'btn-win'))).'</strong> <br> ';
					}
				}
					
			}
		
		}elseif (Yii::app()->controller->id == 'myFrontend' && Yii::app()->controller->action->id == 'index'  ){ //MyFrontend/index 
 
			echo '<div id="kategor"><div id="center-wrapper">  
					<table align="center"><tr><td valign="top">
					<div id="country" > 
	
					<h2 align="center"><font face="Helvetica">Производители</font></h2> <br/>
					<ul class="menu" style="list-style-type: none;">';
			
				$criteria = new CDbCriteria;
				$criteria -> order = 'id ASC';
				$criteria -> condition = 'depth =1';
			
				foreach (Assortment::model()->findAll($criteria) as $assort)
					{	  
						$lowerClass = strtolower($assort->title); 
						echo "<li class='{$lowerClass}' ><a href='" . Yii::app()->createUrl('site/FrontendPavel' , array( 'id'=>$assort->id )) . "'><font size='+1' face='Helvetica' >" . Yii::t('general', $assort->title) . "</font></a></li>";	
					}  
				
				 echo "<li><a href='" . Yii::app()->createUrl('site/FrontendPavel') . "'><font size='+1' face='Helvetica' >" . Yii::t('general', 'ALL MAKES') . "</font></a></li></ul>"; 
			 
		echo '</div><!-- .country --> ';
	 
echo '</td><td valign="top"> ';
	
	echo '<div class="makes">
		<center><b><font size="+1" face="Helvetica">Марки машин</font></b></center> 
		<br>
		<table width=750  RULES=none >
			 <tr align="left"> ';
			
			
			$criteria = new CDbCriteria;
			$criteria->compare('depth', 2);	
			$criteria->order = 'title ASC';
			
			$manufacturers = Assortment::model()->findAll($criteria);
			if (isset($_GET['id'])) 
				$country = Assortment::model()->findByPk($_GET['id'])->title;
			
			$makesgr=array();
			$makes=array();
			
			foreach($manufacturers as $m)
			{
				if (!isset($_GET['id']))	{
					$Parent=Assortment::model()->findByPk($m->parent_id);
					//echo 'title '.$Parent->title;
					
					if($Parent->title=="ГРУЗОВИКИ"){
						$makesgr[$m->id] =  $m->title; 
					}else{
						$makes[$m->id] =  $m->title; 
					}
						
				}
				elseif ($m->parent_id == $_GET['id']) {
					$Parent=Assortment::model()->findByPk($m->parent_id);
					//echo 'title '.$Parent->title;
					
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
				//echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">Легковые:';
				//echo '</font></div></td>';  
					//if (($i++ % 3 ) == 0) echo '</tr><tr>';
				echo 'Легковые:<br>';	
				
					
				foreach ($makes as $key => $make) 
				{ 
					//if ( strtolower($make) == 'range rover' ) continue;
				 	echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">';
					echo  CHtml::Link( $make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment'));
					echo '</font></div></td>';  
					if (($i++ % 3 ) == 0) echo '</tr><tr>';
				}
			} 
			
			if (!empty($makesgr)) 
			{			
				//echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">Грузовые:';
				//echo '</font></div></td>';  
				//echo '<br>Грузовые:<br>';	

				//print_r($makesgr);
				echo '</tr><td>Грузовые</td><tr>'; $i=1;
				echo '</tr><tr>';
				
				foreach ($makesgr as $key => $make) 
				{ 
					//if ( strtolower($make) == 'range rover' ) continue;
				 	echo '<td width="33%" ><div class="car-makes"><font size="+1" face="Helvetica">';
					echo  CHtml::Link( $make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment'));
					echo '</font></div></td>';  
					if (($i++ % 3 ) == 0) echo '</tr><tr>';
				}
			}   	
						echo'</tr>
					</table >
				</div><!-- makes -->
			</tr></table> 	
	
			</div><!-- .center-wrapper --></div>';
		
		} 
	
	
	?>
  </td>
  <td width=80% valign=top >
	 
	   <?php // главное содержимое каждого представления
	   if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif; 
		
if (!empty($Reference)){ }
//echo '<strong>'.Yii::t('general', $Reference).'</strong><br>'; 

		echo $content; 
	?>
	
  </td>
 </tr>
</table>

	
</body>
</html>