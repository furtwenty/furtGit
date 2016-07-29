<?php 

	

	class uploader{
		
		private $usrName;
		
		function __construct($usr){
			
			$this->usrName = $usr;
			
		}
		
		public function submitblog($title,$message,$image){
			
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
			
			$name = $image['name'];
			
			$sql = "INSERT INTO posts (
			postusrid, msg, title, imgname
			) VALUES (
			'$this->usrName','$message', '$title', '$name')";
			
			if ($sqlCon->query($sql) === TRUE) {
				//echo "New record created successfully<br>";
			} else {
				//echo "Error: " . $sql . "<br>" . $sqlCon->error;
			}
			
			$imagename = $sqlCon->insert_id;
			
			move_uploaded_file( $image["tmp_name"], "images/uploads/id_" .  $imagename . ".png");
			
			
			$sqlCon->close();
			
		}
		
		public function getheader(){
			
			return "<label class='hdr1'>Upload Your Post</label>";
			
		}
		
		public function getDys(){
			
			
			return "
					
			<div class='pload' id='pload'>
				
				<div id='pimg'>	
					<img src='images/upld_img1.png' class='tmpimage' id='tmpimg'/>
				
					<div class='upimage' hidden='true'>
 				 		<input class='fup' type='file' name='upimgfile'/>
					</div>
				</div>
					
				<div class='pinfo'>
					<label class='pldlbl1'>Give Your Post a Title</label><br>
					<input class='pldin1' type='text' id='pldinpt1' placeholder='' maxlength='50'/>
				</div>
				<br>	
				
				<div class='pmsg'>
					<label class='pldlbl3'>Tell A Story</label><br>
					<textarea class='pldin3' id='pldinpt3' placeholder='' maxlength='1000'/>					
				</div>
				
				<br>
					
				<div class='psubb'>
					<label id='upldsub'>Submit</label>
				</div>	
					
				<div id='pres1'>
					
				</div>
				<br>
				
					
				
				
				
			</div>
					
			<script type='text/javascript'>
				
				var btn1 = $('#upldsub');
				var btn2 = $('#tmpimg');
					
				btn1.click(
					function() {
 					  
						var mydata = new FormData();
						var file_data = $('.fup').prop('files')[0];   // Getting the properties of file from file field
        				var title = $('#pldinpt1').val();
						var message = $('#pldinpt3').val();
						
						mydata.append('file', file_data)  
						mydata.append( 'tit' , title);
						mydata.append( 'msg' , message);
					   	mydata.append( 'flag' , 'two');
						mydata.append( 'sf1' , 'one');
					
					
					    $.ajax({
					        type: 'POST',               
					        processData: false, 
					        contentType: false,  
                			cache: false,
					        data: mydata,
					        url: 'controller.php',
					        success: function(data){
					
								var j = JSON.parse(data);
								
								if(j.result.validt=='false'){
		    		
		    						$('#pres1').html('* Please Enter A Title');
									
		    					}else if(j.result.valid == 'false'){
							
									$('#pres1').html('Click Image to Select Upload');
							
								}else{
					
					    		    	$('#pres1').html('Post Uploaded');
										$('#pldinpt1').val('');
										$('#pldinpt3').val('');
										$('#tmpimg').attr('src', 'images/upld_img1.png');
										
						        }
							}
					    }); 
				
					}
				);
					
				btn2.click(
					function() {
					
 					  $('.fup').trigger('click');
				
					}
				);
					
				$('.fup').change(function(){
    				preview(this);
				});
				
				function preview(input) {

   					if (input.files && input.files[0]) {
        				var reader = new FileReader();

        				reader.onload = function (e) {
            			$('#tmpimg').attr('src', e.target.result);
        				}

        			reader.readAsDataURL(input.files[0]);
    				}
				}

				
				
					
			</script>";
		}
		
		
		
	}


?>