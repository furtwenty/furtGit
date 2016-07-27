<?php

session_start();

date_default_timezone_set('America/Mexico_City');
	//echo var_dump($_SESSION);
	//echo var_dump($_GET);
	//echo var_dump($_POST);


updatePost();
	
function updatePost(){
	
	
	
	$fileParse = file_get_contents(".\\post.txt");
	
	$j = json_decode($fileParse,true);
	
	$setFlag=0;
	$i = 0;
	
	//holds value of consturcted blog list
	$p = array();
	
	if($_SESSION['indx']!=""){
		foreach ($j['postList'] as &$pobject){
		
			if($_SESSION['indx']==$i){
				
				$pobject['data']['title'] = $_SESSION['btit'];
				$pobject['data']['subject'] = $_SESSION['bsub'];
				$pobject['data']['postData'] = $_SESSION['blog'];

				
				
				$setFlag=1;
			}
			$i++;
		}
		$p = $j;
	}
	if($setFlag==0){
		
		
		$username = $_SESSION['name'];
		
		$title = $_SESSION['btit'];
		$subject = $_SESSION['bsub'];
		$postData = $_SESSION['blog'];
		
		$data = array("title"=>$title,"subject"=>$subject,"postData"=>$postData);
		
		
		
		$month = date('m');
		$day = date('d');
		$year = date('Y');
		
		$date = array("month"=>$month,"day"=>$day,"year"=>$year);
		
		$hour = date('g');
		$min = date('i');
		$sec = date('s');
		$timee = time();
		
		$time = array("hour"=>$hour,"min"=>$min,"sec"=>$sec,"elsp"=>$timee);
		
		$timestamp = array("date"=>$date,"time"=>$time);		
		
		$post = array("usrname"=>$username,"data"=>$data,"timestamp"=>$timestamp);
		
		
		$a = array();
		array_push($a,$post);
		
		foreach($j['postList'] as $object){
			array_push($a,$object);
		}
		
		$b = ["postList"=>$a];
		$p = $b;
	}
	
	//print_r(json_encode($j));
	
	//print_r("\n");
	//$b = array_reverse($j['postList']);
	
	//$c = ["postList"=>$b];
	//print_r(json_encode($c));
	
	$d = json_encode($p);
	
	//print_r($j);
	
	file_put_contents(".\\post.txt",$d);
	
	$_SESSION['indx'] = "";
	
}
	
?>