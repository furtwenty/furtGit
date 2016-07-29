<?php
session_start();


$_SESSION['name'] = $_GET['usnr'];




if (isset($_POST['action']) == "one") {
	
	setBlogSession();
	
}elseif (isset($_POST['action']) == "two") {
	
	displayTable();
	
}else{
	
$_SESSION['name'] = $_GET['usnr'];
//echo var_dump($_GET);
//echo var_dump($_POST);
//echo var_dump($_SESSION);
loadScripts();
createHeader();
displayTable();

}


function loadScripts(){
	
	echo '	
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
			<script type="text/javascript">
			
			$(document).ready(function(){
			
			var btn = $("#npost");
			var btn2 = $("#nbsub");
			var btn3 = $("#logout");
			
			btn.click(
			function(){
	
				$("#dlog").show();
				$("#btitle").val("");
				$("#bsubject").val("");
				$("#blog").val("");
				$("#indx").val("");
			});
	
			
			
			btn2.on("click",
			function(){
				var one = "one";
				var ind = $("#indx").val();
				var tit = $("#btitle").val();
				var sub = $("#bsubject").val();
				var blo = $("#blog").val();
				
				//console.log("index : "+ind);				
			
				$.post("./viewPosts.php", 
				{action:one,subject:sub,blog:blo,title:tit,bindx:ind},
				function(data){			
					$( "#tbldiv" ).html(data);			 		
					$("#dlog").hide();
				});
			}
			);
			
			
			btn3.click(
			function(){
			
				$.post( "./logout.php",
	 					{},	
						function(data){
					
	 						window.location.href = "login.html";
			
						}
				);
			
			
			});
	
			
			});
			</script>
			
	';
	
}

function setBlogSession(){

	
	$_SESSION['indx'] = $_POST['bindx'];
	$_SESSION['btit'] = $_POST['title'];
	$_SESSION['bsub'] = $_POST['subject'];
	$_SESSION['blog'] = $_POST['blog'];
	

	updatePost();

	displayTable();
	
}

function createHeader(){
	
	echo '
	
		<h1>M-Blog</h1>
		<input type="button" id="npost" name="npost" value="New Post"/>
		<input type="button" id="logout" value="Log Out" />
			
			
		<br></br>
		<div id="dlog" hidden="true" >
			
			<input type="text" id="indx" hidden="true" />
			Title   : <input type="text" id="btitle" />
			<br><br>
			Subject : <input type="text" id="bsubject" />
			<br><br>
			Blog 	: <textarea id="blog" name="textarea" style="width:250px;height:150px;" ></textarea>
			<br><br>	
			<input type="button" id="nbsub" value="Submit" />
			<br><br>	
		</div>
			
		<br></br>
		<br>Post List:</br>
			
	';
	
}

function displayTable()
{
	echo '<div id="tbldiv" style="height:200px;overflow:auto;" >';
	echo '<table id="tbl1" cellpadding="3" >';

	$fileParse = file_get_contents("./post.txt");
	
	$j = json_decode($fileParse,true);

	echo '<tr>';
	echo '<td>' . htmlspecialchars("#") . '</td>';
	echo '<td>' . htmlspecialchars("Creator") . '</td>';
	echo '<td>' . htmlspecialchars("Title") . '</td>';
	echo '<td>' . htmlspecialchars("Subject") . '</td>';
	echo '<td>' . htmlspecialchars("Date") . '</td>';
	echo '<td>' . htmlspecialchars("Time") . '</td>';
	echo '<td>' . htmlspecialchars("Update") . '</td>';
	echo '<tr>';
	$i = 0;
	foreach ($j['postList'] as $pobject){
		echo '<tr>';
		echo '<td>' . htmlspecialchars($i) . '</td>';
		
		echo '<td>' . htmlspecialchars($pobject['usrname']) . '</td>';
		echo '<td>' . htmlspecialchars($pobject['data']['title']) . '</td>';
		echo '<td>' . htmlspecialchars($pobject['data']['subject']) . '</td>';
		echo '<td>' . htmlspecialchars($pobject['timestamp']['date']['month']) .'\\'
		. htmlspecialchars($pobject['timestamp']['date']['day']) . '\\'
		. htmlspecialchars($pobject['timestamp']['date']['year']) .'</td>';
		echo '<td>' . htmlspecialchars($pobject['timestamp']['time']['hour']) .':'
				. htmlspecialchars($pobject['timestamp']['time']['min']) . ':'
						. htmlspecialchars($pobject['timestamp']['time']['sec']) .'</td>';
		echo '<td>' . '<input type="button" id="lupdt'. $i . '" name="lupdt" value="Update"/>'
		. '<script>	
			
			var btn2 = $("#lupdt' . $i . '");
					
					
			btn2.click(
			function(){
				
				$("#indx").val('.$i.');
				$("#btitle").val("' . htmlspecialchars($pobject['data']['title']).'");
				$("#bsubject").val("' . htmlspecialchars($pobject['data']['subject']).'");
				$("#blog").val("' . htmlspecialchars($pobject['data']['postData']).'");
						
				alert("Update blog ' . $i . '");
        		
				$("#dlog").show();		
						
        		
	
			});
				
		
		</script>'
		.'</td>';
		
		echo '<tr>';
		$i++;
	}
	
	echo '</table>';
	echo '</div>';

}

//echo var_dump($_SESSION);
//echo var_dump($_GET);
//echo var_dump($_POST);
function updatePost(){
	
	//echo var_dump($_SESSION);

	date_default_timezone_set('America/Mexico_City');

	$fileParse = file_get_contents("./post.txt");

	$j = array();

	$k = array();

	$j = json_decode($fileParse,true);

	$setFlag=0;
	$i = 0;
	
	if($_SESSION['indx']!=""){
		foreach ($j['postList'] as $pobject){

			if($_SESSION['indx']==$i){

				$pobject['data']['title'] = $_SESSION['btit'];
				$pobject['data']['subject'] = $_SESSION['bsub'];
				$pobject['data']['postData'] = $_SESSION['blog'];
				//print_r($pobject['data']['title']);

					
				$setFlag=1;
			}
			array_push($k,$pobject);
			$i++;
		}

		$la = array("postList"=>$k);

		$p = json_encode($la);

		//print_r($p);

		file_put_contents("./post.txt",$p);
		

	}



	if($setFlag==0){

		//print_r("i got called");

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
		

		$p = array("postList"=>$a);
	
		$d = json_encode($p);

		file_put_contents("./post.txt",$d);
		
	}

	//print_r(json_encode($j));

	//print_r("\n");
	//$b = array_reverse($j['postList']);

	//$c = ["postList"=>$b];
	//print_r(json_encode($c));

	//$d = json_encode($p);

	//print_r($j);


	//file_put_contents("./post.txt",$d);

	$_SESSION['indx'] = "";

}

?>
