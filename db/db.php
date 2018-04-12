<?php
define('HOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'coffee_shop');

function db_connection_open() {
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME);
    if(mysqli_connect_error()) {
        die("Connection to database failed");
    }
    return $conn;
}

function db_connection_close($conn) {
    if($conn) {
        mysqli_close($conn);
    }
}

function db_update($sql){
    $conn = db_connection_open();
    $status = false;
	if(mysqli_query($conn, $sql)) {
		$status = true;
	}
    db_connection_close($conn);
    return $status;
}

function db_get_result($sql){
    $conn = db_connection_open();
    $result = mysqli_query($conn, $sql)or die("Query failed: " . $sql . "<br>");
    db_connection_close($conn);
	return $result;
}

function db_get_result_json($sql){
    $arr = db_get_result_array($sql);
	return json_encode($arr);
}

function db_get_result_array($sql){
    $result = db_get_result($sql);
	$arr=array();
	while($row = mysqli_fetch_assoc($result)) {
		$arr[]=$row;
	}
	return $arr;
}



?>