<?php

session_start();

$usrName = $_POST['a'];
$usrPass = $_POST['b'];

//echo var_dump($_POST);

//simple assigment for result of testing user creds
$result = test($usrName,$usrPass);

//echos response for html callback
echo json_encode($result);

// Check User Entered Pass
function test($usrName,$usrPass) {

	$chk = array();
	
	//sets my sql
	$username = "user";
	$password = "password";
	$dbServer = "localhost";
	$dbName   = "comslib";
	
	//creates a connection with mysql server
	$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
	
	// error check for connection
	if ($sqlCon->connect_error) {
		die("Connection failed: " . $sqlCon->connect_error);
		//echo "failed";
	} else {
		//echo("Connected successfully<br>");
	}
	
	$sql = "SELECT usrname, password FROM users";
	
	$result = $sqlCon->query($sql);

	$flag1 = $flag2 = false;
	
	if($usrName==""){
		$flag1 = true;
		$chk['result']['errname'] = 'invalid';
	
	}
	if($usrPass==""){
		$flag2 = true;
		$chk['result']['errpass'] = 'invalid';
	
	}
	
	if($flag1 == true || $flag2 == true){
		
		return $chk;
		
	}else{
	
		$pf = false;
		$nf = false;
			
		
		if ($result->num_rows > 0) {
		// output data of each row
			while($row = $result->fetch_assoc()) {
			
				if($row["usrname"] ==$usrName){
						
					$chk['result']['user'] = 'valid';
							
					
					if(md5($usrPass)==$row["password"]){
				
						$chk['result']['pass'] = 'valid';
						$_SESSION['uNme'] = $usrName;
						
						
						$sql = "SELECT libr from users WHERE usrname='$usrName'";
						
						$result = $sqlCon->query($sql);
					
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								if($row["libr"] === "on"){
									$chk['result']['libr']='true';
									return $chk;
								}else{
									$chk['result']['libr']='false';
									return $chk;
								}
							}
						}
						
					}else{
				
						$chk['result']['pass'] = 'invalid';
						return $chk;
					}
						
				}else{
				
					$chk['result']['user'] = 'invalid';
						
				}
			}
		return $chk;
		}
	}	
}



?>