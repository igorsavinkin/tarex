<?php   

class Order extends Events
{ 
	public static $EventTypeId =  Events::TYPE_ORDER;// ������ ��� ������� ���������� ������/������ Order ��� ���� (�������) ����� ����� 4 ??? - �� ������
	public function criteria()
	{
		$criteriaNew = new CDbCriteria;
		$criteriaNew->compare('EventTypeId', Events::TYPE_ORDER );
		
		$criteriaNew->mergeWith(parent::criteria()); // ���� �������� � ��������� ��� � ��� ��� �� ������������� ���������� � $criteriaNew
		return $criteriaNew;  
	}
}