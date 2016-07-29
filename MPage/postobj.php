<?php 
	class post{
		
		private $title;
		private $message;
		private $imgindex;
		
		
		function __construct($imgindex,$title,$message){
				
			$this->title = $title;
			$this->message = $message;
			$this->imgindex = $imgindex;
				
		}
		
		public function getTitle(){
			return $this->title;
		}
		
		public function getMessage(){
			return $this->message;
		}
		
		public function getIndex(){
			return $this->imgindex;
		}
		
	}
	
	?>