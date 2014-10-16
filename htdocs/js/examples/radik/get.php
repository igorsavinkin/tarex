<?php
require_once('../app/dbconnection.php');
$_db = init_db();
$Table=$_GET['Table'];
$Fields=$_GET['Fields'];

$table_name=''.$Table;
$start = $_GET['start'] ? $_GET['start'] : 0;
$end = $_GET['limit'] ? $_GET['limit'] : 25;
$Limit =  " LIMIT {$start}, {$end}";

$res = getTableFields2($_db,  $table_name , '' , $Condition , $Limit );
$count=getTotal($_db,  $table_name , $Condition );

  $result = array(
   'success'=>true,
    'data' => $res,
    'count' => $count
  );
print_r(json_encode($result)); 

?>