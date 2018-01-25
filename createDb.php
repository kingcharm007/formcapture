<?php    
    $servername = "localhost";
    $username = "root";
    $password = "root";    
    $conn = new mysqli($servername, $username, $password);
    // Check connection
    if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
    }
    
    $dbName = "formtodb";
    $sql = "SELECT COUNT(*) AS `exists` FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMATA.SCHEMA_NAME = '" . $dbName . "'";
    
    
    if(isset($_POST['formArray']) && !empty($_POST['formArray'])) {
	$createTble='CREATE TABLE test (';	
	$formArray = $_POST['formArray'];
	$formArray = explode(",", $formArray);
	$total = count($formArray);	
	$i = 0;
	
	if ($result = mysqli_query($conn, $sql)) {	    
	    $row = mysqli_fetch_assoc($result);
	    
	    if ($row["exists"] > 0) {			
		foreach ($formArray as $value) {
		    $i++;
		    if ($i!= $total) {
			$createTble .= $value." VARCHAR(20), ";
		    } else {
			$createTble .= $value." VARCHAR(20)";
		    }
		}
		$createTble.=')';

		$conn->select_db($dbName);
		if (mysqli_query($conn, $createTble)) {
		    var_dump('Tables created successfully');
		}
	    } else {
		$sql = "CREATE DATABASE " . $dbName;
		if (mysqli_query($conn, $sql)) {
		    foreach ($formArray as $value) {
			$i++;
			if ($i!= $total) {
			    $createTble .= $value." VARCHAR(20), ";
			} else {
			    $createTble .= $value." VARCHAR(20)";
			}
		    }
		    $createTble.=')';
		    
		    
		    $conn->select_db($dbName);
		    if (mysqli_query($conn, $createTble)) {
			var_dump('Tables created successfully');
		    }
		}
	    }
	}
    }
?>
