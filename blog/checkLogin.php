<?php
session_start();
session_unset();


$usrName = $_POST['a'];
$usrPass = $_POST['b'];


$result = test($usrName,$usrPass);

echo json_encode($result);

// Check User Entered Pass
function test($usrName,$usrPass) {

	$chk = array();
	
	$fileParse = file_get_contents("./users.txt");
	
	$j = json_decode($fileParse,true);
	
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
	
		foreach ($j['usrInfo'] as $object){
			
			$pf = false;
			$nf = false;
			
			if($object['usrName']==$usrName){
					
					$chk['result']['user'] = 'valid';
					
					
				if($object['usrPass']==$usrPass){
				
					$chk['result']['pass'] = 'valid';
					return $chk;
				
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



?>
