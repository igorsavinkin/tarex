<?php
class FinancialreportController extends Controller
{ 
	public function loadModel($modelName,$criteria)
	{
		$model=$modelName::model()->findAll($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}		
	public function FOpeningBalances($modelName,$criteria)
	{
		$OpeningBalances=0;
		$model=$modelName::model()->findAll($criteria);
		if (!empty($model)){
			foreach ($model as $r)
			{			
				if ($r->EventTypeId==24 || $r->EventTypeId==19 || $r->EventTypeId==20){
					$OpeningBalances += $r->totalSum;				
				}else{
					$OpeningBalances -= $r->totalSum;				
				}			
			} 
		} 		
		return $OpeningBalances;
	}	
	
	public function actionAdmin()
	{
		$modelName='Events';	
		$model=new $modelName;	
		$model->contractorId = Yii::app()->user->id; //print_r($model);
		
		if(isset($_POST['Events']))
		{						
			$model->Begin=$_POST[$modelName]['Begin'];
			$model->End=$_POST[$modelName]['End'];
		// устанавливаем контрагента если смотрит менеджер и старше	или бухгалтер
			if (Yii::app()->user->checkAccess(User::ROLE_MANAGER) OR Yii::app()->user->checkAccess(User::ROLE_ACCOUNTER)) 
			{
				$model->contractorId = $_POST[$modelName]['contractorId'];
			}
			//echo ',<br>$model->contractorId = ', $model->contractorId; echo 'Begin '.$model->Begin;
			$criteria=new CDbCriteria(array(
				'condition'=>'EventTypeId IN (24, 4, 17, 19, 20, 21)',
				'order'=>'Begin ASC',
			));
			if (!empty($model->contractorId)) 
				$criteria->condition .= ' AND contractorId = '.$model->contractorId;
		
		// если администратор, тогда смотрим по всем организациям
			if (Yii::app()->user->checkAccess(User::ROLE_ADMIN))  
				$criteria->condition .= " AND organizationId = " . Yii::app()->user->organization;
			
		// Посчитаем начальные остатки
			if (!empty($model->Begin)) 
			{
				$criteriaOpeningBalances=new CDbCriteria(array( 'order'=>'Begin ASC',
					'condition' => $criteria->condition." AND Begin < '".$model->Begin."'" 
				)); 
				$OpeningBalances=$this->FOpeningBalances($modelName,$criteriaOpeningBalances);
			}
			
		// добавим в критерий условия начала и конца	
			if (!empty($model->Begin)) 
				$criteria->condition .= " AND Begin >= '".$model->Begin."'";
				//$criteria->params= array($model->Begin;
			if (!empty($model->End)) 
				$criteria->condition .= " AND Begin <= '".$model->End."'"; 
			
			//echo '<br>$criteria->condition = ', $criteria->condition;
			$modelRes=$this->loadModel($modelName,$criteria); 
		}
		
		$this->render('admin', array('model'=>$model, 'modelRes'=>$modelRes, 'OpeningBalances'=>$OpeningBalances
		));	
	} 	// end of actionAdmin 
}