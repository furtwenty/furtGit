<?php 

session_start();

$newUser = new user($_POST['unam'],$_POST['upas'],$_POST['cnfp'],$_POST['ueml'],$_POST['utel'],$_POST['ulib'],$_POST['frnm'],$_POST['lsnm']);

$result = $newUser->validate();

echo json_encode($result);


class user{
	
	private $usrName;
	private	$usrPass; 
	private	$usrCnfp; 
	private	$usrEmal; 
	private	$usrTele; 
	private	$usrLibr;
	private	$usrFrnm; 
	private	$usrLsnm; 
	
	function __construct($usrName,$usrPass,$usrCnfp,$usrEmal,$usrTele,$usrLibr,$usrFrnm,$usrLsnm){
		
		$this->usrName = $usrName;
		$this->usrPass = $usrPass;
		$this->usrCnfp = $usrCnfp;
		$this->usrEmal = $usrEmal;
		$this->usrTele = $usrTele;
		$this->usrLibr = $usrLibr;
		$this->usrFrnm = $usrFrnm;
		$this->usrLsnm = $usrLsnm;
		
	}
	
	public function validate(){
	
		//array to build result object
		$chk = array();
	
		//flags for valid input
		$f1 = $f2 = $f3 = $f4 = $f5 = $f6 = $f7 = 0;
	
		//checks for missing or invalid usr name
		if($this->usrName==""){
	
			$chk['result']['erruname'] = 'missing';
	
		}elseif (preg_match('/[^a-z0-9]/i',$this->usrName)){
	
			$chk['result']['erruname'] = 'invalid';
	
		}else{
	
			$chk['result']['erruname'] = 'valid';
			$f1 = 1;
	
		}
	
		//checks for missing or invalid usr pass
		if($this->usrPass==""){
	
			$chk['result']['errupass'] = 'missing';
	
		}else{
	
			$chk['result']['errupass'] = 'valid';
			$f2 = 1;
	
		}
	
		//checks for missing or invailid confirmation pass
		if($this->usrCnfp==""){
	
			$chk['result']['errcpass'] = 'missing';
	
		}else if($this->usrCnfp!=$this->usrPass){
	
			$chk['result']['errcpass'] = 'nomatch';
	
		}else{
	
			$chk['result']['errcpass'] = 'valid';
			$f3 = 1;
	
		}
	
		//used for invalid email
		$einvalid = 0;
		//checks tele format
		if(filter_var($this->usrEmal, FILTER_VALIDATE_EMAIL)!== FALSE){
	
			if(!preg_match('/^[a-z0-9A-Z]*@[a-z0-9A-z]+\.[a-zA-Z]+$/',$this->usrEmal)){
				$einvalid=1;
			}
	
		}
	
	
		//checks for missing or invalid email address
		if($this->usrEmal==""){
	
			$chk['result']['erremail'] = 'missing';
	
		}elseif($einvalid==1){
	
			$chk['result']['erremail'] = 'invalid';
	
		}else{
	
			$chk['result']['erremail'] = 'valid';
			$f4 = 1;
	
		}
	
		//used for invalid phone number
		$tinvalid = 0;
		//checks tele format
		if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',$this->usrTele)){
	
			if(!preg_match('/[0-9]{10}/',$this->usrTele)){
				$tinvalid=1;
			}
	
		}
	
		//checks for missing or invalid telephone
		if($this->usrTele==""){
	
			$chk['result']['errtele'] = 'missing';
			$f5 =1;
	
		}elseif ($tinvalid==1){
	
			$chk['result']['errtele'] = 'invalid';
	
		}else{
	
			$chk['result']['errtele'] = 'valid';
			$f5 = 1;
	
		}
	
	
		//checks for missing or invalid first name
		if($this->usrFrnm==""){
	
			$chk['result']['errfname'] = 'missing';
	
		}elseif (preg_match('/[^a-z0-9]/i',$this->usrFrnm)){
	
			$chk['result']['errfname'] = 'invalid';
	
		}else{
	
			$chk['result']['errfname'] = 'valid';
			$f6 = 1;
	
		}
	
		//checks for missing or invalid second name
		if($this->usrLsnm==""){
	
			$chk['result']['errlname'] = 'missing';
	
		}elseif (preg_match('/[^a-z0-9]/i',$this->usrLsnm)){
	
			$chk['result']['errlname'] = 'invalid';
	
		}else{
	
			$chk['result']['errlname'] = 'valid';
			$f7 = 1;
	
		}
	
	
		if(($f1==1)&&($f2==1)&&($f3==1)&&($f4==1)&&($f5==1)&&($f6==1)&&($f7==1)){
			 
			$this->UpdtDB();
			 
			return $chk;
			 
		}else{
	
			return $chk;
	
		}
	
	}
	
	private function UpdtDB(){
	
	
		$bPass = $this->usrPass;
		$usrPass = md5($bPass);
	
	
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
	
		$sql = "INSERT INTO users (
		usrname, password, email, phone, libr, fname, lname
		) VALUES (
		'$this->usrName','$usrPass','$this->usrEmal','$this->usrTele','$this->usrLibr','$this->usrFrnm','$this->usrLsnm')";
	
		if ($sqlCon->query($sql) === TRUE) {
			//echo "New record created successfully<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $sqlCon->error;
		}
	
		$sqlCon->close();
	
	}
	
}

?>