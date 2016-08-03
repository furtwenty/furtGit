<?php 

	ini_set('display_errors', 1);
	
	session_start();
	
	$hit = new hitter("../tmp/cnt.txt");

	echo $hit->hitcount();

	/**
	* 
	*/
	
	class hitter
	{
		
		private $fPath;


		function __construct($val)
		{
			$this->fPath = $val;
		}
	
		private function get_IP() {

		    // ADRES IP
		    if     (getenv('HTTP_CLIENT_IP'))       $ipaddress = getenv('HTTP_CLIENT_IP');
		    else if(getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		    else if(getenv('HTTP_X_FORWARDED'))     $ipaddress = getenv('HTTP_X_FORWARDED');
		    else if(getenv('HTTP_FORWARDED_FOR'))   $ipaddress = getenv('HTTP_FORWARDED_FOR');
		    else if(getenv('HTTP_FORWARDED'))       $ipaddress = getenv('HTTP_FORWARDED');
		    else if(getenv('REMOTE_ADDR'))          $ipaddress = getenv('REMOTE_ADDR');
		    else                                    $ipaddress = 'UNKNOWN';
		    //
		    return $ipaddress;
		}

		public function hitcount(){
		
			//stores remote ip appends
			$ip_cur = $this->get_IP();//$_SERVER['REMOTE_ADDR'];
			//echo $ip_cur." :: Views : ";
			$cookie_id = "cookie_id-42:".$ip_cur;

			$cnt = strval(file_get_contents($this->fPath));

			if (!isset($_COOKIE[$cookie_id])) {

				setcookie($cookie_id,"Checked", 1);
				
			}

			$cnt = $cnt+1;

			file_put_contents($this->fPath, $cnt);

			return $cnt;

		}


	} 
 ?>