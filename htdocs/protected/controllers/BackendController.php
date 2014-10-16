<?php
class BackendController extends Controller
{
    public function html_escape($var)
	{
		if (is_array($var))
		{
			return array_map('html_escape', $var);
		}
		else
		{
			// return htmlspecialchars($var, ENT_QUOTES, 'utf-8'); 
			return htmlspecialchars($var, ENT_NOQUOTES, 'utf-8');
		}	 
	}
	
	
	
	
public function transliterate($st) {
 $translit = array(
 
            'а' => 'a',   'б' => 'b',   'в' => 'v',
 
            'г' => 'g',   'д' => 'd',   'е' => 'e',
 
            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
 
            'и' => 'i',   'й' => 'j',   'к' => 'k',
 
            'л' => 'l',   'м' => 'm',   'н' => 'n',
 
            'о' => 'o',   'п' => 'p',   'р' => 'r',
 
            'с' => 's',   'т' => 't',   'у' => 'u',
 
            'ф' => 'f',   'х' => 'x',   'ц' => 'c',
 
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
 
            'ь' => '',  'ы' => 'y',   'ъ' => '',
 
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya', 
			
					
			'№' => 'N',  ' ' => '',
         
 
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
 
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
 
            'Ё' => 'YO',   'Ж' => 'Zh',  'З' => 'Z',
 
            'И' => 'I',   'Й' => 'J',   'К' => 'K',
 
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
 
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
 
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
 
            'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
 
            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
 
            'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
 
            'Э' => 'E\'',   'Ю' => 'YU',  'Я' => 'YA',
 
        );
	
		$word = strtr($st, $translit); 
		return $word;
		// транслитерация. Переменная $word получит значение 'prochee'
  
}

	public function actiontestgrid()
	{
		$this->layout='//layouts/testgrid_layout';
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('test'); 
	}	
	
	
	public function actionuploadfile()
	{
			$uploaddir = 'files/';
			$uploadfile = $uploaddir . $_FILES['ufile']['name'];

			$str = $this->transliterate($uploadfile);
			$str = strtolower($str); 

			if (move_uploaded_file($_FILES['ufile']['tmp_name'],$str)){
				echo '{"success":true}';
			}else{
				echo '{"success":false}';
			} 
	}	
	 
public function actionSave()
	{
		$ModelName = $this->html_escape($_GET['Table']);	
		if(isset($_GET))
		{ 
			if(!empty($_GET['id']))
				$model = $ModelName::model()->findbypk($_GET['id']); 
			else 
				$model = new $ModelName; 
			
			//echo '$_GET[FOBcost] = ', $_GET['FOBCost'];
			echo '$_GET = '; print_r($_GET);
			
			$model->attributes=$_GET;	//var_dump($model);		
			echo ' $model = '; print_r($model);
			//echo ' <br> FOBCost = ', $model->FOBCost; //.' Analogi '.$model->Analogi.'Photos1 '.$_GET['Photos'];
			
			
			if ($ModelName=='SearchTerm'){
				$name=$_GET['name'];
				$Field=$_GET['Field'];
				$UserId=Yii::app()->user->id;
				echo 'UserId '.$UserId;
				$SearchTerm=SearchTerm::model()->findbyattributes(array('name'=>$name));
				if (!empty($SearchTerm)){
					$model = $SearchTerm;
					$model->frequency++;
					$model->Field=$Field;
					
				}else{
					
					$model->frequency=1;
					$model->UserId=$UserId;
					$model->Field=$Field;
					//$today=date(Y-m-d);
					$today= date("Y-m-d");
					
					$model->firstOccurance=$today;
					//.'/'.$today; 
					
				}
			}	
			
			
			if($model->save(false)){ 
				echo '1';				//echo $model->Photos;
				//echo 'ModelName '.$ModelName.' saved ';
			}
				
				
		}	
		
	}


public function actionRemains(){
		$filters  = isset($_REQUEST['filter'])  ? $_REQUEST['filter'] : null;
		 
		//echo 'test';
		
		 
		
		$OrganizationId=7;
		
		 $criteria=new CDbCriteria;
         $criteria->condition="event.id != 'NULL' AND a.id !='NULL' AND event.organizationId=".$OrganizationId;		
         //$criteria->condition="eventid != 'NULL";		
		 $filters = json_decode($filters);
			for ($i=0;$i<count($filters);$i++){
				$filter = $filters[$i];
				$field = isset($filter->property) ? $this->html_escape($filter->property) : $this->html_escape($filter->field);
				$value = $this->html_escape($filter->value);
				
				if ($field=='Warehouse' && $value!='') {
					$Warehouse=Warehouse::model()->findbyattributes(array('name'=>$value));
					//echo 'Warehouse'.$Warehouse;
					//return;
					if ($Warehouse!='')				
						$criteria->condition.=" AND (Subconto1=".$Warehouse->id." OR Subconto2=".$Warehouse->id.")"; 
						
				}
				if ($field=='Contractor' && $value!='') {
					$User=User::model()->findbyattributes(array('username'=>$value));
					if ($User!='')		
					
						$criteria->condition.=" AND contractor=".$User->id; 
				}
				if ($field=='Author' && $value!='') {
					$User=User::model()->findbyattributes(array('username'=>$value));
					if ($User!='')							
						$criteria->condition.=" AND author=".$User->id; 
				}
				
				if ($field=='Assortment title' && $value!='') {
					$criteria->addCondition("a.title=".$value); 
				}
				if ($field=='Assortment model' && $value!='') {
					$criteria->addCondition("a.model=".$value); 
				}
				if ($field=='Assortment make' && $value!='') {
					$criteria->addCondition("a.make=".$value); 
				}
				if ($field=='Assortment manufacturer' && $value!='') {
					$criteria->addCondition("a.manufacturer=".$value); 
				}
				if ($field=='Assortment subgroup' && $value!='') {
					$criteria->addCondition("a.subgroup=".$value); 
				}	
				if ($field=='Assortment id' && $value!='') {
					$criteria->addCondition("a.id=".$value); 
				}
				
			}
			
		$ident=$_REQUEST['ident'];	
		if(!empty($ident)) {
			$criteria->addCondition("a.id=".$ident); 
		}
		  
		 $where=$criteria->condition;
		 $params=$criteria->params; 
		 
		
		$command = Yii::app()->db->createCommand();     
        $resultQuery = $command->select('
			a.oem as oem, 
			a.article as article, 
			a.model as model, 
			a.make as make, 
			a.manufacturer as manufacturer, 
			a.id as assortment_id, 
			a.title as title, 
			
			event.id as eventid, 
			event.begin as begin, 
			event.Subconto1 as Subconto1, 
			event.Subconto2 as Subconto2, 
			event.authorId as author, 
			event.contractorId as contractor, 
			event.organizationId as organization, 
			type.name as EventType, 
			assortmentAmount, 
			cost,
			warehouse.name as warehouse,
			warehouse.id as warehouseid
			
			')
        ->from('tarex_eventcontent')
        ->leftjoin('tarex_events		       		AS event',  'eventId =   event.id')
        ->leftjoin('tarex_assortment     		AS a',        'assortmentId =  a.id')
        ->leftjoin('tarex_eventtype 	  		AS type' ,   'eventTypeid =   type.id')
        ->leftjoin('tarex_organization 	    AS org' ,    'event.organizationId = org.id') 
        ->leftjoin('tarex_warehouse 	        AS warehouse' ,    'event.Subconto1 = warehouse.id')
		//->where($where, $params);
		->where($where, $params);
		
		//echo '<br><br><b>DETAILED QUERY BY ASSORTMENT ITEM: </b>"' , $resultQuery->text , '" ';
		//return;
		
		$result = $resultQuery->queryAll();
		 //$Array=new CArrayDataProvider($result, array());
		 
		// print_r($result);
		//$AssortmentRemains = new AssortmentRemains;
		 //echo '<br><b>DETAILED QUERY BY ASSORTMENT ITEM: </b>"' , $resultQuery->text , '" ';
		//$AssortmentRemains->eventid='1';
			
				
		AsortmentRemains::model()->deleteAll();
	
		
		if (!empty($result)){
			foreach ($result as $r){
				//echo 'title '.$r->title.'<br>';
				//echo $r->oem;
				//$rows=$result->readAll();
				//echo $rows;
				//$rows=$r->readAll();
				//echo '<br>eventid '.$r['eventid'];
				
				$Date1=$r['begin'];
				//echo 'Date1 '.$Date1;
				
				
				$year=mb_substr($Date1,0,4,"UTF-8");
				$month=mb_substr($Date1,5,2,"UTF-8");
				$day=mb_substr($Date1,8,2,"UTF-8");
				
				$AsortmentRemains = new AsortmentRemains;
				$AsortmentRemains->date=$Date1;
				$AsortmentRemains->eventid=$r['eventid'];
				$AsortmentRemains->eventdate=$day.'-'.$month.'-'.$year;
				$AsortmentRemains->assortmentid=$r['assortment_id'];
				$AsortmentRemains->authorid=$r['author'];
				$AsortmentRemains->warehouseid=$r['warehouseid'];
				$AsortmentRemains->contractorid=$r['contractor'];
				
				$Contractor=User::model()->findbypk($AsortmentRemains->contractorid);
				$User=User::model()->findbypk($AsortmentRemains->authorid);
				$Warehouse=Warehouse::model()->findbypk($r['warehouseid']);
				
				$AsortmentRemains->contractor=$Contractor->username;
				$AsortmentRemains->author=$User->username;
				$AsortmentRemains->warehouse=$Warehouse->name;
				$AsortmentRemains->assortment=$r['title'].' ('.$r['article'].')' ;
				$AsortmentRemains->event=$r['EventType'].' № '.$r['eventid'].' from '.$day.'-'.$month.'-'.$year;
				
					
				//echo 'EventType  '.$r['EventType'];
				
				if($r['EventType']=="Order"){
					$AsortmentRemains->reserved=$r['assortmentAmount'];
					$AsortmentRemains->sumreserved=$r['cost'];
					$AsortmentRemains->save();
				}
				elseif ($r['EventType']=="Purchase" || $r['EventType']=="Sales return"){
					$AsortmentRemains->amount=$r['assortmentAmount'];
					$AsortmentRemains->sum=$r['cost'];
					$AsortmentRemains->save();
				}
				elseif ($r['EventType']=="Sale" || $r['EventType']=="Purchase return"){
					$AsortmentRemains->amount=-$r['assortmentAmount'];
					$AsortmentRemains->sum=-$r['cost'];
					$AsortmentRemains->reserved=-$r['assortmentAmount'];
					$AsortmentRemains->sumreserved=-$r['cost'];
					$AsortmentRemains->save();
					//echo 'amount  '.$AsortmentRemains->amount;
					
				}elseif ($r['EventType']=="Transfer" ){
					$AsortmentRemains->amount=-$r['assortmentAmount'];
					$AsortmentRemains->sum=-$r['cost'];
					$AsortmentRemains->save();
					
					
					$AsortmentRemains = new AsortmentRemains;
					$AsortmentRemains->date=$Date1;
					$AsortmentRemains->eventdate=$day.'-'.$month.'-'.$year;
					$AsortmentRemains->eventid=$r['eventid'];
					$AsortmentRemains->assortmentid=$r['assortment_id'];
					$AsortmentRemains->authorid=$r['author'];
					$AsortmentRemains->warehouseid=$r['Subconto2'];
					$AsortmentRemains->contractorid=$r['contractor'];
					
					$Contractor=User::model()->findbypk($AsortmentRemains->contractorid);
					$User=User::model()->findbypk($AsortmentRemains->authorid);
					$Warehouse=Warehouse::model()->findbypk($r['Subconto2']);
					
					$AsortmentRemains->contractor=$Contractor->username;
					$AsortmentRemains->author=$User->username;
					$AsortmentRemains->warehouse=$Warehouse->name;
					$AsortmentRemains->assortment=$r['title'].' ('.$r['article'].')' ;
					$AsortmentRemains->event=$r['EventType'].' № '.$r['eventid'].' from '.$day.'-'.$month.'-'.$year;
					
					
					$AsortmentRemains->amount=$r['assortmentAmount'];
					$AsortmentRemains->sum=$r['cost'];
					$AsortmentRemains->save();
					
				}
				//$AssortmentRemains->date=$r->date';
				
			 } //foreach ($result as $r){
			  
			
		} //if (!empty($result)){
		
		
		//=== Если нужно получить движения по подчинённым контрагентам
		$new = array();
		if(!empty($ident)) {
			//$criteria->addCondition("a.id=".$ident); 
			$offset  = isset($_REQUEST['start'])  ? $this->html_escape($_REQUEST['start'])  :  0;
			$limit    = isset($_REQUEST['limit'])   ? $this->html_escape($_REQUEST['limit'])   : 50;
		
			$query = "SELECT * FROM tarex_asortmentremains WHERE assortmentid=" . $ident;
			$querycount = "SELECT COUNT(*) FROM tarex_asortmentremains WHERE assortmentid=" . $ident;
			
			$data_count = Yii::app()->db->createCommand($querycount)->queryScalar();
			
			$query .= " LIMIT ".$offset.",".$limit;
			$AsortmentRemains=AsortmentRemains::model()->findAllbySQL($query);
			
			//$sql = "SELECT COUNT(*) FROM {$table_name} WHERE " . $where;
		
			//$data_count=count($AsortmentRemains);
			
			foreach ($AsortmentRemains as $r){
				foreach($r as $key => $value)
				{
					$res[$key] = $value;
				}
				$new1[] = $res;	
				
				$new = array(
				'success'=>true,
				'data' =>  $new1,
				'count' => $data_count 
				); 
			}
			//print_r(json_encode($result));  	
			
			
		}else{		
		

			
			$command = Yii::app()->db->createCommand();     
			$resultQuery = $command->select('
			Sum(amount) as amount, 
			Sum(sum) as sum
			')->from('tarex_asortmentremains');
			
			
			$Begin  = $_REQUEST['Begin']!=''  ? $_REQUEST['Begin'] : '0001-01-01';
			$End  = $_REQUEST['End']!=''  ? $_REQUEST['End'] : '3000-01-01';
			
			$Begin =substr($Begin , 0, 10)." 00:00:00";
			$End =substr($End , 0, 10)." 23:59:59";
			//echo $End;
				
			if (!empty($filters)){
				
				$new=$this->FTestArray(0 , '', $filters, $Begin, $End);
			
			} //if (!empty($filters)){
		}
		
		print_r(json_encode($new));  	
}	

public function FTestArray($level, $filtered, $filterscopy, $Begin,$End ){

	$filter = $filterscopy[$level];
	$command = Yii::app()->db->createCommand(); 
	
	
	$field = isset($filter->property) ? $this->html_escape($filter->property) : $this->html_escape($filter->field);
	$value = $this->html_escape($filter->value);
	
	if (mb_strstr($field,'Assortment')!='' ) {
				$field='Assortment';
	}
	if (mb_strstr($field,'Document number')!='' ) {
				$field='eventid';
		if ($Begin!='') {
				if ($filtered!='') $command->where($filtered.' AND date>="'.$Begin.'"');
				else $command->where('date>="'.$Begin.'"');
		}
		if ($End!='') {
				if ($filtered!='') $command->where($command->where.' AND date<="'.$End.'"');
				else $command->where('date<="'.$End.'"');
		}				
	} 
	if (mb_strstr($field,'Document date')!='' ) {
				$field='eventdate';
		if ($Begin!='') {
				if ($filtered!='') $command->where($filtered.' AND date>="'.$Begin.'"');
				else $command->where('date>="'.$Begin.'"');
		}
		if ($End!='') {
				if ($filtered!='') $command->where($command->where.' AND date<="'.$End.'"');
				else $command->where('date<="'.$End.'"');
		}		
	}
	
	
	$resultQuery = $command->select('
	 amount, 
	'.$field.' as field
	')->from('tarex_asortmentremains');
	$command->group($field);
	
	if ( $filtered!='') {
		if ($command->where!='') $command->where.=(" AND ".$filtered." AND amount<>0");
		else $command->where($filtered." AND amount<>0");
	}
	
	$result = $resultQuery->queryAll();
	
	
	
	if (!empty($result)){
		//return $TestArray;
		if ( $filtered!='') $filtered.=' AND '.$field.'="';
		else $filtered=$field.'="';
		
		foreach ($result as $r){
			//return $TestArray;
			
			//$res['id']=$r['id'];  
			
			
			$res['OpeningBalance']=$this->FOpeningBalance($field, $filtered.$r['field'].'"', $Begin, $End);
			$res['Arrival']=$this->FMovement($field, $filtered.$r['field'].'"', $Begin, $End,"A");
			$res['Consumption']=$this->FMovement($field, $filtered.$r['field'].'"', $Begin, $End,"C");
			$res['ClosingBalance']=$res['OpeningBalance']+$res['Arrival']-$res['Consumption'];
			$res['Field']=$r['field']; 
			
			
			if (count($filterscopy)==$level+1){
				$res['leaf'] = true; 
				//if ($res['Field']!='')
				
				//if ($res['Arrival']>0 || $res['Consumption']>0)	
					$TestArray[]=$res;	 
				
			}	
			else {
				$res['leaf'] = false;
				//if ($res['Field']!='')
					$res['children'] = $this-> FTestArray($level+1, $filtered.$res['Field'].'"', $filterscopy,$Begin,$End ); 
					
				//if ($res['Arrival']>0 || $res['Consumption']>0)	
					$TestArray[]=$res;	
			}
			//$res['iconCls'] = task;
			
			
		} //foreach ($result as $r){
		/*if (empty($TestArray)) {
			$res['leaf'] = true;
			$res['Field']='empty';	
			$TestArray[]=$res;	 
		}*/
		
		
		
	}else{
		$res['leaf'] = true;
		$res['Field']='empty';	
		$TestArray[]=$res;	 
		
	}
	return $TestArray;

	//if (!empty($result)){
		
	
} //public function FTestArray($level, $filter, $filterscopy ){



public function FOpeningBalance($field, $filtered, $Begin,  $End){
	$command = Yii::app()->db->createCommand(); 
	$resultQuery = $command->select('
	Sum(amount) as amount, 
	Sum(sum) as sum, 
	'.$field.' as field
	')->from('tarex_asortmentremains');
	$command->group($field);
	//$command =$resultQuery;
	
	if ( $filtered!='') $command->where($filtered);
/*	if ($filtered!='') {
		if ($resultQuery->where!='') $resultQuery->where.=' AND '.$filtered;
		else $resultQuery->where($filtered);
	}
*/
	if ($Begin!='') {
		//echo 'Begin '.$Begin;
		if ($filtered!='') $command->where($filtered.' AND date<"'.$Begin.'"');
		else $command->where('date<"'.$Begin.'"');
	}
	//echo ''.$command->text.' Where '.$command->where ;
	//return;
	
	$result = $command->queryAll();
	$OpeningBalance=0;
	if (!empty($result)){
		foreach ($result as $r){
			//echo 'field '.$r['field'];
			$OpeningBalance=$r['amount'];
		}
	}
	//echo '<br><br><b>DETAILED QUERY BY ASSORTMENT ITEM: </b>"' , $resultQuery->where , '" ';

return $OpeningBalance;
}
public function FMovement($field, $filtered, $Begin,  $End,$flag){
	$command = Yii::app()->db->createCommand(); 
	$resultQuery = $command->select('
	Sum(amount) as amount, 
	Sum(sum) as sum, 
	Sum( IF( amount >0, amount, 0 ) ) AS Arrival,
	Sum( IF( amount <0, -amount, 0 ) ) AS Consumption,
	'.$field.' as field
	')->from('tarex_asortmentremains');
	$command->group($field);
	//$command =$resultQuery;
	
	if ( $filtered!='') $command->where($filtered);
/*	if ($filtered!='') {
		if ($resultQuery->where!='') $resultQuery->where.=' AND '.$filtered;
		else $resultQuery->where($filtered);
	}
*/
	if ($Begin!='') {
		//echo 'Begin '.$Begin;
		if ($filtered!='') $command->where($filtered.' AND date>="'.$Begin.'"');
		else $command->where('date>="'.$Begin.'"');
		//echo '1'.$command->where;
	}
	if ($End!='') {
		//echo 'Begin '.$Begin;
		if ($filtered!='') $command->where($command->where.' AND date<="'.$End.'"');
		else $command->where('date<="'.$End.'"');
		//echo '2'.$command->where;
	}
	//echo ''.$command->text;
	//return;
	
	$result = $command->queryAll();
	$OpeningBalance=0;
	if (!empty($result)){
		foreach ($result as $r){
			//echo 'field '.$r['field'];
			$OpeningBalance=  $flag=="A" ? $r['Arrival'] :  $r['Consumption'];
			
		}
	}
	//echo '<br><br><b>DETAILED QUERY BY ASSORTMENT ITEM: </b>"' , $resultQuery->where , '" ';

return $OpeningBalance;
}

	
	
public function actiontree()
	{
		$ModelName = $this->html_escape($_GET['Table']);	
		$node    = isset($_REQUEST['node'])   ? $this->html_escape($_REQUEST['node']):'root';
		$table_name = 'tarex_' . strtolower($ModelName);
		$offset  = isset($_REQUEST['start'])  ? $this->html_escape($_REQUEST['start'])  :  0;
		$limit    = isset($_REQUEST['limit'])   ? $this->html_escape($_REQUEST['limit'])   : 50;
		$filters  = isset($_REQUEST['filter'])  ? $_REQUEST['filter'] : null;
		
		
		//print_r($filters);
		if (is_array($filters)) {
			$encoded = false;
		} else {
			$encoded = true;
			$filters = json_decode($filters);
		}
		
		
		$where=' 1 = 1 ';
		if (is_array($filters)) {
			//echo 'encoded'.$encoded;
			for ($i=0;$i<count($filters);$i++){
				$filter = $filters[$i];
				$field = isset($filter->property) ? $this->html_escape($filter->property) : $this->html_escape($filter->field);
				$value = $this->html_escape($filter->value);
				
				if ($field=='Wharehouse' && $value!='') 
				{
					$realvalue=Warehouse::model()->findbyattributes(array('name'=>$value))->id;
					$where.= ' AND (Subconto1='.$realvalue.' OR Subconto2='.$realvalue.')';
				}
				if ($field=='Contractor' && $value!='') 
				{
					$realvalue=User::model()->findbyattributes(array('username'=>$value))->id;
					$where.= ' AND contractorId='.$realvalue;
				}
				if ($field=='Author' && $value!='') 
				{
					$realvalue=User::model()->findbyattributes(array('username'=>$value))->id;
					$where.= ' AND authorId='.$realvalue;
				}
				
				if ($field=='Assortment title' && $value!='') 	
				{
					
					$where.= ' AND title='.$value;
				}
				if ($field=='Assortment model' && $value!='') 	
				{
			
					$where.= ' AND model='.$value;
				}
				if ($field=='Assortment make' && $value!='') 	
				{
					
					$where.= ' AND make='.$value;
				}
				if ($field=='Assortment manufacturer' && $value!='') 	
				{
					
					$where.= ' AND manufacturer='.$value;
				}
				if ($field=='Assortment subgroup' && $value!='') 	
				{
					
					$where.= ' AND subgroup='.$value;
				}
				if ($field=='Document number' && $value!='') 	
				{
				
					$where.= ' AND eventId='.$value;
				}
				if ($field=='Document date' && $value!='') 	
				{
					
					$where.= ' AND Begin='.$value;
				}
				
				//if (!empty($realvalue))	$where.= 'AND '.$field.'='.$realvalue;
				//echo '<br>field '.$field;
			}
		}

		$query = "SELECT eventId, assortmentId, assortmentAmount, authorId, EventTypeId, organizationId, Begin, contractorId, subgroup, Subconto1, Subconto2, title, model, make, article, oem, manufacturer, country
		FROM {$table_name} 
		LEFT JOIN `tarex_events` ON  eventId=`tarex_events`.id
		LEFT JOIN `tarex_assortment` ON assortmentId = `tarex_assortment`.id
		WHERE " . $where;
		
		echo 'query '.$query;
		return;
		
		
		$data = CActiveRecord::model($ModelName)->findAllBySql($query); 
		$new = array();
	    foreach($data as $r) 
		{		  
			foreach($r as $key => $value)
			{
				//if($key!='assortmentAmount'){
					$res[$key] = $value;
				//}
				if ($key=='eventId'){
					$Event=Events::model()->findbypk($value);
					$res['Begin']=$Event->Begin;
					$res['EventTypeId']=$Event->EventTypeId;
					// if($Event->EventTypeId==32 || $Event->EventTypeId==18){ //Возврат поставщику/продажа
						// $res['assortmentAmount']=-$r['assortmentAmount'];
					// }elseif ($Event->EventTypeId==32 || $Event->EventTypeId==18){ //Покупка / возврат
						// $res['assortmentAmount']=$r['assortmentAmount'];
					// }
					$res['contractorId']=User::model()->findbypk($Event->contractorId)->username;
					$res['authorId']=User::model()->findbypk($Event->authorId)->username;
					$res['Subconto1']=Warehouse::model()->findbypk($Event->Subconto1)->name;
					$res['Subconto2']=Warehouse::model()->findbypk($Event->Subconto2)->name;
					//$res['Number']=$Event->authorId;
				
				}
				if ($key=='assortmentId'){
					$Assortment=Assortment::model()->findbypk($value);
					$res['title']=$Assortment->title;
					$res['model']=$Assortment->model;
					$res['make']=$Assortment->make;
					$res['manufacturer']=$Assortment->manufacturer;
					$res['subgroup']=$Assortment->subgroup;
					
				}
				$res['leaf'] = true;
				$res['iconCls'] = task;
				
			}
			$new[] = $res;
			
		} 
		
		$result = array(
			'success'=>true,
			'children' =>  $new,
			//'count' => $data_count 
		); 
		print_r(json_encode($result));  		
	
	
	
	}
	
	
	
	
public function actionItemmovement(){
	
	AsortmentRemains::model()->deleteAll();
	

	
}



public function actionIndex()
	{
		//echo '$_GET[filter] = ';  print_r($_GET['filter']); echo '<br/><br/><br/>';
		// calling line :
		/*
		http://www.k-m.ru/app2/index.php?r=backend/index&Table=Assortment&_dc=1401196798272&page=1&start=0&limit=20&filter[0][field]=price&filter[0][data][type]=numeric&filter[0][data][comparison]=lt&filter[0][data][value]=5&filter[0][field]=price&filter[0][data][type]=numeric&filter[0][data][comparison]=lt&filter[0][data][value]=56&filter[1][field]=size&filter[1][data][type]=list&filter[1][data][value]=medium,large
		*/
// filter[0][operator]=OR&filter[0][field]=title&filter[0][data][type]=string&filter[0][data][value]=ela
		$ModelName = $this->html_escape($_GET['Table']);			
 
		$table_name = 'tarex_' . strtolower($ModelName);
	    /*try {
			$check_qry = "SHOW TABLES FROM `kmru_tarex` LIKE '{$table_name}' ;";
			$list = Yii::app()->db->createCommand($check_qry)->queryAll();
			if (!$list) print_r( json_encode(array('success'=> 'false' , 'msg'=> Yii::t('general', 'There is no such class in the system'))));  
		}  
		catch (Exception $e) 
			{  return json_encode(array('success'=> false , 'msg'=> Yii::t('general', 'There is no such class in the system')));
			} 
 		*/
		//echo 'ModelName '.$table_name;
		//return;		
		
	// collect request parameters
		$offset  = isset($_REQUEST['start'])  ? $this->html_escape($_REQUEST['start'])  :  0;
		$limit    = isset($_REQUEST['limit'])   ? $this->html_escape($_REQUEST['limit'])   : 50;
		
		$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']    : null;
		$dir      = isset($_REQUEST['dir'])     ? $this->html_escape($_REQUEST['dir'])  : 'ASC';
		$filters  = isset($_REQUEST['filter'])  ? $_REQUEST['filter'] : null;
		$distinct  = isset($_REQUEST['distinct'])  ? $_REQUEST['distinct'] : null;
		$fields  = isset($_REQUEST['fields'])  ? $_REQUEST['fields'] : null;
		$compareField  = isset($_REQUEST['compareField'])  ? $_REQUEST['compareField'] : null;
		$log  = isset($_REQUEST['log'])  ? $_REQUEST['log'] : null;
		$query  = isset($_REQUEST['query'])  ? $_REQUEST['query'] : null;
		//$queryfield  = isset($_REQUEST['queryfield'])  ? $_REQUEST['queryfield'] : null;
		$id  = isset($_REQUEST['id'])  ? $_REQUEST['id'] : '';
				
		$filters1 = isset($_REQUEST['filters'])  ? $_REQUEST['filters'] : null;
		//print_r($filters1);
		//return;
		
		// GridFilters sends filters as an Array if not json encoded
		if (is_array($filters)) {
			$encoded = false;
		} else {
			$encoded = true;
			$filters = json_decode($filters);
		}
		
		$where = ' 0 = 0 ';
		$qs = '';

		// loop through filters sent by client
		if (is_array($filters)) {
			for ($i=0;$i<count($filters);$i++){
				$filter = $filters[$i];

				//print_r($encoded);
				//.'<br>';
				// assign filter data (location depends if encoded or not)
				if ($encoded) {
					$field = isset($filter->property) ? $this->html_escape($filter->property) : $this->html_escape($filter->field);
					
					$value = $this->html_escape($filter->value);
					$compare = isset($filter->comparison) ? $this->html_escape($filter->comparison) : null;
					$operand = isset($filter->operand) ? $this->html_escape($filter->operand) : "AND";
					$filterType = $this->html_escape($filter->type);
					if ($compare!=null){
						$qs .= " ".$operand." ".$field." ".$compare." '".$value."'"; 
					}else{
						$value = addcslashes($value, '%_"');
						$qs .= " ".$operand." ".$field." LIKE \"%{$value}%\" "; 
					}   
					// 		$r = addcslashes($r, '%_"');
					//		$criteria->condition .= ( " AND title LIKE \"%{$r}%\" "); 
					//if ($log==1) echo $qs;
					//Break;
					//echo $value;
				} else {
					$field = $this->html_escape($filter['field']);
					$value = $this->html_escape($filter['data']['value']);
					$compare = isset($filter['data']['comparison']) ? $this->html_escape($filter['data']['comparison']) : null;
					$filterType = $this->html_escape($filter['data']['type']);
				}

				switch($filterType){
					case 'string' : 
						$value = addcslashes($value, '%_"');
						$qs .= " AND ".$field." LIKE \"%{$value}%\" "; 
						break;
					case 'list' :
						if (strstr($value,',')){
							$fi = explode(',',$value);
							for ($q=0;$q<count($fi);$q++){
								$fi[$q] = "'".$fi[$q]."'";
							}
							$value = implode(',',$fi);
							$qs .= " AND ".$field." IN (".$value.")";
						}else{
							$qs .= " AND ".$field." = '".$value."'";
						}
					Break;
					case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
					case 'numeric' :
						switch ($compare) {
							case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
							case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
							case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
						}
					Break;
					case 'date' :
						switch ($compare) {
							case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
							case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
							case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
						}
					Break;
				}
			}
			$where .= $qs;		
		}
		
		// если передан id то добавляем его в условие
		if($id!=''){
			if ($where=='') $where='id='.$id;
			else $where .=' AND id='.$id;
		}		
		
	//  отдельно поля для сравнения со значением query	
		if(!empty($query) && !empty($compareField)){
			$where .= " AND ".$this->html_escape($compareField)." LIKE '%".$this->html_escape($query)."%'";
			} 
		// надо бы это реализовать это через параметры (http://www.yiiframework.com/wiki/199/creating-a-parameterized-like-query/) - но пока там это только через CDbCriteria или напрямую в findAll() например:
		// $comments = Comments::model()->findAll(
		// 'content LIKE :match',
		// array(':match' => "%$match%") );
			
		
		
	// задаём $querySQL чтобы не путать её с $query - входным параметром ajax запроса
		$querySQL = "SELECT * FROM {$table_name} WHERE " . $where;
		//echo $query;
		//return;
		if (!empty($fields)){
			if ($distinct==1) 
				$querySQL = "SELECT DISTINCT ".$fields." FROM {$table_name} WHERE " . $where;
			else 
				$querySQL = "SELECT ".$fields." FROM {$table_name} WHERE " . $where;
			
			//echo $querySQL;
		}
		
		
		// добавление сортировки и ограничений на вывод
		//print_r('sort'.$sort);
			
		if (is_array($sort)) {
			$encoded = false;
		} else {
			$encoded = true;
			$sort = json_decode($sort);
		}
		
		//print_r('sort'.$sort);
		
		//echo $encoded;
		if (is_array($sort)) {
			for ($i=0;$i<count($sort);$i++){
				$sortr = $sort[$i];
				//echo '111'.$sortr;
				
				$field = $this->html_escape($sortr->property);
				$direction = $this->html_escape($sortr->direction);
				$querySQL .= " ORDER BY ".$field." ".$direction;
				//echo 'query '.$query; Break;
			}
		}		
		if (!isset($_REQUEST['unlimited'])){ 
			$querySQL .= " LIMIT ".$offset.",".$limit;
		}

		$sql = "SELECT COUNT(*) FROM {$table_name} WHERE " . $where;
		$data_count = Yii::app()->db->createCommand($sql)->queryScalar();
		
		if ($log==1){
			echo 'запрос = ', $querySQL, '<br><br>'; // показ окончательного запроса
			return;
		}
		
		//$criteria = new CDbCriteria;	    
		//$data_count = CActiveRecord::model($ModelName)->count($criteria); 
		
		//$criteria->addCondition( $filter['']) 
		//$criteria->select = array('id', 'oem', 'article', 'title', 'make');
		
		// добавляем параметры постраничного вывода
		
		/*
		$criteria->limit = $_GET['limit'] ? $_GET['limit'] : 20; //echo "Limit  = ", $_GET['limit'];
		$criteria->offset = $_GET['start'] ? $_GET['start'] : 0; 
		*/
		
		//echo '$criteria = '; print_r($criteria->toArray()); echo '<br/>';
		//$data = CActiveRecord::model($ModelName)->findAll($criteria); 
		$data = CActiveRecord::model($ModelName)->findAllBySql($querySQL); 
		
	//	print_r($data);
		  		
		/*
		$criteria=new CDbCriteria(array(
		'select'=>'t.*,count(j.*)',
		'join'=>'left join CountTbl j on condition',
		'order'=>'count(j.*)',
		))

		$criteria->condition='id=:id AND login=:login';
		$criteria->params=array(':id'=>5, ':login' => 'test');  // задаем параметры
*/
		$new = array();
	    foreach($data as $r) 
		{		  
			foreach($r as $key => $value)
			{
				$res[$key] = $value;
			}
			$new[] = $res;
		} 
		$result = array(
			'success'=>true,
			'data' =>  $new,
			'count' => $data_count 
		); 
		print_r(json_encode($result));  		
	}
	
	public function actionIndex3()
	{	  
		$ModelName = $this->html_escape($_GET['Table']);	
		$table_name = 'tarex_' . strtolower($ModelName);
	    /*try {
			$check_qry = "SHOW TABLES FROM `kmru_tarex` LIKE '{$table_name}' ;";
			$list = Yii::app()->db->createCommand($check_qry)->queryAll();
			if (!$list) print_r( json_encode(array('success'=> 'false' , 'msg'=> Yii::t('general', 'There is no such class in the system'))));  
		}  
		catch (Exception $e) 
			{  return json_encode(array('success'=> false , 'msg'=> Yii::t('general', 'There is no such class in the system')));
			} 
 		*/
		//echo 'ModelName '.$table_name;
		//return;
		
		// collect request parameters
		$offset  = isset($_REQUEST['start'])  ? $this->html_escape($_REQUEST['start'])  :  0;
		$limit    = isset($_REQUEST['limit'])   ? $this->html_escape($_REQUEST['limit'])   : 50;
		
		$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']    : null;
		$dir      = isset($_REQUEST['dir'])     ? $this->html_escape($_REQUEST['dir'])  : 'ASC';
		$filters  = isset($_REQUEST['filter'])  ? $_REQUEST['filter'] : null;
		$distinct  = isset($_REQUEST['distinct'])  ? $_REQUEST['distinct'] : null;
		$fields  = isset($_REQUEST['fields'])  ? $_REQUEST['fields'] : null;
		$log  = isset($_REQUEST['log'])  ? $_REQUEST['log'] : null;
		$query  = isset($_REQUEST['query'])  ? $_REQUEST['query'] : null;
		
		// GridFilters sends filters as an Array if not json encoded
		if (is_array($filters)) {
			$encoded = false;
		} else {
			$encoded = true;
			$filters = json_decode($filters);
		}
		
		$where = ' 0 = 0 ';
		$qs = '';

		// loop through filters sent by client
		if (is_array($filters)) {
			for ($i=0;$i<count($filters);$i++){
				$filter = $filters[$i];

				//print_r($encoded);
				//.'<br>';
				// assign filter data (location depends if encoded or not)
				if ($encoded) {
					$field = isset($filter->property) ? $this->html_escape($filter->property) : $this->html_escape($filter->field);
					
					$value = $this->html_escape($filter->value);
					$compare = isset($filter->comparison) ? $this->html_escape($filter->comparison) : null;
					$operand = isset($filter->operand) ? $this->html_escape($filter->operand) : "AND";
					$filterType = $this->html_escape($filter->type);
					if ($compare!=null){
						$qs .= " ".$operand." ".$field." ".$compare." '".$value."'"; 
					}else{
						$qs .= " " . $operand." ". $field . " LIKE \"%".$value."%\" "; 
					}
					//if ($log==1) echo $qs;
					//Break;
					//echo $value;
				} else {
					$field = $this->html_escape($filter['field']);
					$value = $this->html_escape($filter['data']['value']);
					$compare = isset($filter['data']['comparison']) ? $this->html_escape($filter['data']['comparison']) : null;
					$filterType = $this->html_escape($filter['data']['type']);
				}

				switch($filterType){
					case 'string' : $qs .= " AND " . $field . " LIKE \"%". $value . "%\" " ; break;
					case 'list' :
						if (strstr($value,',')){
							$fi = explode(',',$value);
							for ($q=0;$q<count($fi);$q++){
								$fi[$q] = "'".$fi[$q]."'";
							}
							$value = implode(',',$fi);
							$qs .= " AND ".$field." IN (".$value.")";
						}else{
							$qs .= " AND ".$field." = '".$value."'";
						}
					Break;
					case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
					case 'numeric' :
						switch ($compare) {
							case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
							case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
							case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
						}
					Break;
					case 'date' :
						switch ($compare) {
							case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
							case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
							case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
						}
					Break;
				}
			}
			$where .= $qs;
		
		}
		
		if(!empty($query)){
			$where .= " AND Name LIKE '%".$this->html_escape($query)."%'";
		}
		
		$query = "SELECT * FROM {$table_name} WHERE " . $where;
		//echo $query;
		//return;
		
	
		
		if (!empty($fields)){
			$query = "SELECT ".$fields." FROM {$table_name} WHERE " . $where;
			if ($distinct==1) $query = "SELECT DISTINCT ".$fields." FROM {$table_name} WHERE " . $where;
			//echo $query;
		}
		
		

		
		
		
		//header('Content-type:text/html; charset=utf-8');
		//echo 'sql=', $sql, '<br>';
		//$data_count = CActiveRecord::model($ModelName)->count($criteria);
		//echo '$sql count = ' , $data_count, '<br>';
		
		// добавление сортировки и ограничений на вывод
		//print_r('sort'.$sort);
			
		if (is_array($sort)) {
			$encoded = false;
		} else {
			$encoded = true;
			$sort = json_decode($sort);
		}
		
		//print_r('sort'.$sort);
		
		//echo $encoded;
		if (is_array($sort)) {
			for ($i=0;$i<count($sort);$i++){
				$sortr = $sort[$i];
				//echo '111'.$sortr;
				
				$field = $this->html_escape($sortr->property);
				$direction = $this->html_escape($sortr->direction);
				$query .= " ORDER BY ".$field." ".$direction;
				//echo 'query '.$query; Break;
			}
		}		
		if (!isset($_REQUEST['unlimited'])){ 
			$query .= " LIMIT ".$offset.",".$limit;
		}

		$sql = "SELECT COUNT(*) FROM {$table_name} WHERE " . $where;
		$data_count = Yii::app()->db->createCommand($sql)->queryScalar();
		
		if ($log==1){
			echo 'запрос = ', $query, '<br><br>'; // показ окончательного запроса
			return;
		}
		
		//$criteria = new CDbCriteria;	    
		//$data_count = CActiveRecord::model($ModelName)->count($criteria); 
		
		//$criteria->addCondition( $filter['']) 
		//$criteria->select = array('id', 'oem', 'article', 'title', 'make');
		
		// добавляем параметры постраничного вывода
		
		/*
		$criteria->limit = $_GET['limit'] ? $_GET['limit'] : 20; //echo "Limit  = ", $_GET['limit'];
		$criteria->offset = $_GET['start'] ? $_GET['start'] : 0; 
		*/
		
		//echo '$criteria = '; print_r($criteria->toArray()); echo '<br/>';
		//$data = CActiveRecord::model($ModelName)->findAll($criteria); 
		$data = CActiveRecord::model($ModelName)->findAllBySql($query); 
		
	//	print_r($data);
		  		
		/*
		$criteria=new CDbCriteria(array(
		'select'=>'t.*,count(j.*)',
		'join'=>'left join CountTbl j on condition',
		'order'=>'count(j.*)',
		))

		$criteria->condition='id=:id AND login=:login';
		$criteria->params=array(':id'=>5, ':login' => 'test');  // задаем параметры
*/
		$new = array();
	    foreach($data as $r) 
		{		  
			foreach($r as $key => $value)
			{
				$res[$key] = $value;
			}
			$new[] = $res;
		} 
		$result = array(
			'success'=>true,
			'data' =>  $new,
			'count' => $data_count 
		); 
		print_r(json_encode($result));  		
	}
	
	
	
	public function actionIndex2()
	{
		//echo '$_GET[filter] = ';  print_r($_GET['filter']); echo '<br/><br/><br/>';
		// calling line :
		/*
		http://www.k-m.ru/app2/index.php?r=backend/index&Table=Assortment&_dc=1401196798272&page=1&start=0&limit=20&filter[0][field]=price&filter[0][data][type]=numeric&filter[0][data][comparison]=lt&filter[0][data][value]=5&filter[0][field]=price&filter[0][data][type]=numeric&filter[0][data][comparison]=lt&filter[0][data][value]=56&filter[1][field]=size&filter[1][data][type]=list&filter[1][data][value]=medium,large
		*/
// filter[0][operator]=OR&filter[0][field]=title&filter[0][data][type]=string&filter[0][data][value]=ela
		$ModelName = $_GET['Table'];		
	/*	if (!class_exists($ModelName, false)) 
			return json_encode(array('success'=> false , 'msg'=> Yii::t('general', 'There is no such class in the system')));*/
			
		$table_name = 'tarex_' . strtolower($ModelName);
		// collect request parameters
		$offset  = isset($_REQUEST['start'])  ? $_REQUEST['start']  :  0;
		$limit  = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 50;
		$sort   = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
		$dir    = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
		$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;
		
		// GridFilters sends filters as an Array if not json encoded
		if (is_array($filters)) {
			$encoded = false;
		} else {
			$encoded = true;
			$filters = json_decode($filters);
		}
		
		$where = ' 0 = 0 ';
		$qs = '';

		// loop through filters sent by client
		if (is_array($filters)) {
			for ($i=0;$i<count($filters);$i++){
				$filter = $filters[$i];

				// assign filter data (location depends if encoded or not)
				if ($encoded) {
					$field = $filter->field;
					$value = $filter->value;
					$compare = isset($filter->comparison) ? $filter->comparison : null;
					$filterType = $filter->type;
				} else {
					$field = $filter['field'];
					$value = $filter['data']['value'];
					$compare = isset($filter['data']['comparison']) ? $filter['data']['comparison'] : null;
					$filterType = $filter['data']['type'];
				}

				switch($filterType){
					case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%' "; Break;
					case 'list' :
						if (strstr($value,',')){
							$fi = explode(',',$value);
							for ($q=0;$q<count($fi);$q++){
								$fi[$q] = "'".$fi[$q]."'";
							}
							$value = implode(',',$fi);
							$qs .= " AND ".$field." IN (".$value.")";
						}else{
							$qs .= " AND ".$field." = '".$value."'";
						}
					Break;
					case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
					case 'numeric' :
						switch ($compare) {
							case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
							case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
							case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
						}
					Break;
					case 'date' :
						switch ($compare) {
							case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
							case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
							case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
						}
					Break;
				}
			}
			$where .= $qs;
		}
		
		$query = "SELECT * FROM {$table_name} WHERE " . $where;
		/// "SELECT COUNT(id) FROM demo WHERE ".$where
		$sql = "SELECT COUNT(*) FROM {$table_name} WHERE " . $where;
		header('Content-type:text/html; charset=utf-8');
		echo '$sql=', $sql, '<br>';
		$data_count = Yii::app()->db->createCommand($sql)->queryScalar();
		//$data_count = CActiveRecord::model($ModelName)->count($criteria);
		echo '$sql count = ' , $data_count, '<br>';
		
		// добавление сортировки и ограничений на вывод
		if ($sort != "") {
			$query .= " ORDER BY ".$sort." ".$dir;
		}		
		//$query .= " LIMIT ".$offset.",".$limit;
		
		//echo 'запрос с сортировкой и ограничением на вывод: $query = ', $query, '<br><br>'; // показ окончательного запроса
		
		
		
		$criteria = new CDbCriteria;	    
		//$data_count = CActiveRecord::model($ModelName)->count($criteria); 
		
		//$criteria->addCondition( $filter['']) 
		//$criteria->select = array('id', 'oem', 'article', 'title', 'make');
		
		// добавляем параметры постраничного вывода
		
		/*
		$criteria->limit = $_GET['limit'] ? $_GET['limit'] : 20; //echo "Limit  = ", $_GET['limit'];
		$criteria->offset = $_GET['start'] ? $_GET['start'] : 0; 
		*/
		
		//echo '$criteria = '; print_r($criteria->toArray()); echo '<br/>';
		//$data = CActiveRecord::model($ModelName)->findAll($criteria); 
		$data = CActiveRecord::model($ModelName)->findAllBySql($query); 
		
	//	print_r($data);
		
		//$table_name='yiiapp_'.$Table; 

		//$variable = 'MainMenu';       
		//$TestData =  $variable::model()->findAll(); // since 5.3
		
		/*
		$criteria=new CDbCriteria(array(
		'select'=>'t.*,count(j.*)',
		'join'=>'left join CountTbl j on condition',
		'order'=>'count(j.*)',
		))

		$criteria->condition='id=:id AND login=:login';
		$criteria->params=array(':id'=>5, ':login' => 'test');  // задаем параметры
*/
		$new = array();
	    foreach($data as $r) 
		{		 
			/*$res['id']=$r['id'];	
			$res['title']=$r['title'];	
			$res['oem']=$r['oem'];				
			$res['article']=$r['title'];	
			$res['make']=$r['make'];	*/
			foreach($r as $key => $value)
			{
				$res[$key] = $value;
			}
			$new[] = $res;
		} 
		 $result = array(
			'success'=>true,
			'data' =>  $new,
			'count' => $data_count //sizeof($new)
		  );
		//echo 'TestData '.$TestData;
		print_r(json_encode($result)); 
		
		
	}
	
}