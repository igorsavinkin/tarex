<?php   

class Order extends Events
{ 
	public static $EventTypeId =  Events::TYPE_ORDER;// теперь дл€ каждого экземпл€ра класса/модели Order это поле (атрибут) будет равен 4 ??? - не уверен
	public function criteria()
	{
		$criteriaNew = new CDbCriteria;
		$criteriaNew->compare('EventTypeId', Events::TYPE_ORDER );
		
		$criteriaNew->mergeWith(parent::criteria()); // берЄм родитель и соедин€ем его с тем что мы дополнительно определили в $criteriaNew
		return $criteriaNew;  
	}
}