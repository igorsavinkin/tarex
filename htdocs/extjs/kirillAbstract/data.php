<?php

$data = array();

for($i=0;$i<28;$i++){
	$data[] = array(
		'date' => '2014-06-'.$i,
		'data1'=>rand(1,99),
		'data2'=>rand(1,99),
		'data3'=>rand(1,99),
	);
}
echo json_encode(array('success'=>true,'data'=>$data));
?>
