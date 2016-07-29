

$(document).ready(function() {
	
	//this method handles the call to fetch the login bar for each page
	$.ajax({
	    type: "POST",
	    dataType: 'html',
	    url: "session.php",
	    success: function (data) {
	    	
	    	//alert(data);
	    	$var = data;
	    	document.getElementById("logbar").innerHTML = $var;
	    	

	    	//sets action event for logout button
	      	$("#blogout").on("click",function() {
	    		
	    		
	    		//ajax post call for ending session and redirect
	    		$.ajax({
	    		    type: "POST",
	    		    dataType: 'html',
	    		    url: "logout.php",
	    		    success: function (data) {
	    		    	alert("Logged Out!");
	    		    	window.location.href = "login.html";
	    		    }
	    		});
	    		
	    	});
	    	
	    	
	    }
	});
	
	//action method for delete book button
	$("#delbook").click(function() {
		
		var delbk = $("#delbtxt").val();
		
		
		//this method handles the call to contoller
		$.ajax({
		    type: "POST",
		    dataType: 'html',
		    url: "controller.php",
		    data: {flag:"two",del:delbk},
		    success: function (data) {
		    	
		    	var j = JSON.parse(data);
		    	
		    	$("#delbtxt").val("");
		    	
		    	if(j.result.contains=="invalid"){
		    		
		    		$("#lbldelbook").html("* Invalid Book ID");
		    	
		    	}else if(j.result.cdel=="invalid"){
		    		
		    		$("#lbldelbook").html("* Invalid Book ID");
		    	
		    	}else if(j.result.bdel=="invalid"){
		    		
		    		$("#lbldelbook").html("* Invalid Book ID");
		    	
		    	}else{
		    		
		    		//alert(data);
		    		$("#lbldelbook").html("");
		    		$("#divlib").html("");
		    		$("#divbookdet").html("");
		    	}
		  
		    }
		    
		});
		
	});
	
	
	
	
	
	//action method for adding book
	$("#addbook").click(function(){
			
		//this method handles the call to fetch the login bar for each page
		$.ajax({
		    type: "POST",
		    dataType: 'html',
		    url: "addbook.php",
		    success: function (data) {
		    	
		    	$var = data;
		    	document.getElementById("divaddbook").innerHTML = $var;

		    	//click event for submit add book details
		    	$("#subaddbook").on("click",function() {
		    	
			    	var bktitle = $("#addbname").val();
			    	var bkauth	= $("#addbauth").val();
			    	var bkid = $("#addbid").val();
			    	var tflag = aflag = iflag = 1;
			    	
			    	if(bktitle==""){
			    		
			    		$("#addbnerr").html("* Book Title Required");
			    		tflag=0;
			    		
			    	}
			    	if(bkauth==""){
			    		
			    		$("#addbaerr").html("* Book Author Required");
			    		aflag=0;
			    		
			    	}
			    	if(bkid==""){
			    		
			    		$("#addbierr").html("* Book Id Required");
			    		aflag=0;
			    		
			    	}
			    	
			    	if((tflag==1)&&(aflag==1)&&(iflag==1)){
			    		
			    		//this method handles the call to fetch the login bar for each page
			    		$.ajax({
			    		    type: "POST",
			    		    dataType: 'html',
			    		    url: "controller.php",
			    		    data: {flag:'one',btit:bktitle,auth:bkauth,id:bkid},
			    		    success: function (data) {
			    		    	
			    		    	document.getElementById("divaddbook").innerHTML = data;
			    		    	$("#divlib").html("");
			    		    	$("#divbookdet").html("");
			    		    	
	
			    		    }
			    		});	
			    	}
		    	});
		    }
		});
	
	});
	
	
	//action method for check out book button
	$("#chkbook").click(function() {
		
		var chkbk = $("#chkbtxt").val();
		
		
		//this method handles the call to contoller
		$.ajax({
		    type: "POST",
		    dataType: 'html',
		    url: "controller.php",
		    data: {flag:"six",chk:chkbk},
		    success: function (data) {
		    	
		    	var j = JSON.parse(data);
		    	
		    	$("#delbtxt").val("");
		    	
		    	if(j.result.contains=="invalid"){
		    		
		    		$("#lblchkbook").html("* Invaid Book ID");
		    		$("#chkbtxt").val("");
		    	}else if(j.result.ccontains=="invalid"){
		    		
		    		$("#lblchkbook").html("* Required Book ID");
		    		
		    	}else if(j.result.check=="invalid"){
		    		
		    		$("#lblchkbook").html("* Book Unavailible for Checkout");
		    		$("#chkbtxt").val("");
		    	}else{
		    		alert("Checkout :: Successful");
		    		$("#lblchkbook").html("");
		    		$("#chkbtxt").val("");
		    		$("#divlib").html("");
		    		$("#divbookdet").html("");
			    	//alert("checkout: "+data);

		    	}
		  
		    }
		    
		});
		
	});
	
	
	$("#retbook").click(function() {
		
		var chkbk = $("#retbtxt").val();
		
		
		//this method handles the call to contoller
		$.ajax({
		    type: "POST",
		    dataType: 'html',
		    url: "controller.php",
		    data: {flag:"sev",chk:chkbk},
		    success: function (data) {
		    	
		    	var j = JSON.parse(data);
		    	//alert("checkout: "+data);
		    	
		    	$("#retbtxt").val("");
		    	
		    	if(j.result.contains=="invalid"){
		    		
		    		$("#lblretbook").html("* Invaid Book ID");
		    	
		    	}else if(j.result.ccontains=="invalid"){
		    		
		    		$("#lblretbook").html("* Required Book ID");
		    	
		    	}else if(j.result.check=="invalid"){
		    		
		    		$("#lblretbook").html("* Book is Not Checked Out");
		    	
		    	}else{
		    		alert("Book Return: Success");
		    		$("#lblretbook").html("");
		    		$("#divlib").html("");
		    		$("#divbookdet").html("");
		    	}
		  
		    }
		    
		});
		
	});
	
	
	//action method for delete book button
	$("#history").click(function() {
		
		var lname = $("#hisbtxt").val();
		
		
		//this method handles the call to fetch the login bar for each page
		$.ajax({
		    type: "POST",
		    dataType: 'html',
		    url: "controller.php",
		    data: {flag:'thr',name:lname},
		    success: function (data) {
		    	
		    	   document.getElementById("divloan").innerHTML = data;

		    }
		    
		});
		
	});
	
	
	//calls php echo for dynamically creating table
	$("#showlib").click(function(){
		
		//this method handles the call to fetch the login bar for each page
		$.ajax({
		    type: "POST",
		    dataType: 'html',
		    url: "controller.php",
		    data: {flag:'for'},
		    success: function (data) {
		    	
		    	$("#divlib").html(data);

		    }
		    
		});
		
		
	});
	
	

});