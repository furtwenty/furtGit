<?php 

session_start();

date_default_timezone_set('America/Mexico_City');

include "lib.php";
include "delbook.php";
include "loanhistory.php";

$flag = $_POST['flag'];

if($flag === 'one'){
	
	$myLib = new library();
	
	$booktitle = $_POST['btit'];
	$bookauth = $_POST['auth'];
	$bookid = $_POST['id'];
	
	$myLib->addBook($bookid,$booktitle,$bookauth);

	$flag=0;
	
}elseif($flag === 'two'){
	
	$copy_id = $_POST['del'];
	
	$var = delBook($copy_id);
	
	echo json_encode($var);
	
}elseif($flag === 'thr'){
	
	$user_id = $_POST['name'];
	
	$loans = array();
	
	$var = valid(fetchHistory($user_id));
	
	//echo json_encode($var);
	
}elseif ($flag == 'for'){
	
	$myLib = new library();
	
	$myLib->dysLib();
	
}elseif ($flag == 'fiv'){
	
	$copy_id = $_POST['copy'];
	
	$mybook = new book("","","");
	
	$mybook->fetchByCopyId($copy_id);
	
	echo '<table id="tbl1" cellpadding="3" border="2px" >
	
		<tr>
			
		<td>Book Title:</td> <td>' . $mybook->getTitle().'</td>
		
		<tr>
		<td>Book id:</td> <td> ' . $mybook->getId().'</td>
		
		<tr>
		<td>Author:</td> <td>' . $mybook->getAuthor().'</td>
		
		<tr>
		<td>Copy id:</td> <td>' . $copy_id .'</td>
		<tr>
	
	</table>';
			
}elseif ($flag == 'six'){
	
	
	if($_POST['chk']== ""){
		
		$ret = array();
		
		$ret['result']['ccontains'] = 'invalid';
		
		$var = json_encode($ret);
		
		echo $var;
		
	}else{
	
		$loan = new loan($_SESSION['uNme'],$_POST['chk'],"","");
	
		$val = $loan->checkOut();
	
		echo json_encode($val);
	}

}elseif ($flag == 'sev'){
	
	
	if($_POST['chk']== ""){
		
		$ret = array();
		
		$ret['result']['ccontains'] = 'invalid';
		
		$var = json_encode($ret);
		
		echo $var;
		
	}else{
	
		$loan = new loan($_SESSION['uNme'],$_POST['chk'],"","");
	
		$val = $loan->returnBook();
	
		echo json_encode($val);
	}

}



?>