<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */  
 
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('general','Create new User');
// $this->breadcrumbs=array(
	// Yii::t('general','Registration'),
// );
  
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) :
	echo '<ul style="list-style-type: none;" class="flashes">';
	foreach($flashMessages as $key => $message) {
		echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
	}
	echo '</ul>'; 	 
else:  

?>  
<h2><?php echo Yii::t('general','Create new User'); ?></h2><br>

<?php $this->renderPartial('_form_new', array('model'=>$model , 'userGroupDiscount' => $userGroupDiscount));  
endif; // end if (Yii::app()->user->hasFlash('registration')) 
?>  