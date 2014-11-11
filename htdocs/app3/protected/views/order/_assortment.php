<?php 
//$assortment = ($assortment != '') ? $assortment : new Assortment;


$this->renderPartial('/assortment/admin_for_order', array('model'=>$assortment, 'eventId'=> $eventId, 'contractorId'=>$contractorId, ));   

?>