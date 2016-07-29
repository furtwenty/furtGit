<?php 

class loan{
	
	private $username;
	private $copyid;
	private $due_date;
	private $rent_date;
	
	function __construct($username,$copyid,$due_date,$rent_date){
		
		$this->username = $username;
		$this->copyid = $copyid;
		$this->due_date = $due_date;
		$this->rent_date = $rent_date;
		
	}
	
	private function isAvailible(){
		
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
		
		$sql = "SELECT copy_id FROM bookcopy WHERE copy_id = '$this->copyid'";
		
		$result = $sqlCon->query($sql);
		
		if ($result->num_rows > 0) {
			//checks to see if provided copy id is valid
			
			$chk['result']['contains'] = "valid";

			$sql = "SELECT ret_date FROM loanhistory WHERE copy_id = '$this->copyid'";
			
			$result = $sqlCon->query($sql);
			
			$dflag = 0;
			//if result has somthing in it
			if ($result->num_rows > 0) {
				//checks rows of checkout history to see if book is availible
				while($row = $result->fetch_assoc()) {
			
					//
					if($row['ret_date']=='OUT'){
						$chk['result']['check'] = "invalid";
						break;
					}else{
						$chk['result']['check'] = "valid";
					}
				}
			}else{
					
				$chk['result']['check'] = "valid";
			}
			
		}else{
				
			$chk['result']['contains'] = "invalid";
			$chk['result']['check'] = "invalid";
		}
		
		$sqlCon->close();
		
		return $chk;
	}
	
	private function addToDB(){
		
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
			//$chk['result']['conn'] = "valid";
		}
		
		
		$dueDate = $this->getDueDate();
		$val = 'OUT';
		
		$sql = "INSERT INTO loanhistory (usrname, copy_id, due_date, ret_date) VALUES (
		'$this->username','$this->copyid','$dueDate','OUT')";
		
		$sqlCon->query($sql);
		
		$sqlCon->close();
		
	}
	
	private function getDueDate(){
		

		$month = date('m');
		$day = date('d');
		$year = date('Y');
		
		$day = $day;
		
		$date = $month."/".$day."/".$year;
		
		return $date;
	}
	
	private function getRetDate(){
	
	
		$month = date('m');
		$day = date('d');
		$year = date('Y');
	
		$day = $day;
	
		$date = $month."/".$day."/".$year;
	
		return $date;
	}
	
	public function checkOut(){
	
		$res = $this->isAvailible();
		
		if($res['result']['check'] == "valid"){
			$this->addToDB();
			return $res;
		
		}else{
			return $res;
		}
	}
	
	
	public function returnBook(){
	
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
		

		$sql = "SELECT copy_id FROM bookcopy WHERE copy_id = '$this->copyid'";
		
		$result = $sqlCon->query($sql);
		//checks to see if provided copy id is valid and existing in db
		if ($result->num_rows > 0) {
			//sets flag for containing copyid
			$chk['result']['contains'] = "valid";
			//sql query to fetch all returned dates for current id
			$sql = "SELECT ret_date FROM loanhistory WHERE copy_id = '$this->copyid'";
				
			$result = $sqlCon->query($sql);
			
			//if result has somthing in it
			if ($result->num_rows > 0) {
				
				//checks rows of checkout history to see if book is availible for return
				while($row = $result->fetch_assoc()) {
						
						//if the book is out for return it is accepted as vaild return
						if($row['ret_date']=='OUT'){
							//setes checked out flag to valid
							$chk['result']['check'] = "valid";
							//gets current date formatted in db freindly txt
							$Date = $this->getRetDate();
							//updates the current checked out copy returned column to current date
							$sql = "UPDATE loanhistory SET ret_date = '$Date' WHERE copy_id='$this->copyid'";
							
							if($sqlCon->query($sql)==true){
								$chk['result']['retquery'] = 'returned';
							}else{
								$chk['result']['retquery'] = 'unreturned';
							}
							break;
						}else{
							$chk['result']['check'] = "invalid";
						}
				}
			}else{
					
				$chk['result']['check'] = "valid";
			}
			
		}else{
			$chk['result']['contains'] = "invalid";
		}
		
		$sqlCon->close();
		
		return $chk;
		
	}
	
	public function getName() {
		return $this->username;
	}
	public function getCopyId() {
		return $this->copyid;
	}
	public function getDDueDate() {
		return $this->due_date;
	}
	public function getRentDate() {
		return $this->rent_date;
	}
	
	
	
}




function buildList(){
	
	echo '<table id="tbl1" cellpadding="3" >';

	echo '<tr>';
	echo '<td>' . htmlspecialchars("#") . '</td>';
	echo '<td>' . htmlspecialchars("User") . '</td>';
	echo '<td>' . htmlspecialchars("Copy ID") . '</td>';
	echo '<td>' . htmlspecialchars("Due Date") . '</td>';
	echo '<td>' . htmlspecialchars("Return Date") . '</td>';
	echo '<tr>';
	$i = 0;
	foreach ($GLOBALS['loans'] as $key){
		
		echo '<td>' . htmlspecialchars($i) . '</td>';

		echo '<td>' . htmlspecialchars($key->getName()) . '</td>';
		echo '<td>' . htmlspecialchars($key->getCopyId()) . '</td>';
		echo '<td>' . htmlspecialchars($key->getDDueDate()) . '</td>';
		echo '<td>' . htmlspecialchars($key->getRentDate()) . '</td>';
		
		echo '<tr>';
		
		$i++;
	}

	echo '</table>';
	

}

function sendError(){
	
	
	echo '<label>** Invalid User Name</label>';
	
}

function fetchHistory($lname){

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
	
	$sql = "SELECT usrname,copy_id,due_date,ret_date FROM loanhistory";
	
	$result = $sqlCon->query($sql);
	
	$dflag = 0;
	//if result has somthing in it
	if ($result->num_rows > 0) {
		//checks rows for existing book entry
		while($row = $result->fetch_assoc()) {
			
			if($row["usrname"] === $lname){
				$dflag=1;
				//creates a new loan object
				$lo = new loan($row['usrname'],$row['copy_id'],$row['due_date'],$row['ret_date']);
				
				$GLOBALS['loans'][]=$lo;
				
				$chk['result']['contains'] = "valid";
				
			}else{
				$chk['result']['contains'] = "invalid";
			}
		}
	}else{
		$chk['result']['contains'] = "invalid";
	}
	
	return $chk;
	
}

function valid($chk){
		
	if($chk['result']['contains']=="valid"){
		
		buildList();
		
	}else{
	
		sendError();
		
	}
	
}

?>