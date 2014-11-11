<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en" />

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
	<!--link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form1.css" /-->
		
		
		
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/cssdenis.css" rel="stylesheet">

	<title>DEnis<?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="wrapper">

<header class="header">
Denis	<div id="logo"><?php echo CHtml::encode(Yii::app()->name).' MOBILE version'; ?></div>
		
			<!-- language -->
			
            <div id="img4">
				<?php echo Yii::app()->user->name.' | role: '.Yii::app()->user->role.' | '.CHtml::Link(Yii::t('general', 'Logout'), array('/site/logout')); ?>
				<?php $this->widget('LangBox'); ?>
			</div>	
				
				
				
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
	
	?><br>&nbsp; 
	

</header><!-- .header-->



<div class="middle">
<aside class="left-sidebar">
		
		
        <table>
        <tr>
        <td  >
		
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
			
				if ($Reference==$r->Reference){
					if($Img != '') {
					
						echo "<img src='images/icons/".$r->ReferenceImg."' alt='".Yii::t('general', $r->Reference)."' title='".Yii::t('general', $r->Reference)."' > <strong>".Yii::t('general', $r->Reference)."</strong> <br><br> ";
					 	
					}else{
		
						echo '<strong>'.Yii::t('general', $r->Reference).'</strong> <br><br>';
					}	
			
				}else{
					if($Img != '') {
						echo "<img src='images/icons/".$r->ReferenceImg."' alt='".Yii::t('general', $r->Reference)."' title='".Yii::t('general', $r->Reference)."'> ".CHtml::Link(  Yii::t('general', $r->Reference ), 
						array($r->Link.'/admin'/*_frontend*/, 'Subsystem'=>$r->Subsystem ,'Reference'=>$r->Reference), array('class'=>'btn-win')).' <br><br>';
					
					}else{
						echo '<strong>'.CHtml::Link(Yii::t('general', $r->Reference), array($r->Link.'/admin_frontend', 'Subsystem'=>$r->Subsystem, 'Reference'=>$r->Reference)).'</strong> <br> ';
					}
				}
					
			}
		
		}
	
	
	?>
      </td>
      </tr>
      </table>
	  
	  
	</aside><!-- .left-sidebar -->
	
<div class="container">
		
		
        <table>
        <tr>
        <td>
	     DEnis
		    
	    <?php // главное содержимое каждого представления
	   if(isset($this->breadcrumbs)):?>
	  
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif; 
		echo '<br>';
/*if (!empty($Reference)){echo '<strong>'.Yii::t('general', $Reference).'</strong><br>';}*/

		echo $content; 
	?>

      </td>
      </tr>
      </table>
		
		
	</div><!-- .container-->
    
	
	
	
	
	
	

		</div><!-- .middle-->
	
	</div><!-- .wrapper -->
</body>
</html>