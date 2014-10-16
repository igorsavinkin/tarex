<?php 
if (Yii::app()->user->checkAccess(User::ROLE_MANAGER))
{	
	echo CHtml::Form();	    
	$criteria=new CDbCriteria;
    $criteria->condition='contractorId='.$model->id.' AND StatusId<>24';
		
		
	$Quantity=Order::model()->findAll($criteria);
	
	
	echo 'Quantity of orders not procssed yet:'.count($Quantity).'<br>';
?>
	<table width=80%, border=1>
	<tr>
	<th>Date</th><th>Order</th><th>Current status</th><th>Sum</th>
	</tr>
	
	<?php
		
		foreach ($Quantity as $r){
			
			if ($r->StatusId>0)
				$Status=EventStatus::model()->findbypk($r->StatusId);
			else $Status='undefined';
			
			echo '<tr><td>'.$r->Begin.'</td>';
			echo '<td><a href="index.php?r=order/update/id/'.$r->id.'">Order № '.$r->id.' from '.$r->Begin.'</a></td>';
			echo '<td>'.$Status->name.'</td>';
			echo '<td>'.$r->totalSum.'</td>';
			echo '</tr><tr>';
		
		}
	?> 
	</tr></table><br><br>
	
	
	
	Accounts:
	<table width=80%, border=1>
	<tr>
	<th>Account name</th><th>Customer name</th><th>Currency</th><th>Limit</th>
	</tr>
	
	<?
	
		//$criteria=new CDbCriteria;
		$criteria->condition='ParentCustomer='.$model->id;
		$Accounts=Accounts::model()->findall($criteria);
	
	
		foreach ($Accounts as $r){
			
			
			
			echo '<tr><td><a href="index.php?r=accounts/update/id/'.$r->id.'">'.$r->name.'</a></td>';
			echo '<td>'.$r->CustomerName.'</td>';
			$Currency=Currency::model()->findbypk($r->AccountCurrency);
			echo '<td>'.$Currency->name.'</td>';
			echo '<td>'.$r->AccountLimit.'</td>';
			echo '</tr><tr>';
		
		}
	?> 
	</tr></table>
<?	
	echo '<br><br>';
	
	echo CHtml::submitButton(Yii::t('general', 'Save'), array('class'=>'red'));
	echo CHtml::endForm(); 
}
else 
{
	 echo htmlspecialchars_decode($model->operationCondition);
} 
?>