<?php 

class library{
	
	private $shelfList; 
	private $shelfCount;

	function __construct(){
		
		$this->shelfList = array();
		$this->shelfCount = 0;
		$this->fetchShelfListDB();
		
	}
	
	private function fetchShelfListDB(){
		
		//sets my sql
		$username = "user";
		$password = "password";
		$dbServer = "localhost";
		$dbName   = "comslib";
		
		//creates a connection with mysql server
		$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
		
		// error check for connection
		if ($sqlCon->connect_error) {
			die("Connection failed: " . $sqlCon->connect_error);
			//echo "failed";
		} else {
			//echo("Connected successfully<br>");
		}
		
		$sql = "SELECT shelf_id FROM shelves";
		
		
		$result = $sqlCon->query($sql);
		//if result has somthing in it
		
		if ($result->num_rows > 0) {
			//echo "found shelf results<br>";
			
			//iterates thru shelf ids and creates list of all shelves
			while($row = $result->fetch_assoc()) {
				//echo "checking row<br>";
				$cont = 0;
				//checks if id is in current shelf list
				foreach($this->shelfList as $list){
					
					$curShelfId = $list->getShelfId();
					//echo "checking shelf list for shelf: ".$row["shelf_id"]."<br>";
					
					//if current shelf id exists break else 
					if( $row["shelf_id"] == $curShelfId){
						$cont = 1;
						
						//echo "found shelf: ".$curShelfId."<br>";
						
						break;
					}
				}
				
				//if list doesnt contian current shelf
				if($cont == 0){
					
					//echo "adding shelf: ".$row["shelf_id"]."<br>";
					$newShelf = new shelf($row["shelf_id"]);
					$this->shelfList[] = $newShelf;
					$this->shelfCount++;
				}
			}
		}
	}
	
	private function buildLibraryTable(){
		
		echo "<br>";
		echo '<div id="tbldiv" style="height:200px;overflow:auto;margin-left: 20px;" >';
		echo '<table id="tbl1" cellpadding="3" border="2px" >';
		$i=0;
		foreach ($this->shelfList as $list){
			$shelfBookList = $list->getBookList();
			echo '<tr>';
			foreach ($shelfBookList as $book){
				$i++;
				echo '<td>'.
					'<input type="button" id="lupdt'.$i.'" name="lupdt" value="'.htmlspecialchars($book).'"/>
					<script>
			
						var btn2 = $("#lupdt'.$i.'");
			
						btn2.on("click",
						function(){
			
							alert("Retriving book: ' .htmlspecialchars($book). '");
							
							var book = '.htmlspecialchars($book).';	
									
							$.ajax({
								type: "POST",
		    		 		    dataType: "html",
		    		    		url: "controller.php",
		    		   			data: {flag:"fiv",copy:book},
		    		    		success: function (data) {
		    		    	
		    		    			document.getElementById("divbookdet").innerHTML = data;

		    		    		}
										
							});
					
						});
				
					</script>
				</td>';
					
			}
			echo '<tr>';
		}
		echo '</table>';
		echo '</div>';
		
		
	}
	
	public function addBook($id,$title,$author){
		
		//creates a new book
		$book1 = new book($id,$title,$author);
		//adds book to database
		$book1->addThisBookToDB();
		echo("adding to db<br>");
		
		//iterates thru shelfs finding one under threshold
		//adds book to shelf
		//updates database appropriatly
		$added = 0;
		foreach($this->shelfList as $shell){
			echo "looking thru shelf list<br>";
			
			$shell->ListCount();
			$val = $shell->isFull();	
			
			echo "is full :".$val."<br>";
			if($val == 0){
				echo "adding copy :".$book1->getCopyId()."<br>";
				echo "To shelf :".$shell->getShelfId()."<br>";
				$shell->addCopyId($book1->getCopyId());
				$added=1;
				break;
			}
		}
		//if all shelves are full then create new shelf and add book
		if($added == 0){
			
			$this->shelfCount++;
			$s = new shelf($this->shelfCount);
			echo "added shelf :".$s->getShelfId()."<br>";
			//adds book to shelf
			$s->addCopyId($book1->getCopyId());
			echo "adding copy :".$book1->getCopyId()."<br>";
				
			//adds shelf to current shelf list
			$this->shelfList[] = $s;
		
		}
		
	}
	
	public function dysLib(){
	
		return $this->buildLibraryTable();
		
	}
	public function checkoutBook($bId){
		
	}
	
	public function returnBook($bId){
		
	}

}

class shelf{

	private $shelfId;
	private $count;
	private $max = 10;
	

	function __construct($shelfId){

		$this->shelfId = $shelfId;

		$this->count = 0;
		
	}

	public function getShelfId() {
		return $this->shelfId;
	}
	
	public function addCopyId($copyId) {
		//sets my sql
		$username = "user";
		$password = "password";
		$dbServer = "localhost";
		$dbName   = "comslib";
		
		//creates a connection with mysql server
		$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
		
		// error check for connection
		if ($sqlCon->connect_error) {
			die("Connection failed: " . $sqlCon->connect_error);
			//echo "failed";
		} else {
			//echo("Connected successfully<br>");
		}
		
		$sql = "INSERT INTO shelves (shelf_id,copy_id) VALUES ('$this->shelfId','$copyId')";
		
		$sqlCon->query($sql);
		
		$sqlCon->close();
		
		$this->count++;
	}
	
	public function ListCount(){
		
		//sets my sql
		$username = "user";
		$password = "password";
		$dbServer = "localhost";
		$dbName   = "comslib";
		
		//creates a connection with mysql server
		$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
		
		// error check for connection
		if ($sqlCon->connect_error) {
			die("Connection failed: " . $sqlCon->connect_error);
			//echo "failed";
		} else {
			//echo("Connected successfully<br>");
		}
		
		$sql = "SELECT shelf_id FROM shelves";
		
		$this->count=0;
		
		$result = $sqlCon->query($sql);
		//if result has somthing in it
		if ($result->num_rows > 0) {
			//iterates thru copy list to find if book exist in lbrary
			while($row = $result->fetch_assoc()) {
		
				if( $row["shelf_id"] === $this->shelfId){
					$this->count++;
				}
		
			}
		}
		
	}

	public function getBookList(){
	
		//sets my sql
		$username = "user";
		$password = "password";
		$dbServer = "localhost";
		$dbName   = "comslib";
		
		//creates a connection with mysql server
		$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
		
		// error check for connection
		if ($sqlCon->connect_error) {
			die("Connection failed: " . $sqlCon->connect_error);
			//echo "failed";
		} else {
			//echo("Connected successfully<br>");
		}
		
		$sql = "SELECT copy_id FROM shelves WHERE shelf_id = '$this->shelfId'";
		
		$bookList = array();
		
		$result = $sqlCon->query($sql);
		//if result has somthing in it
		if ($result->num_rows > 0) {
			//iterates thru copy list to find if book exist in lbrary
			while($row = $result->fetch_assoc()) {
		
				$bookList[] = $row['copy_id'];
		
			}
		}		
		
		
		$sqlCon->close();
		
		return $bookList;
	}
	
	public function isFull(){
		if($this->count > $this->max){
			return 1;
		}else{
			return 0;
		}
	}
	
}



class book{

	private $id;
	private $title;
	private $author;
	private $copyid;

	function __construct($id,$title,$author){

		$this->id = $id;
		$this->title = $title;
		$this->author = $author;
	}
	
	public function fetchByCopyId($copyId){
		
		//sets my sql
		$username = "user";
		$password = "password";
		$dbServer = "localhost";
		$dbName   = "comslib";
		
		//creates a connection with mysql server
		$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
		
		// error check for connection
		if ($sqlCon->connect_error) {
			die("Connection failed: " . $sqlCon->connect_error);
			//echo "failed";
		} else {
			//echo("Connected successfully<br>");
		}
		
		$book_id=null;
		
		$sql = "SELECT book_id FROM bookcopy WHERE copy_id ='$copyId'";
		
		$result = $sqlCon->query($sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$book_id = $row['book_id'];
				$this->id= $row['book_id'];
			}
		}
		
		$sql = "SELECT book_title FROM books WHERE book_id ='$book_id'";
		
		$result = $sqlCon->query($sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$this->title = $row['book_title'];
			}
		}
		
		$sql = "SELECT author FROM books WHERE book_id ='$book_id'";
		
		$result = $sqlCon->query($sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$this->author = $row['author'];
			}
		}
		
		$sqlCon->close();
		
	}
	
	public function addThisBookToDB(){
		
		//sets my sql
		$username = "user";
		$password = "password";
		$dbServer = "localhost";
		$dbName   = "comslib";
		
		//creates a connection with mysql server
		$sqlCon = new mysqli($dbServer, $username, $password, $dbName);
		
		// error check for connection
		if ($sqlCon->connect_error) {
			die("Connection failed: " . $sqlCon->connect_error);
			//echo "failed";
		} else {
			//echo("Connected successfully<br>");
		}
		
		
		$sql = "SELECT book_id FROM bookcopy";
		
		$result = $sqlCon->query($sql);
		$exist = 0;
		//if result has somthing in it
		if ($result->num_rows > 0) {
			//iterates thru copy list to find if book exist in lbrary
			while($row = $result->fetch_assoc()) {
		
				if( $row["book_id"] === $this->id){
					//copy exists
					$exist=1;
					break;
				}
		
			}
		}
		
		//if book exists adds copy else creates book adds copy
		if($exist==1){
		
			$sql = "INSERT INTO bookcopy (book_id) VALUES ('$this->id')";
		
			if ($sqlCon->query($sql) === TRUE) {
				//echo "New record created successfully<br>";
			} else {
				//echo "Error: " . $sql . "<br>" . $sqlCon->error;
			}
			$this->copyId = $sqlCon->insert_id;
		
		}else{
		
			$sql = "INSERT INTO books (book_id,book_title,author) VALUES ('$this->id','$this->title','$this->author')";
		
			if ($sqlCon->query($sql) === TRUE) {
				//echo "New record created successfully<br>";
			} else {
				//echo "Error: " . $sql . "<br>" . $sqlCon->error;
			}
		
		
			$sql = "INSERT INTO bookcopy (book_id) VALUES ('$this->id')";
		
			if ($sqlCon->query($sql) === TRUE) {
				//echo "New record created successfully<br>";
			} else {
				//echo "Error: " . $sql . "<br>" . $sqlCon->error;
			}
			$this->copyId = $sqlCon->insert_id;
		
		}
		
		$sqlCon->close();
		
	}
	
	public function getId() {
		return $this->id;
	}
	public function getTitle() {
		return $this->title;
	}
	public function getAuthor() {
		return $this->author;
	}
	public function getCopyID(){
		return $this->copyId;
	}
	
}




?>