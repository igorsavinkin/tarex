<?php 
require_once('DbConnection.php');
$_db = init_db();

$Table=$_GET['Table'];
$Fields=$_GET['Fields'];
$User=$_GET['UserId'];
$table_name='yiiapp_'.$Table;

//$start = $_GET['start'] ? $_GET['start'] : 0;
//$end = $_GET['limit'] ? $_GET['limit'] : 25;
//$Limit =  " LIMIT {$start}, {$end}";


$Filter= json_decode($_GET['filter']);
//print_r($Filter);

$Condition="`UserId` LIKE  '%".$User."%' ";
if (!empty($Filter)){
	$Condition.=" AND `title` LIKE '%".$Filter[0]->value."%' ";
	//echo 'Condition '.$Condition;
}

$Subsystem=$_GET['Subsystem'];
if (!empty($Subsystem)){
	$Condition.=" AND `Subsystem` = '".$Subsystem."' ";
	//echo 'Condition '.$Condition;
}


$res = getUniqueTableFields($_db,  $table_name , $Fields , $Condition);

  $result = array(
    'success'=>true,
    'data' => $res,
    //'count' => sizeof($res)
  );
  
  
print_r(json_encode($result)); 

?>