<?php 
require_once('DbConnection.php');
$_db = init_db();

$Table=$_GET['Table'];
$Fields=$_GET['Fields'];

$table_name='yiiapp_'.$Table;

$start = $_GET['start'] ? $_GET['start'] : 0;
$end = $_GET['limit'] ? $_GET['limit'] : 20;
$Limit =  " LIMIT {$start}, {$end}";

$Filter= json_decode($_GET['filter']);
//print_r($Filter);

$Condition="`OrganizationId`=7";
if (!empty($Filter)){
	$Condition.=" AND `title` LIKE '%".$Filter[0]->value."%' ";
	//echo 'Condition '.$Condition;
}

$Param=$_GET['Param1'];
if (!empty($Param)) {
	$Condition .= " AND `title` LIKE '%".$Param."%' "; //echo 'Condition '.$Condition;
}

$res = getTableFields2($_db,  $table_name , '' , $Condition , $Limit );
$count=getTotal($_db,  $table_name , $Condition );

$result = array(
    'success'=>true,
    'data' => $res,
    'count' => $count
);

print_r(json_encode($result)); 
?>