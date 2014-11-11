<?php 
require_once('DbConnection.php');
$_db = init_db();

$Table=$_GET['Table'];
$Fields=$_GET['Fields'];
$User=$_GET['UserId'];
$table_name='yiiapp_'.$Table;
$Condition=$_GET['Condition'];

//$start = $_GET['start'] ? $_GET['start'] : 0;
//$end = $_GET['limit'] ? $_GET['limit'] : 25;
//$Limit =  " LIMIT {$start}, {$end}";

//if ($Table='') echo 'Table1 '.$Table;
//$Filter= json_decode($_GET['filter']);



$res = getTableFields2($_db,  $table_name , $Fields , $Condition);

  $result = array(
    'success'=>true,
    'data' => $res,
    //'count' => sizeof($res)
  );
  
  
print_r(json_encode($result)); 

?>