<?php
$Table=$_GET['Table'];
$Fields=$_GET['Fields'];
$User=$_GET['UserId'];
$table_name='yiiapp_'.$Table;


//echo 'table_name '.$table_name;

//$TestData=MainMenu::model()->findAll();

//echo 'TestData '.$TestData;
print_r(json_encode($TestData)); 

?>