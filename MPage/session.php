<?php 
	
	session_start();
	
	$flag = $_POST['flag'];
	
	if($flag === 'one'){
	
		echo "
		
			<label id='lbar'
					style='
		
						margin-top: 5px;
   						margin-bottom: 20px;
    					margin-right: 20px;
    					margin-left: 20px;
						align-right: 0px;
						position: absolute;
    					Left: 20px;
			
						font-size: 24px;
						font-weight: bold;
					'
		
			>M-Page :: Show Me What You Got</label>
		
		
			<label
					id='blogout'
					name='btnlogout'
					style='
			
					margin-top: 8px;
   					margin-bottom: 10px;
    				margin-right: 20px;
    				margin-left: 20px;
					align-right: 0px;
					position: absolute;
					right: 0px;
		
			'>Logout</label>
		
			<label id='lbarusr'
					style='
		
						margin-top: 5px;
   						margin-bottom: 10px;
    					margin-right: 20px;
    					margin-left: 20px;
						align-right: 0px;
						position: absolute;
    					right: 80px;
			
						font-weight: bold;
						font-size: 24px;
					'
		
			>User: ".$_SESSION['uNme']."</label>
		
		 ";
		
		$flag=0;
	
	}elseif($flag === 'two'){
	
		echo "
			<ul>
			  <li class='active'><label id='mviewbtn'>M-Viewer</label></li>
			  <li class='active'><label id='mupldbtn'>Upload M-Post</label></li>
			  <li class='active'><label id='mmngrbtn'>Manage M-Post</label></li>
			  <li class='active'><label id='msettbtn'>Settings</label></li>
			</ul>
		
				
		";
	
		$flag=0;
	}
	
	
?>