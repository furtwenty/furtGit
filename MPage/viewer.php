<?php 


	class viewer{

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
			
			$sql="SELECT postindex,title,msg FROM posts WHERE postusrid='$this->usrName'ORDER BY postindex";
			
			if ($result = $sqlCon->query($sql)) {
			
				/* fetch object array */
				while ($row = $result->fetch_row()) {
					$post = new post($row[0],$row[1],$row[2]);	
					$list[] = $post;
				}
			
				/* free result set */
				$result->close();
			}
			
			/* close connection */
			$sqlCon->close();
		
			return $list;	
			
		}
		
		public function getHeader(){

			echo "<label class='hdr1'>M-Page Viewer</label>";

		}

		public function getDys(){
						
			$list = $this->fetchPostList();
				
			echo "
			
			<div class='pload' id='pload'>
				
					<div class='pviewlist' id='pview'>
					
						<table id='tbl1' cellpadding='3'  >";
			
							$colCount = 0;
							echo '<tr>';
							foreach($list as $post){
									
								if($colCount >= 3){
									$colCount=0;
									echo '<tr>';
									echo '<td>';
										echo "<div class='pcell'>";
										echo "<div class='plb1'><textarea class='ptxt1' readonly='true'>".$post->getTitle().'</textarea></div>';
										echo "<img class='pimg1' src='images/uploads/id_". $post->getIndex() .".png'/>";
										echo '<div class="plb2"><textarea class="ptxt2" readonly="true">'.$post->getMessage().'</textarea></div>';
										echo "</div>";
									echo '</td>';
								}else{
									echo '<td>';
										echo "<div class='pcell'>";
										echo "<div class='plb1'><textarea class='ptxt1' readonly='true'>".$post->getTitle().'</textarea></div>';
										echo "<img class='pimg1' src='images/uploads/id_". $post->getIndex() .".png'/>";
										echo '<div class="plb2"><textarea class="ptxt2" readonly="true">'.$post->getMessage().'</textarea></div>';
										echo "</div>";
									echo '</td>';
								}
									
								$colCount++;
								
							}
			
							echo '<tr>';
			
			echo "		</table>
					
					</div>
		
			</div>
			
			<script type='text/javascript'>
		
			</script>";
		}
		
	}
	


?>