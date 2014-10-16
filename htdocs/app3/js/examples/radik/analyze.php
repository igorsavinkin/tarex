<?php
require_once('../app/dbconnection.php');
$_db = init_db();


$Begin=$_GET['Begin'];
$End=$_GET['End'];

//echo 'Begin'.$Begin." End ".$End;

$tableName='test_data';
$SQLTR='Truncate table test_data_analyze';
mysqli_query($_db, $SQLTR);


$condition="Date >= '".$Begin."' AND Date <= '".$End."'";
$SQL="SELECT * FROM `{$tableName}`  WHERE {$condition}";

//echo $SQL;

$result = mysqli_query($_db, $SQL);
$array = array();    
if ($result !== FALSE) 
{
	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
	{
		
			$H=round($row['H'],4);
			$L=round($row['L'],4);
			$O=round($row['O'],4);
			$C=round($row['C'],4);
			$Delta=round(($H*10000-$L*10000),0);
			$Volume=$row['Volume'];
	/*		
	$O=1.387;
	$C=1.386;
	$H=1.3878;
	$L=1.3866;
	$Volume=100;		
		*/	
			
			if ($O<=$C){
				//echo 'Delta <=10 '.$Delta.' H '.$H.' L '.$L.'<br>';
				FInsertValue($H,$L,$Volume,1);
				//return;
			}else{
				FInsertValue($H,$L,$Volume,-1);
				//return;
			
			}
			
			
			//$array[$i][$field] = $row[$field]; 
			
	}
	mysqli_free_result($result);
} else { 

 throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($_db) ); 


} 
         
function FInsertValue($H,$L,$Volume,$ident){

	//echo 'ident '.$ident;

	
	$Delta=round(($H*10000-$L*10000),0)+1;
	if($Delta!=0){
		$VolumPerPoint=$Volume/$Delta;
	}else{
		$VolumPerPoint=$Volume;
	}
	
	if($Delta>10){
		//Посчитаем 30% от V
		$V30=round(30*$Volume/100,0);
		$V70=round($Volume-$V30,0);
		
		//Сколько пунктов нужно пройти чтобы достичь границы в 30%?
		$D30=round(30*$Delta/100,0);
		$D70=$Delta-$D30;
		$VolumPerPoint30=round($V70/$D30,0); //70% объёма нужно ровно уложить в первые 30% бара
		$VolumPerPoint70=round($V30/$D70,0); //30% объёма нужно ровно уложить в оставшиеся 70% бара
	}
	
	$_db = init_db();
	
//	echo 'Delta '.$Delta." VolumPerPoint ".$VolumPerPoint." H ".$H." L ".$L;
	
	$Pointer=1;
	while ($L<=$H){
		$SQL="SELECT * FROM `test_data_analyze`  WHERE `Price`=".$L."";
		//echo "SQL ".$SQL;
		$result1 = mysqli_query($_db, $SQL);
		if ($ident>0){
			if($Delta>10 && $Pointer<=$D30) $VolumPerPoint=$VolumPerPoint30; 
			if($Delta>10 && $Pointer>$D30) $VolumPerPoint=$VolumPerPoint70;		
		}else{
			if($Delta>10 && $Pointer<=$D70) $VolumPerPoint=$VolumPerPoint70; 
			if($Delta>10 && $Pointer>$D70) $VolumPerPoint=$VolumPerPoint30;		
		}
		
		
		if ($result1->num_rows == 0) {

			
			$SQLINS="Insert into `test_data_analyze`  values (".$L.", ".$VolumPerPoint.")";
			//echo $SQLINS." num_rows ".$result1->num_rows;
			mysqli_query($_db, $SQLINS);
			
		}else{
			while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH )) 
			{
				
				$OldVolume=$row1['SumVolume'];
				$NewVolume=$OldVolume+$VolumPerPoint;
				//echo ' OldVolume '.$OldVolume." Volume ".$Volume;
				$SQLUPD="UPDATE `test_data_analyze` Set `SumVolume`=".$NewVolume." Where `Price`=".$L."";
				//echo $SQLUPD;
				mysqli_query($_db, $SQLUPD);
			}
		}
		mysqli_free_result($result1);
		$L += 0.0001;
		$Pointer++;
	}
}
	
function FInsertReverseValue($H,$L,$Volume){

	
	
	$Delta=round(($H*10000-$L*10000),0)+1;
	if($Delta!=0){
		$VolumPerPoint=$Volume/$Delta;
	}else{
		$VolumPerPoint=$Volume;
	}
	
	if($Delta>10){
		//Посчитаем 30% от V
		$V30=round(30*$Volume/100,0);
		$V70=round($Volume-$V30,0);
		
		//Сколько пунктов нужно пройти чтобы достичь границы в 30%?
		$D30=round(30*$Delta/100,0);
		$D70=$Delta-$D30;
		$VolumPerPoint30=round($V70/$D30,0); //70% объёма нужно ровно уложить в первые 30% бара
		$VolumPerPoint70=round($V30/$D70,0); //30% объёма нужно ровно уложить в оставшиеся 70% бара
	}
	
	$_db = init_db();
	
//	echo 'Delta '.$Delta." VolumPerPoint ".$VolumPerPoint." H ".$H." L ".$L;
	
	$Pointer=1;
	while ($L<=$H){
		$SQL="SELECT * FROM `test_data_analyze`  WHERE `Price`=".$L."";
		//echo "SQL ".$SQL;
		$result1 = mysqli_query($_db, $SQL);
		if($Delta>10 && $Pointer<=$D30) $VolumPerPoint=$VolumPerPoint70;
		if($Delta>10 && $Pointer>$D30) $VolumPerPoint=$VolumPerPoint30;		
		
		if ($result1->num_rows == 0) {

			
			$SQLINS="Insert into `test_data_analyze`  values (".$L.", ".$VolumPerPoint.")";
			//echo $SQLINS." num_rows ".$result1->num_rows;
			mysqli_query($_db, $SQLINS);
			
		}else{
			while ($row1 = mysqli_fetch_array($result1, MYSQLI_BOTH )) 
			{
				
				$OldVolume=$row1['SumVolume'];
				$NewVolume=$OldVolume+$VolumPerPoint;
				//echo ' OldVolume '.$OldVolume." Volume ".$Volume;
				$SQLUPD="UPDATE `test_data_analyze` Set `SumVolume`=".$NewVolume." Where `Price`=".$L."";
				//echo $SQLUPD;
				mysqli_query($_db, $SQLUPD);
			}
		}
		mysqli_free_result($result1);
		$L += 0.0001;
		$Pointer++;
	}
}
  // $result = array(
   // 'success'=>true,
    // 'data' => $array,
    // 'count' => $count
  // );
  
//print_r(json_encode($result)); 

?>