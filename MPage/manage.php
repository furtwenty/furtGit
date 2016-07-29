<?php 


	class postManager{
	
		private $usrName;
	
		function __construct($usr){
				
			$this->usrName = $usr;
				
		}
	
		private function fetchPostList(){
				
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
		
			$sql="SELECT postindex,title,msg,imgname FROM posts WHERE postusrid='$this->usrName'ORDER BY postindex";
				
			if ($result = $sqlCon->query($sql)) {
					
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					$post = new post($row[0],$row[1],$row[2],$row[3]);
					$list[] = $post;
				}
					
				/* free result set */
				$result->close();
			}
				
			/* close connection */
			$sqlCon->close();
		
			return $list;
				
		}
		
		private function buildPostList(){
			
			$list = $this->fetchPostList();
			
			echo "<div class='pviewlist' id='pview'>
					<div class='pcell2'>
						<table id='tbl1' cellpadding='2px' >";
							
							echo '<tr class="tlhdr">';	
							
								echo '<td>';
								
									echo "<div class='pmlb2'><label>Title</label>";
									
								echo '</td>';
								
								echo '<td>';
								
									echo "<div class='pmlb2'><label>Index</label>";
								
								echo '</td>';
								
								echo '<td>';
								
									echo "<div class='pmlb2'><label>Message</label>";
								
								echo '</td>';
								
								echo '<tr>';
			
							foreach($list as $post){
								
								echo '<tr>';
									
									echo '<td>';
										
											echo "<div class='pmlb1'><label>".$post->getTitle()."</label>";							
									
									echo '</td>';
									
									echo '<td>';										
										
											echo "<div class='pmlb1'><label>".$post->getIndex() ."</label>";										
										
									echo '</td>';
										
									echo '<td>';	
										
											echo "<div class='pmlb1'><label>".$post->getMessage()."</label>";										
										
									echo '</td>';
							
								
							}
			
			echo "		</table>
					
					</div>
					
				</div>";
			
			
		}
		
		public function getPostHTML(){
			
			return $this->buildPostList();
			
		}
		
		public function deleteBlog($postId){
			
			$res = array();
				
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
				$result['result']['dbcon'] = "Connected successfully";
			}
			
				
			//querys database to check for valid user specified post id
				
			$sql = "SELECT postindex FROM posts WHERE postindex='$postId'";
			
			$result = $sqlCon->query($sql);
				
				
			//if result has somthing in it
			if ($result->num_rows > 0) {
			
				$sql = "DELETE FROM posts WHERE postindex='$postId'";
				
				
				if ($sqlCon->query($sql) === TRUE) {
					//sets validtion modifier for valid deletion
					$res['result']['cdel'] = "valid";
				} else {
					//sets validation modifier for invalid deletion
					$res['result']['cdel'] = "invalid";
				}
					
					
			}else{
				$res['result']['contains'] = "invalid";
			}
			
				
			$sqlCon->close();
			
			return $res;
			
		}
		
		public function updateBlog($title,$message,$postId){
				
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
			
			$sql = "SELECT postindex FROM posts WHERE postindex='$postId'";
		
			$result = $sqlCon->query($sql);
			
			
			//if result has somthing in it
			if ($result->num_rows > 0) {
				
				//if the title feild provided by user is emtpy no update is peformed to title
				if($message!=""){
					
					$sql = "UPDATE posts SET msg='$message' WHERE postindex='$postId'";
					
					if ($sqlCon->query($sql) === TRUE) {
						$res['result']['dbquery1']="New record created successfully";
					} else {
						$res['result']['dbquery1']="Error: " . $sql . " " . $sqlCon->error;
					}
					
				}
				
				//if the message feild provided by user is emty no update is performed to meassage
				if($title!=""){
				
					$sql = "UPDATE posts SET title='$title' WHERE postindex='$postId'";
						
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
				
			return "<label class='hdr1'>Manage Your Posts</label>";
				
		}
	
		public function getDys(){
				
				
			echo "
			
			<div class='pload' id='pload' >
	
				<div class='pmlist' id='pmlistdiv'>
					
					";
					echo $this->buildPostList();
					
				echo "
					
					
				</div>
			
				<div class='pinfo'>
					<label class='pldlbl1'>Post Index</label><br>
					<input class='pldin1' type='text' id='pminpt2' placeholder='' maxlength='50'/>
				</div>
				
				<br>
						
				<div class='pinfo'>
					<label class='pldlbl1'>Edit A Post Title</label><br>
					<input class='pldin1' type='text' id='pminpt1' placeholder='' maxlength='50'/>
				</div>
				<br>
	
				<div class='pmsg'>
					<label class='pldlbl3'>Edit A Story</label><br>
					<textarea class='pldin3' id='pminpt3' placeholder='' maxlength='1000'/>
				</div>
	
				<br>
	
				<div id='pres'>
			
				</div>		
						
				<div class='pdell'>
					<label id='uplddel'>Delete</label>
				</div>
			
						
				<div class='psubb'>
					<label id='upldsub'>Submit</label>
				</div>
				
				
				<br>
			
				
	
	
			</div>
			
			<script type='text/javascript'>
	
				var btn1 = $('#upldsub');
				var btn2 = $('#uplddel');
			
				btn1.click(
					function() {
	
        				var title = $('#pminpt1').val();
						var message = $('#pminpt3').val();
						var index = $('#pminpt2').val();
			
					    $.ajax({
					        type: 'POST',
	    		   			dataType: 'html',
	    		  			data: {flag:'thr',sf1:'two',ind:index,tit:title,msg:message},
					        url: 'controller.php',
					        success: function(data){
						
								var j = JSON.parse(data);
							
								if(j.result.contains=='invalid'){
		    		
		    						$('#pres').html('* Invalid Post ID');
									$('#pminpt2').val('');
		    	
		    					}else if(j.result.valid == 'false'){
						
									$('#pres').html('* Please Enter a Post ID');
						
								}else{
						
									$('#pres').html('Post Update Successful');
									$('#pminpt1').val('');
									$('#pminpt2').val('');
									$('#pminpt3').val('');
						
									$.ajax({
								        type: 'POST',
				    		   			dataType: 'html',
				    		  			data: {flag:'thr',sf1:'for'},
								        url: 'controller.php',
								        success: function(data){
									
											$('#pmlistdiv').html(data);
									
								        }
								    });
						
						
								}
					
					        }
					    });
	
					}
				);
						
						
						
				btn2.click(
					function() {
						var index = $('#pminpt2').val();
			
					    $.ajax({
					        type: 'POST',
	    		   			dataType: 'html',
	    		  			data: {flag:'thr',sf1:'thr',ind:index},
					        url: 'controller.php',
					        success: function(data){
						
								var j = JSON.parse(data);
						
								if(j.result.contains=='invalid'){
		    		
		    						$('#pres').html('* Invalid Post ID');
		    						$('#pminpt2').val('');
								
		    					}else if(j.result.valid == 'false'){
						
									$('#pres').html('* Please Enter a Post ID');
						
								}else{
				    		    	
									$('#pres').html('Post Deletion Successful');
									$('#pminpt1').val('');
									$('#pminpt2').val('');
									$('#pminpt3').val('');
							
									 $.ajax({
								        type: 'POST',
				    		   			dataType: 'html',
				    		  			data: {flag:'thr',sf1:'for'},
								        url: 'controller.php',
								        success: function(data){
									
											$('#pmlistdiv').html(data);
									
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