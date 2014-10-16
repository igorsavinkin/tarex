<?php 
//$assortment = ($assortment != '') ? $assortment : new Assortment;
//echo 'hello';
//echo $assortment.'/'.$eventId;
$this->renderPartial('/assortment/admin_for_order', array('model'=>$assortment, 'eventId'=> $eventId));   

?>