<?php 

	class Settings{
	
		private $usrName;
	
		function __construct($usr){
				
			$this->usrName = $usr;
				
		}

		public function updatePassword($pass){
			
			$usrPass = md5($pass);
			

			//sets my sql
	$username = "furtwenty_admin";
	$password = "password";
	$dbServer = "localhost";
	$dbName   = "furtwenty_tester2";
			
			//creates a connection with mysql server
			$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
			
			// error check for connection
			if ($sqlCon->connect_error) {
				die("Connection failed: " . $sqlCon->connect_error);
				//echo "failed";
			} else {
				//echo("Connected successfully<br>");
			}
			
			$sql = "UPDATE users SET password='$usrPass' WHERE usrname='$this->usrName'";
						
			if ($sqlCon->query($sql) === TRUE) {
				$res['result']['dbquery1']="New record created successfully";
			} else {
				$res['result']['dbquery1']="Error: " . $sql . " " . $sqlCon->error;
			}
			
			$sqlCon->close();
			
			
			
		}
		
		public function validate($email,$phone,$fname,$lname){
		
			//array to build result object
			$chk = array();
		
			//flags for valid input
			$f1 = $f2 = $f3 = $f4= 0;


				//used for invalid email
				$einvalid = 0;
				//checks tele format
				if(filter_var($email, FILTER_VALIDATE_EMAIL)!== FALSE){
			
					if(!preg_match('/^[a-z0-9A-Z]*@[a-z0-9A-z]+\.[a-zA-Z]+$/',$email)){
						$einvalid=1;
					}
			
				}
			
			
				//checks for invalid email address
				if($einvalid==1){
			
					$chk['result']['erremail'] = 'invalid';
			
				}else{
			
					$chk['result']['erremail'] = 'valid';
					$f1 = 1;
			
				}
	
			
				//used for invalid phone number
	
				$tinvalid = 0;
				//checks tele format
				if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',$phone)){
						
					if(!preg_match('/[0-9]{10}/',$phone)){
						$tinvalid=1;
					}
						
				}
					
				//checks for invalid telephone
				if ($tinvalid==1 && $phone!=""){
						
					$chk['result']['errtele'] = 'invalid';
						
				}else{
						
					$chk['result']['errtele'] = 'valid';
					$f2 = 1;
						
				}
		
			//checks for invalid first name
			if (preg_match('/[^a-z0-9]/i',$fname)){
		
				$chk['result']['errfname'] = 'invalid';
		
			}else{
		
				$chk['result']['errfname'] = 'valid';
				$f3 = 1;
		
			}
		
			//checks for invalid second name
			if (preg_match('/[^a-z0-9]/i',$lname)){
		
				$chk['result']['errlname'] = 'invalid';
		
			}else{
		
				$chk['result']['errlname'] = 'valid';
				$f4 = 1;
		
			}
		
			if(($f1==1)&&($f2==1)&&($f3==1)&&($f4==1)){
		
				$this->updateSettings($email,$phone,$fname,$lname);
		
				return $chk;
		
			}else{
		
				return $chk;
		
			}
		
		}
		
		public function fetchUsrDetails(){
			
			$list = array();
			
			//sets my sql
	$username = "furtwenty_admin";
	$password = "password";
	$dbServer = "localhost";
	$dbName   = "furtwenty_tester2";
			
			//creates a connection with mysql server
			$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
			
			// error check for connection
			if ($sqlCon->connect_error) {
				die("Connection failed: " . $sqlCon->connect_error);
				//echo "failed";
			} else {
				//echo("Connected successfully<br>");
			}
			
			$sql="SELECT email,phone,fname,lname FROM users WHERE usrname='$this->usrName'ORDER BY email";
			
			if ($result = $sqlCon->query($sql)) {
					
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					$list[]= $row[0];
					$list[]= $row[1];
					$list[]= $row[2];
					$list[]= $row[3];
					
				}
					
				/* free result set */
				$result->close();
			}
			
			/* close connection */
			$sqlCon->close();
			
			return $list;
			
			
		}
		
		public function updateSettings($email,$phone,$fname,$lname){
		
			$res = array();
				
			//sets my sql
	$username = "furtwenty_admin";
	$password = "password";
	$dbServer = "localhost";
	$dbName   = "furtwenty_tester2";
		
			//creates a connection with mysql server
			$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
		
			// error check for connection
			if ($sqlCon->connect_error) {
				die("Connection failed: " . $sqlCon->connect_error);
				//echo "failed";
			} else {
				$result['result']['dbcon']="Connected successfully";
			}
		
				
			//querys database to check for valid user specified post id
				
			$sql = "SELECT usrname FROM users WHERE usrname='$this->usrName'";
		
			$result = $sqlCon->query($sql);
				
				
			//if result has somthing in it
			if ($result->num_rows > 0) {
		
				//if the title feild provided by user is emtpy no update is peformed to title
				if($email!="email@example.com" && $email!=""){
						
					$sql = "UPDATE users SET email='$email' WHERE usrname='$this->usrName'";
						
					if ($sqlCon->query($sql) === TRUE) {
						$res['result']['dbquery1']="New record created successfully";
					} else {
						$res['result']['dbquery1']="Error: " . $sql . " " . $sqlCon->error;
					}
						
				}
		
				//if the message feild provided by user is emty no update is performed to meassage
				if($phone!="xxx-xxx-xxxx" && $phone!=""){
		
					$sql = "UPDATE users SET phone ='$phone' WHERE usrname='$this->usrName'";
					
					if ($sqlCon->query($sql) === TRUE) {
						$res['result']['dbquery2']="New record created successfully";
					} else {
						$res['result']['dbquery2']="Error: " . $sql . " " . $sqlCon->error;
					}
				}
				
				//if the first name feild provided by user is emty no update is performed to meassage
				if($fname!=""){
				
					$sql = "UPDATE users SET fname ='$fname' WHERE usrname='$this->usrName'";
						
					if ($sqlCon->query($sql) === TRUE) {
						$res['result']['dbquery2']="New record created successfully";
					} else {
						$res['result']['dbquery2']="Error: " . $sql . " " . $sqlCon->error;
					}
				}
				
				//if the last name feild provided by user is emty no update is performed to meassage
				if($lname!=""){
				
					$sql = "UPDATE users SET lname ='$lname' WHERE usrname='$this->usrName'";
						
					if ($sqlCon->query($sql) === TRUE) {
						$res['result']['dbquery2']="New record created successfully";
					} else {
						$res['result']['dbquery2']="Error: " . $sql . " " . $sqlCon->error;
					}
				}
					
					
			}else{
				$res['result']['contains']="invalid";
			}
		
				
			$sqlCon->close();
		
			return $res;
				
		}
		
		public function getheader(){
				
			return "<label class='hdr1'>User Settings</label>";
				
		}
		
		public function getDys(){
			
			$usrDets = $this->fetchUsrDetails();
			
			echo "
			
			<div class='pload' id='pload'>
			
				<div class='regdet' id='regdet'>
					
					<label class='setlbl2'>User Details:</label><br>
					<br>
					<label for='remail'>Email:</label>
					<label id='detmail'>".$usrDets[0]."</label>
					<br></br>
					<label for='rtel'>Phone:</label>
					<label id='dettel'>".$usrDets[1]."</label>
					<br></br>
					<label for='rpass'>First Name:</label>
					<label id='detfname'>".$usrDets[2]."</label>
					<br></br>
					<label for='rpass'>Last Name:</label>
					<label id='detlname'>".$usrDets[3]."</label>
					<br></br>

				</div>	
						
				<div class='regpass' id='regpass'>
					
					<label class='setlbl1'>Reset Password:</label><br>
					<br>
					<label for='rppass'>New Password:</label>
					<input type='text' id='rppass' name='regpasswrd' placeholder='' style='border-radius: 5px; margin-left: 60px;'/>
					
					<br></br>
					<label for='rpcpass'>Confirm Password:</label>
					<input type='text' id='rpcpass' name='regconfpasswrd' placeholder='' style='border-radius: 5px; margin-left: 30px;'/>
			
					<br></br>
					<div class='psubb'>
						<label id='setsub1'>Reset Pass</label>
					</div>
					<br>
				</div>	
					
				<div id='pres3'>
			
				</div>			
					
				<div class='reginpt' id='reginpt'>
					
					<label class='setlbl2'>Edit User Details:</label><br>
					<br>
					<label for='semail'>Email:</label>
					<input type='text' id='semail'  placeholder='email@example.com' style='border-radius: 5px; margin-left: 132px;'/> 
					<br><label id='ersemail'></label></br>
					<label for='stell'>Phone:</label>
					<input type='text' id='stell'  placeholder='xxx-xxx-xxxx' style='border-radius: 5px; margin-left: 130px;'/> 
					<br><label id='erstel' style='font-size:14px;'></label></br>
					<label for='sfname'>First Name:</label>
					<input type='text' id='sfname'  placeholder='' style='border-radius: 5px; margin-left: 90px;'/>  
					<br><label id='ersfname'></label></br>
					<label for='slname'>Last Name:</label>
					<input type='text' id='slname' placeholder='' style='border-radius: 5px; margin-left: 92px;'/>  
					<br><label id='erslname'></label></br>
					<div class='psubb' >
						<label id='setsub2'>Update Settings</label>
					</div>
					<br>
				</div>
	
				
			</div>
			
			<script type='text/javascript'>
			
				var btn1 = $('#setsub1');
				var btn2 = $('#setsub2');
					

					
				btn1.click(
					function() {
			
						var upass = $('#rppass').val();
						var	cnfupass = $('#rpcpass').val();	
							
					    $.ajax({
					        type: 'POST',
	    		   			dataType: 'html',
	    		  			data: {flag:'for',sf1:'thr',pas:upass,cas:cnfupass},
					        url: 'controller.php',
					        success: function(data){
			
								var j = JSON.parse(data);
			
								// valid flags for submission feild
						 		var f1,f2 = 0;
							
						 		//checks for invalid or missing password
						 		if(j.result.errupass=='missing'){
						 			
						 			$('#pres3').html(' * Pass Word Required');
			
						 		}else{
						 			f1 = 1;
						 			$('#pres3').html('');
			
						 		}
						 		
						 		//checks for invalid or missing confirmation password
								if(j.result.errcpass=='missing'){
						 			
						 			$('#pres3').html(' * Comfirmation Required');
			
						 		}else if(j.result.errcpass=='nomatch'){
						 			
						 			$('#pres3').html(' *Passwords Do not Match');
						 			$('#rpcpass').html('');
						 			
						 		}else{
						 			f2 = 1;
						 			$('#erpcpass').html('');
			
						 		}
						 		
						 		
						 		//if all feild flags are valid completion is acknoledged.
						 		if((f1==1)&&(f2==1)){
						 
						 			$('#rppass').val('');
						 			$('#rpcpass').val('');	
							
						 			$('#pres3').html('Password Reset');
						 	
	
						 		}
							}
					    });
			
					}
				);
							

							
				btn2.click(
					function() {
			
					var email = $('#semail').val();
					var	phone = $('#stell').val();	
					var fname = $('#sfname').val();
					var	lname = $('#slname').val();	
							
							
					    $.ajax({
					        type: 'POST',
	    		   			dataType: 'html',
	    		  			data: {flag:'for',sf1:'for',eml:email,phn:phone,fnm:fname,lnm:lname},
					        url: 'controller.php',
					        success: function(data){
			
								var j = JSON.parse(data);
			
								// valid flags for submission feild
						 		var f1,f2,f3,f4 = 0;
							
							
								if(j.result.erremail=='invalid'){
						 		
						 			$('#ersemail').html(' * Invalid format :: Example@email.com ');
						 		
						 		}else{
						 			f1 = 1;
						 			$('#ersemail').html('');
			
						 		}
						 		
						 		if(j.result.errtele=='invalid'){
						 		
						 			$('#erstel').html(' * Invalid format :: XXX-XXX-XXXX or XXXXXXXXXX');
						 		
						 		}else{
						 			f2 = 1;
						 			$('#erstel').html('');
			
						 		}
						 	
								
						 		//checks for invalid first name
								if(j.result.errfname=='invalid'){
						 		
						 			$('#ersfname').html(' * Invalid format :: Alphanumeric only ');
						 		
						 		}else{
						 			f3 = 1;
						 			$('#ersfname').html('');
			
						 		}
						 		
						 		if(j.result.errlname=='invalid'){
						 		
						 			$('#erslname').html(' * Invalid format :: Alphanumeric only ');
						 		
						 		}else{
						 			f4 = 1;
						 			$('#erslname').html('');
			
						 		}
						 		
						 		//if all feild flags are valid completion is acknoledged.
						 		if((f1==1)&&(f2==1)&&(f3==1)&&(f4==1)){
						 			
									$('#pres3').html('Details Updated');		
							
						 			$('#semail').val('');
						 			$('#stell').val('');
						 			$('#sfname').val('');
						 			$('#slname').val('');	
						 			
						 			$('#ersemail').html('');
						 			$('#erstel').html('');
						 			$('#erfname').html('');
						 			$('#erlname').html('');
			
									 $.ajax({
					       				 
										type: 'POST',
	    		   						dataType: 'html',
	    		  			 			data: {flag:'for',sf1:'fiv'},
					                    url: 'controller.php',
					                    success: function(data){		
										
											var j = JSON.parse(data);
											
											$('#detmail').html(j[0]);
											$('#dettel').html(j[1]);
											$('#detfname').html(j[2]);	
											$('#detlname').html(j[3]);
										 }
									});	 	
							
							
						 			
						 		}
					        
							}
					    });
			
					}
				);
					
					
			</script>";
			
		}

	}
?>