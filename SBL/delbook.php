<?php 

function delBook($copy_id){
	
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
		$chk['result']['conn'] = "valid";
	}
	
	$sql = "SELECT book_id FROM bookcopy WHERE copy_id='$copy_id'";
	
	$result = $sqlCon->query($sql);
	
	$dflag = 0;
	$copy_count = 0;
	$booktoDelete = null;
	//if result has somthing in it
	if($result->num_rows > 0) {
		//checks rows for existing book entry
		while($row = $result->fetch_assoc()) {	
			
				//set name of book for later lookup
				$booktoDelete = $row["book_id"];
				//incs the number of copies found
				$copy_count++;
				//sets deletion flag
				$dflag=1;
				//sets validation modifier flag to valid
				$chk['result']['contains'] = "valid";
				//sql query use for deleting copy from database
				$sql = "DELETE FROM bookcopy WHERE copy_id='$copy_id'";
				
				
				if ($sqlCon->query($sql) === TRUE) {
					//sets validtion modifier for valid deletion
					$chk['result']['cdel'] = "valid";
				} else {
					//sets validation modifier for invalid deletion
					$chk['result']['cdel'] = "invalid";
				}
		
				$sql = "DELETE FROM shelves WHERE copy_id='$copy_id'";
				
				if ($sqlCon->query($sql) === TRUE) {
					//sets validtion modifier for valid deletion
					$chk['result']['csdel'] = "valid";
				} else {
					//sets validation modifier for invalid deletion
					$chk['result']['csdel'] = "invalid";
				}
				
		}
		
		$chk['result']['delid'] = $booktoDelete;
		$chk['result']['cpycnt'] = $copy_count;
		
		$sql = "SELECT book_id FROM bookcopy WHERE book_id='$booktoDelete'";
		
		$result = $sqlCon->query($sql);
		//if last copy of book_id deleted then book_id is removed from database
		if($result->num_rows < 1){
		
			//sql statement for selecting all books
			$sql = "DELETE FROM books WHERE book_id='$booktoDelete'";
			if ($sqlCon->query($sql) === TRUE) {
				//sets validtion modifier for valid deletion
				$chk['result']['bdel'] = "valid";
			} else {
				//sets validation modifier for invalid deletion
				$chk['result']['bdel'] = "invalid";
			}
		}
		
		
	}else{
		$chk['result']['contains'] = "invalid";
	}

	
	return $chk;
}

?>