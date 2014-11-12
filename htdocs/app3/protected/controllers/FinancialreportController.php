<?php

class FinancialreportController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	
	public $layout='//layouts/FrontendLayoutPavel';

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
			foreach ($model as $r){
			
			//	if ($r->EventTypeId  in (24,19,20)){
				if ($r->EventTypeId==24 || $r->EventTypeId==19 || $r->EventTypeId==20){
					$OpeningBalances += $r->totalSum;	
				
				}else{
					$OpeningBalances -= $r->totalSum;	
				
				
				}
			
			}
			
		
		}
		
		
		
		return $OpeningBalances;
	}
	
	
	public function actionAdmin(){
		$modelName='Events';
	
		$model=new $modelName;	
		if(isset($_POST['Events']))
		{
			
			
			$model->Begin=$_POST[$modelName]['Begin'];
			$model->End=$_POST[$modelName]['End'];
			$model->contractorId=$_POST[$modelName]['contractorId'];
			//echo 'Begin '.$model->Begin;
			$criteria=new CDbCriteria(array(
				'condition'=>'EventTypeId IN (24, 4, 17, 19,20,21)',
				'order'=>'Begin ASC',
			));
			if (!empty($model->contractorId)) $criteria->condition .= ' AND contractorId = '.$model->contractorId;
			$UserRole=Yii::app()->user->role;
			$UserOrganization=Yii::app()->user->organization;
			if ($UserRole>=3) $criteria->condition .= " AND organizationId <= ".$UserOrganization;
			
			//Посчитаем начальные остатки
			if (isset($model->Begin)) 
				$criteriaOpeningBalances=new CDbCriteria(array(
					'order'=>'Begin ASC',
				));
				$criteriaOpeningBalances->condition = $criteria->condition." AND Begin < '".$model->Begin."'";
				$OpeningBalances=$this->FOpeningBalances($modelName,$criteriaOpeningBalances);

				$criteria->condition .= " AND Begin >= '".$model->Begin."'";
				//$criteria->params= array($model->Begin;
			if (isset($model->End)) $criteria->condition .= " AND Begin <= '".$model->End."'";
			
			
			
			//echo $criteria->condition;
			$modelRes=$this->loadModel($modelName,$criteria);
			
	
		}
		
		$this->render('admin',
			array('model'=>$model, 'modelRes'=>$modelRes, 'OpeningBalances'=>$OpeningBalances)
		
		
		);
	
	}
	
	
	
	
}