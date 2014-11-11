<?php
/*************************************** functions **************************************/
function init_db() { 

	//$db_handler = mysqli_connect('localhost', 'root', 'wl41kyNc', 'tarex'); // wl41kyNc
	$db_handler = mysqli_connect('localhost', 'kmru_tarex', 'Saturn78', 'kmru_tarex');
    $db_handler->set_charset('utf8');

    // check connection 
    if (mysqli_connect_errno()) {
        throw new Exception ("Error connecting to DB : " . mysqli_connect_error()  );
    }              
    
    // set autocommit to off 
    mysqli_autocommit($db_handler, FALSE);
    
    mysqli_query ($db_handler, "set time_zone='Europe/Minsk'");
   
    return $db_handler;
}

function getTotal($db_handler, $tableName, $condition = 1) 
{  
	if($condition != ''){  
		$res = mysqli_query($db_handler, "SELECT count(*) FROM `{$tableName}`  WHERE {$condition}");  
	}else{
		$res = mysqli_query($db_handler, "SELECT count(*) FROM `{$tableName}`");  
	}
  
//  if ($res ==false) return 0; else  return mysqli_fetch_array($res)[0]; //  , '<br><br>';
    //echo 'test '.mysqli_fetch_array($res)[0];
	return mysqli_fetch_array($res)[0]; //  , '<br><br>';
	
}

function showTables($db_handler)
{
	$query = "SHOW TABLES  LIKE 'yiiapp_%' "; // AND (NOT LIKE '%1%') 
	$result = mysqli_query($db_handler, $query);
	$t = array();
	while ($table = mysqli_fetch_array($result, MYSQLI_NUM )) 
	{
        //echo $table[0], '<br>';
		$t[] = $table[0];
	}	 
	return $t;
}

function getTable($db_handler, $tableName, $condition = 1) {   
///echo $tableName, '<br>';
//print_r($db_handler); echo '<br>';
	$columns = FetchColumns($db_handler, $tableName);
    $result = mysqli_query($db_handler, "SELECT * FROM `{$tableName}`  WHERE {$condition}");
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
			{
                foreach($columns as $column)
			    	$array[$i][$column] = $row[$column]; 
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
         
    return $array;
}
function getTableFields($db_handler, $tableName, $fields, $condition = 1) {   
	//$columns = FetchColumns($db_handler, $tableName);
	$columns = implode(',' , $fields);
    $result = mysqli_query($db_handler, "SELECT {$columns} FROM `{$tableName}`  WHERE {$condition}");
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
			{
                foreach($fields as $field)
			    	$array[$i][$field] = $row[$field]; 
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
         
    return $array;
}

function getUniqueTableFields($db_handler, $tableName, $fields, $condition) {   
	//$columns = FetchColumns($db_handler, $tableName);
	//$columns = implode(',' , $fields);
    $result = mysqli_query($db_handler, "SELECT DISTINCT({$fields}) FROM `{$tableName}`  WHERE {$condition}");
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
			{
                //foreach($fields as $field)
			    	$array[$i][$fields] = $row[$fields]; 
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
         
    return $array;
}

function getTableFields2($db_handler, $tableName, $columns, $condition = 1, $Limit='') {   
	// здесь  '$columns' - входной параметр - строка где поля разделены через запятую, например:  'Id,Subject,EventTypeId'
	// fields - поля для формирования выходного массива
	if ($columns == '' OR $columns == '*') 
	{ 
		$columns = '*';
		$fields = FetchColumns($db_handler, $tableName);
	}
	else { $fields = explode(',' , $columns); }
	//$query = "SELECT {$columns} FROM `{$tableName}` WHERE {$condition}";
	
	if($condition != ''){
		$query = "SELECT {$columns} FROM `{$tableName}` WHERE {$condition}";
	}else{
		$query = "SELECT {$columns} FROM `{$tableName}`";
	}
	if($Limit<>''){
		$query .= $Limit;
	}
	
	
	//echo 'query: '.$query ,'<br>'; 
    $result = mysqli_query($db_handler, $query );
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;			
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
			{
                foreach($fields as $field)
			    	$array[$i][$field] = $row[$field]; 
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
         
    return $array;
}

function getTableFields2Secure($db_handler, $tableName, $columns, $searchParam, $condition = 1) 
{  
	
	// здесь поля columns - входной параметр - строка где поля разделены через запятую, например:  'Id,Subject,EventTypeId'
	// fields - поля для формирования выходного массива
	if ($columns == '' OR $columns == '*') 
	{ 
		$columns = '*';
		$fields = FetchColumns($db_handler, $tableName);
	}
	else { $fields = explode(',' , $columns); }
	
// формируем приготовленный запрос исходя из полей таблицы
	$searchColumns = FetchColumnsForSearch($db_handler, $table_name);  
	print_r($searchColumns);
	$arr = array();
	$i=0;
	$line= '';
	foreach($searchColumns as $column)
	{
		$arr[] = " {$column} LIKE ? ";
		$i++;
		$line .= 's';
	}
	$cond = ($arr) ? implode(' OR ', $arr) : '1';
	
	$query = "SELECT {$columns} FROM `{$tableName}` WHERE {$cond} ";
	echo $query ,'<br>';
	
	$a_params = array();
	/* with call_user_func_array, array params must be passed by reference */
	$a_params[] = & $line;
	 
	for($j = 0; $j< $i /*count($searchColumns)*/ ; $j++) {
	  /* with call_user_func_array, array params must be passed by reference */
	  $a_params[] = & $searchParam;
	}	
	
	//$param = "%{$searchParam}%";
	$stmt = $db_handler->prepare( $query );
	/* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
	call_user_func_array(array($stmt, 'bind_param'), $a_params);
	
	//$stmt->bind_param( 's', $param);
	$stmt->execute();
	$result = $stmt->get_result();
 
    //$result = mysqli_query($db_handler, $query );
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;			
            while ($row = $result->fetch_array( MYSQLI_BOTH )) 
			{
                foreach($fields as $field)
			    	$array[$i][$field] = $row[$field]; 
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
         
    return $array;
}
function getJoinedTable($db_handler, $tableName1, $field1, $tableName2, $field2, $condition = 1) {   
	$columns = FetchColumns($db_handler, $tableName1);
    $result = mysqli_query($db_handler, 
		"SELECT t1.* , t2.email, t2.username FROM `{$tableName1}` AS t1
		INNER JOIN  `{$tableName2}`  AS t2
		ON  t1.{$field1} = t2.{$field2}
		WHERE {$condition}");
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
			{
               	 foreach($columns as $column)
			    	$array[$i][$column] = $row[$column]; 
					
				$array[$i]['email'] = $row['email']; 
				$array[$i]['username'] = $row['username']; 
               	/*$array[$i]['time'] = $row['time']; 
               	$array[$i]['time'] = $row['time']; 
               	$array[$i]['time'] = $row['time']; */
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
         
    return $array;
}
function getJoinedTablesGeneral($db_handler, $tableName1, $field1, $tableName2, $field2, $condition = 1) {   
	$columns1 = FetchColumns($db_handler, $tableName1);
	$columns2 = FetchColumns($db_handler, $tableName2);
	echo $columns = array_merge($columns2, $columns1);
	echo '<br />$columns = '; print_r($columns);
    $result = mysqli_query($db_handler, 
		"SELECT t1.* , t2.* FROM `{$tableName1}` AS t1
		INNER JOIN  `{$tableName2}`  AS t2
		ON  t1.{$field1} = t2.{$field2}
		WHERE {$condition}");
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
			{
               	foreach($columns as $column) 
					$array[$i][$column] = $row[$column]; 	
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
         
    return $array;
}
function getJoinedTablesSpecial($db_handler, $tableName1, $field1, $tableName2, $field2,$field2_2, $tableName3, $field3, $condition = 1) 
{   
	/*
	$columns1 = FetchColumns($db_handler, $tableName1);
	$columns2 = FetchColumns($db_handler, $tableName2);
	$columns = array_merge($columns2, $columns1);
	*/
	//echo '<br />$columns = '; print_r($columns); 
    $result = mysqli_query($db_handler, 
		"SELECT t1.Id , t1.dateTimeForPayment , t2.UserId, t3.email, t3.username, t3.parentId   FROM `{$tableName1}` AS t1
		INNER JOIN  `{$tableName2}`  AS t2
		ON  t1.{$field1} = t2.{$field2}
		INNER JOIN  `{$tableName3}`  AS t3
		ON  t2.{$field2_2} = t3.{$field3}
		
		 -- INNER JOIN  `{$tableName3}`  AS t3
		 -- ON  t2.{$field2_2} = t3.{$field3}
		WHERE {$condition} ");     //, t2.* 
	$array = array();    
	if ($result !== FALSE) 
		{
			$i=0;
            while ($row = mysqli_fetch_array($result, MYSQLI_BOTH )) 
			{
               	//foreach($columns as $column) $array[$i][$column] = $row[$column]; 
				$array[$i]['Id'] = $row['Id']; 
				$array[$i]['UserId'] = $row['UserId'];
				$array[$i]['email'] = $row['email'];
				$array[$i]['username'] = $row['username'];
				$array[$i]['parentId'] = $row['parentId'];
				$array[$i]['dateTimeForPayment'] = $row['dateTimeForPayment'];
				$i++; 
			}
            mysqli_free_result($result);
        } else {  throw new Exception("Failure to get all records from db {$tableName}: " . mysqli_error($db_handler) );  } 
	
	
	// array is done	
		
   /* $result = mysqli_query($db_handler, 
		"SELECT t1.email, t1.username   FROM `{$tableName3}` AS t1
		INNER JOIN  `{$tableName3}`  AS t2
		ON  t1.id = t2.parentId
		WHERE {$condition}");       */
    return $array;
}
function FetchColumns($db_handler, $tableName)
{
	$result = mysqli_query($db_handler, "SHOW COLUMNS FROM `{$tableName}` ");
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	if (mysqli_num_rows($result) > 0) {
		$columns= array();
		while ($row = mysqli_fetch_assoc($result)) {
			//print_r($row);
			$columns[] = $row['Field'];
		}
	}
	return $columns;
} 
// здесь мы исключаем поля (сolumns) c типом 'datetime'
function FetchColumnsForSearch($db_handler, $tableName)
{
	$result = mysqli_query($db_handler, "SHOW COLUMNS FROM `{$tableName}`WHERE 1");
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	if (mysqli_num_rows($result) > 0) {
		$columns= array();
		while ($row = mysqli_fetch_assoc($result)) {
			// проверка: берём только те поля что НЕ типа 'datatime'
			if(stristr($row['Type'], 'datetime') === FALSE)
				$columns[] = $row['Field'];
		}
	}
	return $columns;
}
function InsertRecord($db_handler, $tableName, $values)  
{
	 foreach($values as $key => $value) // ключи - имена полей в базе 
	// а значения - значения для соответствующих полей в этой записи.
	{
		$fields_sql .= ', '. $key;
		$values_sql .= ", '" . $value . "' "; 
	}
	$fields_sql = '(' . ltrim($fields_sql , ',') . ')';
	$values_sql =  '(' . ltrim($values_sql , ',') . ')';
	
	$query = "INSERT INTO `{$tableName}` {$fields_sql} VALUES {$values_sql} "; 
	// echo '<br>query = ', $query;
	$result = mysqli_query($db_handler, $query);	
	//echo ' <br/>result = ', $result;
	if (!$result) {
		//echo 'Could not run query: ' . $query ;
		return false;
	} else 
	{
		return mysqli_insert_id($db_handler); /* возвращаем идентификатор последней вставленной записи */
	} 
}

function InsertFilter($db_handler, $tableName, $values ) // we set the false condition to prevent occasional update of all the records (when WHERE <condition> is missing)
{
	$query = "INSERT INTO `{$tableName}` (name, content) VALUES ('{$values[0]}', '{$values[1]}') ";  // WHERE {$condition}
	$result = mysqli_query($db_handler, $query);	
	if (!$result) {
		echo 'Could not run query: ' . mysql_error() . ' \nquery = ' . $query ;
		exit;
	} else 
		printf("Affected rows (INSERTed): ", mysqli_affected_rows($db_handler), '<br />');
}

function UpdateRecord($db_handler, $tableName, $field, $value, $condition = '1 = 0' )// we set the false condition to prevent occasional update of all the records (when WHERE <condition> is missing)
{
	$query = "UPDATE `{$tableName}` SET `{$field}` = '{$value}' WHERE {$condition}";
	$result = mysqli_query($db_handler, $query);	
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	} else 
		printf("Affected rows (UPDATE): ", mysqli_affected_rows($db_handler), '</br>');
}

function update_by_array($db_handler, $tableName, $inputArray, $condition = '1 = 0' )// we set the false condition to prevent occasional update of all the records (when WHERE <condition> is missing)
{	
	//$sttm = 'UPDATE `{$tableName}` SET ';
	$elem = array();
	foreach($inputArray as $key => $value)
	{
		$elem[] = ' `' . $key. '` = "' . $value . '" ';	
	}
	$query = "UPDATE `{$tableName}` SET " . implode(',' , $elem) . ' WHERE ' . $condition; 
	//echo $query;
	$res = mysqli_query($db_handler, $query);	
	if ($res) return 1; //return mysqli_insert_id($db_handler); 
	//echo $res;
	/*
	$stmt = mysqli_prepare($db_handler, "UPDATE `{$tableName}` SET `StatusId`= ? , `dateTimeForDelivery`= ?  WHERE  {$condition} ");
	mysqli_stmt_bind_param($stmt, 'ss', $StatusId, $dateTimeForDelivery);

    // execute prepared statement 
    if ( !mysqli_stmt_execute($stmt) ) 
        {   mysqli_stmt_close($stmt);
            throw new Exception ("Error inserting 'StatusId' and 'dateTimeForDelivery' into DB, table '{$tableName}' by condition = {$condition}: " . mysqli_error($db_handler)  ) ;
			//send_mail('Error update record '. mysqli_error($db_handler));
        }
    else { 
            mysqli_stmt_close($stmt); //close the stmt
            return True;
        } */
}
function update_StatusId_dateTimeForDelivery_prepared($db_handler, $tableName, $StatusId, $dateTimeForDelivery, $condition = '1 = 0' )
{	
	$stmt = mysqli_prepare($db_handler, "UPDATE `{$tableName}` SET `StatusId`= ? , `dateTimeForDelivery`= ?  WHERE  {$condition} ");
	mysqli_stmt_bind_param($stmt, 'ss', $StatusId, $dateTimeForDelivery);

    // execute prepared statement 
    if ( !mysqli_stmt_execute($stmt) ) 
        {   mysqli_stmt_close($stmt);
            throw new Exception ("Error inserting 'StatusId' and 'dateTimeForDelivery' into DB, table '{$tableName}' by condition = {$condition}: " . mysqli_error($db_handler)  ) ;
			//send_mail('Error update record '. mysqli_error($db_handler));
        }
    else { 
            mysqli_stmt_close($stmt); //close the stmt
            return True;
        }
}


function sendNotification ($name, $email, $eventData, $link) // посылаем письмо с уведомлением
{
	$to = $email;
	$from =  'igor.savinkin@gmail.com';//Yii::app()->params['adminEmail'];
	$subject = 'Уведомление '/* . date('Y:m:d H:i:s') . " пользователю*/.  "{$name} о событии № {$eventData}."; 			
	//begin of HTML message 
	$message = <<<EOF
		<html> 
			  <body style='bgcolor:#DCEEFC'> 

					<h3>Уважаемый <b>{$name}</b>,<br>
					этим автоматически посланным письмом мы оповещаем Вас о событиии <a href='{$link}'>{$eventData}</a>.<br>
					Перейдите по указанной ссылке чтобы посмотреть данное событие.
					
				   <br><br>Искренне Ваша компания "TAREX" <br />
					Наш адрес: <b><a href='http://goo.gl/maps/1Chft'>г. Москва, ул. Складочная д. 1, стр., 10</a><br />
					Тел: +7 (495) 785-88-50 (многоканальный). <br />
					Для региональных клиентов: +7 (495) 785-88-50 ICQ 612-135-517</b><br />

					<font color="blue">
					E-mail: <a href="mailto:region@tarex.ru">region@tarex.ru</a><br />
					E-mail: <a href="mailto:info@tarex.ru">info@tarex.ru</a>
					</font>  			  		  
			  </body> 
			</html> 
EOF;
	//end of message 
	$headers  = "From: {$from}\r\n"; 
	$headers .= "Content-type: text/html; charset=utf-8\r\n"; 
	return mail($to, $subject, $message, $headers); 	
}

/*************************************** end of functions **************************************/
?>