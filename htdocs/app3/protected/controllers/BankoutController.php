<?php
include('EventsController.php'); 
	
class BankoutController extends EventsController {
	 	
	public function loadModel($id)
	{
		$model=Events::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionAdmin()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}  
	
	public function actionUpdate($id)
	{
		if($id=='new')
		{
			$model=new Events;
			$model->Begin = date('Y-m-d H-i-s');
			$date = date_create();
			date_modify($date, '+1 hour');
			$model->End = date_format($date, 'Y-m-d H:i:s');
			
			//Присвоить ид
			$OrdersFinal = Events::model()->Find(array('order'=>'id DESC'))->id;
			$model->id = $OrdersFinal+1;
			
			$model->authorId=Yii::app()->user->id;			
			$model->contractorId=Yii::app()->user->id;
			
			if (Yii::app()->user->role>5) 			
				$model->contractorId=Yii::app()->user->id;
				
			$model->organizationId = Yii::app()->user->organization; 
			$model->EventTypeId = Events::TYPE_WRITE_OFF_CASHLESS_MONEY ; // списание безналичных денежных средств
			$model->StatusId = Events::STATUS_NEW;  ; //   статус новый
			
		} else {
			$model=$this->loadModel($id);				
		}  
		
		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];		 
			if($model->save()) 
			{	  
				if ($_POST['ok']) 
					$this->redirect(array('admin', 'Subsystem'=>'Money Management' , 'Reference'=>Eventtype::model()->findByPk($model->EventTypeId)->Reference));
				else       
					$this->redirect(array('update', 'id'=>$model->id, 'Subsystem'=>'Money Management' , 'Reference'=>Eventtype::model()->findByPk($model->EventTypeId)->Reference));
			}      
		} 
			
		$this->render('update', array(
			'model'=>$model,
		));
	} 
	public function actionTest3()
	{
		echo 'sum = ', $_GET['s'], '<br>';
		echo 'sum in letters = ', $this->num2str($_GET['s']), '<br>';	
	}
// печать платёжного поручения	 
	
	public function actionPrintPPL2($id)
	{ 
	/* Include PHPExcel */
		$DocEvent=Events::model()->findByPk($id);
		$organization=Organization::model()->findByPk($DocEvent->organizationId);			
		if (empty($organization)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you as user are not registered with any organization.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		$user=User::model()->findByPk($DocEvent->contractorId);
		if (empty($user)) {
			Yii::app()->user->setFlash('error', Yii::t('general', 'You cannot print invoice since you have not defined any contractor for this order. Turn to field "Contractor" and save the order.')); 
			$this->redirect( array('update','id'=>$id));
		}	
		  	  	
		spl_autoload_unregister(array('YiiBase','autoload'));        
		require_once Yii::getPathOfAlias('ext'). '/PHPExcel.php';
		
		// Create new PHPExcel object
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');//'Excel2007'
		
		$objPHPExcel = $objReader->load("files/PPL.xlsx"); // 
		$as = $objPHPExcel->getActiveSheet();
		
		$DateY=Substr($DocEvent->Begin,0,4);
		$DateM=Substr($DocEvent->Begin,5,2);
		$DateD=Substr($DocEvent->Begin,8,2); 	 

		$as->getCell('A4')->setValue('Платежное поручение № '.$id);
		$as->getCell('I4')->setValue($DateD.'.'.$DateM.'.'.$DateY);
		
		$Sum = EventContent::getTotalSumByEvent($id);
		
		$as->getCell('B6')->setValue($this->num2str($Sum));
		$as->getCell('A7')->setValue('ИНН '.$user->INN);
		$as->getCell('F7')->setValue('КПП '.$user->KPP);
		$as->getCell('M7')->setValue($Sum, 2 ,'-',' ');
		$as->getCell('A9')->setValue($user->name);
		//$as->getCell('M9')->setValue($user->account);
		//$as->getCell('A13')->setValue($user->bank);
		//$as->getCell('A17')->setValue($organization->bank);
		$as->getCell('A20')->setValue('ИНН '.$organization->INN);
		$as->getCell('F20')->setValue('КПП '.$organization->KPP);
		$as->getCell('A22')->setValue($organization->name);
		
		$filename='ppl';
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');  
		$objWriter->save('php://output');
		
	}
	 
// --- Написание суммы прописью
	public function num2str($num) 
	{
		$nul='ноль';
		$ten=array(array('','один','два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),array('','одна','две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),); 
		$a20=array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятьнадцать', 'шестьнадцать', 'семьнадцать', 'восемьнадцать','девятнадцать');
		$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят','восемьдесят','девяносто');
		$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот','семьсот','восемьсот','девятьсот');
		$unit=array(array('копейка','копейки','копеек',1), array('рубль','рубля','рублей',0),array('тысяча','тысячи','тысяч',1),array('миллион','миллиона','миллионов',0),array('миллиард','миллиарда','миллиардеров',0),);
		
		list($rub,$kop)=explode('.',sprintf("%015.2f",floatval($num)));
		$out=array();
		if (intval($rub)>0) {
			
			foreach(str_split($rub,3) as $uk=>$v) {
				
				if (!intval($v)) continue;;
				$uk=sizeof($unit)-$uk-1;
				$gender=$unit[$uk][3];
				list($i1,$i2,$i3)=array_map('intval',str_split($v,1));
				$out[]=$hundred[$i1];
				if($i2>1) $out[]=$tens[$i2].' '.$ten[$gender][$i3];
				else $out[]=$i2>0 ? $a20[$i3] : $ten[$gender][$i3];
				if ($uk>1) $out[]=$this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
			}
		}
		else $out[]=$nul;
		$out[]=$this->morph(intval($rub),$unit[1][0],$unit[1][1],$unit[1][2]);
		$out[]=$kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]);
		
		return trim(preg_replace('/ {2,}/',' ', join(' ',$out)));			
	}
// --- склонения	 
   public function morph($n,$f1,$f2,$f5) 
	{
		$n=abs(intval($n)) %100;
		if ($n>10 && $n<20) return $f5;
		$n=$n%10;
		if ($n>1 && $n<5) return $f2;
		if($n==1) return $f1;
		return $f5; 
	}
}