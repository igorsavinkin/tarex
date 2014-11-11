<?php
$this->pageTitle = Yii::t('general','Check out'); 
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) 
{
    echo '<ul class="flashes">';
    foreach($flashMessages as $key => $message) {
        echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
    }
    echo '</ul>';
}   
else 
{
	if (!empty($orderId))
	{
	echo '<h2>', Yii::t('general', 'Your order is ready'), '<h2>'; 
	echo '<h4>', Yii::t('general','You might want to') , ' ' , CHtml::link(Yii::t('general','see and update order'), CController::createUrl('order/update', array('id'=>$orderId, '#'=>'tab2'))) , '.</h4>'; 
	//echo  CHtml::Link(Yii::t('general','Check out'), array('Events/registerorder',  'id'=>$orderId), array(), array('class'=>'btn-win')) , '. <u>' , Yii::t('general','When pressing button "Check out" you cannot change order\'s content'), '.</u>';

	} else $this->redirect(array('/site'));
}
?>