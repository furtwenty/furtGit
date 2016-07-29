<?php 

session_start();

include 'postobj.php';

date_default_timezone_set('America/Mexico_City');

$flag = $_POST['flag'];


if($flag === 'one'){
	
	include 'viewer.php';

	$a = new viewer($_SESSION['uNme']);
	$viewer = serialize($a);
	// store $s somewhere where page2.php can find it.
	file_put_contents('ldrobj', $viewer);
	
	echo $a->getheader();
	echo $a->getDys();

	
}elseif($flag === 'two'){
	
	$sf1 = isset($_POST['sf1']);

	//add sub flags for object calls
	include 'upload.php';
	
	if($sf1 == 'one'){
		
		$res = array();
		//echo var_dump($_POST);
		if($_FILES != null){
		
			if($_POST['tit']!=null){
				$s = file_get_contents('ldrobj');
				$loader = unserialize($s);
				$loader->submitblog($_POST['tit'],$_POST['msg'],$_FILES['file']);
				
				$res['result']['validt']="true";
				$res['result']['valid']="true";
				
				echo json_encode($res);
				
			}else{
				
				$res['result']['validt']="false";
					
				echo json_encode($res);
				
			}
		
		}else{
			
			$res['result']['valid']="false";
			
			echo json_encode($res);
		}
		
	}else{
	
		$a = new uploader($_SESSION['uNme']);
		$loader = serialize($a);
		// store $s somewhere where page2.php can find it.
		file_put_contents('ldrobj', $loader);
		
		echo $a->getheader();
		echo $a->getDys();
		
		$flag=0;
	}
	
	
	
}elseif($flag === 'thr'){

	$sf1 = $_POST['sf1'];

	//add sub flags for object calls
	include 'manage.php';
	
	
	if($sf1 === "one"){

		$a = new postManager($_SESSION['uNme']);
		$manager = serialize($a);
	
		file_put_contents('postobj', $manager);
		
		echo $a->getheader();
		echo $a->getDys();
		
		$flag=0;
		
		
	}elseif($sf1 === "two"){
	
		if($_POST['ind']!=null){
		
		$s = file_get_contents('postobj');
		$manager = unserialize($s);
		
		$res = $manager->updateBlog($_POST['tit'],$_POST['msg'],$_POST['ind']);
		
		echo json_encode($res);
		
		}else{
			
			$res = array();
			
			$res['result']['valid']="false";
			
			echo json_encode($res);
			
		}
		
	}elseif($sf1 === 'thr'){
		
		if($_POST['ind'] != null){
		
		$s = file_get_contents('postobj');
		$manager = unserialize($s);
		
		$res = $manager->deleteBlog($_POST['ind']);
		
		echo json_encode($res);
		
		}else{
			
			$res = array();
				
			$res['result']['valid']="false";
				
			echo json_encode($res);
			
			
		}

	}elseif($sf1 === 'for'){
		
		$s = file_get_contents('postobj');
		$manager = unserialize($s);
		
		
		echo $manager->getPostHTML();
		
	}
	
	
}elseif ($flag == 'for'){
	
	include 'settings.php';
	
	$sf1 = $_POST['sf1'];
	
	if($sf1 === "one"){
	
		$a = new Settings($_SESSION['uNme']);
		$setting = serialize($a);
		// store $s somewhere where page2.php can find it.
		file_put_contents('settobj', $setting);
	
		echo $a->getheader();
		echo $a->getDys();
		
		$flag=0;
	
	
	}elseif($sf1 === "two"){
		
		$s = file_get_contents('settobj');
		$setting = unserialize($s);
		
		
	}elseif($sf1 === "thr"){
		
		$pas = $_POST['pas'];
		$cas = $_POST['cas'];
		$res = array();
		
		if($pas == ""){

			$res['result']['errupass']="missing";
			
		}else if( $cas == ""){
			
			$res['result']['errcpass']="missing";
			
		}else if( $cas!=$pas){
		
			$res['result']['errcpass']="nomatch";
			
		}else{
			
			$s = file_get_contents('settobj');
			$setting = unserialize($s);

			//calls set pass object
			$setting->updatePassword($pas);
	
			$res['result']['errupass']="valid";
			$res['result']['errcpass']="valid";
		}
		
		echo json_encode($res);
		
	}elseif($sf1 === "for"){
		//reests password from settings menu	
		$s = file_get_contents('settobj');
		$setting = unserialize($s);
		
		$email = $_POST['eml'];
		$phone = $_POST['phn'];
		$fname = $_POST['fnm'];
		$lname = $_POST['lnm'];
		
		$res = $setting->validate($email,$phone,$fname,$lname);
		
		echo json_encode($res);
		
	}elseif($sf1 === "fiv"){
		//returns user detials from current user
		$s = file_get_contents('settobj');
		$setting = unserialize($s);
		
		$res = $setting->fetchUsrDetails();
		
		echo json_encode($res);
		
	}
} 


?>