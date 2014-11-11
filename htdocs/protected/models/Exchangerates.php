<?php 
class Exchangerates extends Events
{
 	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Begin, Currency, totalSum, organizationId', 'required'),
			array('totalSum', 'numerical'),
			
			array('id, Subject, authorId, eventNumber, Notes, Place, EventTypeId, organizationId, Begin, End, contractorId, contractId, Percentage, totalSum, ReflectInCalendar, ReflectInTree, parent_id, Priority, StatusId, Comment, PlanHours, FactHours, Tags, bizProcessId, manualTransactionEditing, dateTimeForDelivery, dateTimeForPayment, PaymentType, Currency', 'safe', 'on'=>'search'),
		);
	}
	public function search()
	{ 
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('Subject',$this->Subject,true);
		$criteria->compare('eventNumber',$this->eventNumber,true);
		$criteria->compare('Notes',$this->Notes,true);
		$criteria->compare('Place',$this->Place,true); 
		$criteria->compare('EventTypeId', Events::TYPE_EXCHANGE_RATE );  // Events::TYPE_EXCHANGE_RATE = 25 (курс валют) 
		//$criteria->compare('Begin',$this->Begin,true);
		//$criteria->compare('End',$this->End,true);
		$criteria->compare('contractorId',$this->contractorId);
		$criteria->compare('contractId',$this->contractId);
		$criteria->compare('Percentage',$this->Percentage);
		$criteria->compare('totalSum',$this->totalSum);
		$criteria->compare('ReflectInCalendar',$this->ReflectInCalendar);
		$criteria->compare('ReflectInTree',$this->ReflectInTree);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('Priority',$this->Priority);
		$criteria->compare('Currency',$this->Currency); 
		$criteria->compare('StatusId',$this->StatusId);
		$criteria->compare('Comment',$this->Comment,true);
		$criteria->compare('PlanHours',$this->PlanHours);
		$criteria->compare('FactHours',$this->FactHours);
		$criteria->compare('Tags',$this->Tags,true);
		$criteria->compare('bizProcessId',$this->bizProcessId);
		$criteria->compare('manualTransactionEditing',$this->manualTransactionEditing);
		$criteria->compare('dateTimeForDelivery',$this->dateTimeForDelivery,true);
		$criteria->compare('dateTimeForPayment',$this->dateTimeForPayment,true);
		if (Yii::app()->user->role != User::ROLE_ADMIN)        
			$criteria->compare('organizationId', Yii::app()->user->organization);
		else  
			$criteria->compare('organizationId',$this->organizationId);	
	
		 
		$criteria->addCondition(' Begin >= "' . $this->Begin . '" ');
	
		if(Yii::app()->user->role>5){
			$criteria->compare('authorId', Yii::app()->user->id);
		} 
	 	$criteria->order= 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}	

}