<?php 
	
	session_start();
	
	echo "

			<input type='button'
					id='blogout' 
					name='btnlogout' 
					value='Logout'
					style='
					
					margin-top: 10px;
   					margin-bottom: 10px;
    				margin-right: 20px;
    				margin-left: 20px;
					align-right: 0px;
					position: absolute;
					right: 0px;

			'/>
			
			<label id='lbarusr' 
					style='
			
						margin-top: 10px;
   						margin-bottom: 10px;
    					margin-right: 20px;
    					margin-left: 20px;
						align-right: 0px;
						position: absolute;
    					right: 80px;
					
						font-size: 24px;
					'
			
			>User: ".$_SESSION['uNme']."</label>
		
		 "

?>