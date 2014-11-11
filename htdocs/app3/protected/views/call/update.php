<?php
/* @var $this EventsController */
/* @var $model Events */ 
$flashMessages = Yii::app()->user->getFlashes();
if ($flashMessages) {
    echo '<ul class="flashes">';
    foreach($flashMessages as $key => $message) {
        echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
    }
    echo '</ul>';
}
?> 
<h3><em><?php   
  echo  Yii::t('general', $model->EventType->name), '</em> ' , Yii::t('general','#') ,  $model->id, ' ', Yii::t('general','from date') , ' ' , Controller::FConvertDate($model->Begin); ?></h3>

  <?php $this->renderPartial('_main', array(
	'model'=>$model,
));?>