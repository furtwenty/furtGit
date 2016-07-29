

$(document).ready(function() {
	
	//this method handles the call to fetch the login bar for each page
	$.ajax({
	    type: "POST",
	    dataType: 'html',
	    url: "session.php",
	    data: {flag:"one"},
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
	
	//this method handles the call to fetch the menu bar for each page
	$.ajax({
	    type: "POST",
	    dataType: 'html',
	    url: "session.php",
	    data: {flag:"two"},
	    success: function (data) {
	    	
	    	//alert(data);
	    	//sets desired div elements html to the received data from call
	    	$var = data;
	    	document.getElementById("sidem").innerHTML = $var;
	    
	    	//sets action event for menu viewer button
	      	$("#mviewbtn").on("click",function() {
	    		
	    		
	    		//ajax post call for ending session and redirect
	    		$.ajax({
	    		    type: "POST",
	    		    dataType: 'html',
	    		    url: "controller.php",
	    		    data: {flag:"one"},
	    		    success: function (data) {
	    		    	
	    		    	lvar = data;
	    		    	$("#main").html(lvar);
	    		    	
	    		    }
	    		});
	    		
	    	});
	    	
	      	
	      //sets action event for upload button
	      	$("#mupldbtn").on("click",function() {
	    		
	    		
	    		//ajax post call for ending session and redirect
	    		$.ajax({
	    		    type: "POST",
	    		    dataType: 'html',
	    		    url: "controller.php",
	    		    data: {flag:"two"},
	    		    success: function (data) {
	    		    	
	    		    	lvar = data;
	    		    	$("#main").html(lvar);
	    		    	
	    		    }
	    		});
	    		
	    	});
	      	
	      //sets action event for manager button
	      	$("#mmngrbtn").on("click",function() {
	    		
	    		
	    		//ajax post call for ending session and redirect
	    		$.ajax({
	    		    type: "POST",
	    		    dataType: 'html',
	    		    url: "controller.php",
	    		    data: {flag:"thr", sf1: "one"},
	    		    success: function (data) {
	    		    	
	    		    	lvar = data;
	    		    	$("#main").html(lvar);
	    		    	
	    		    }
	    		});
	    		
	    	});
	      	
		   //sets action event for user settings button
	      	$("#msettbtn").on("click",function() {
	    		
	    		
	    		//ajax post call for ending session and redirect
	    		$.ajax({
	    		    type: "POST",
	    		    dataType: 'html',
	    		    url: "controller.php",
	    		    data: {flag:"for", sf1: "one"},
	    		    success: function (data) {
	    		    	
	    		    	lvar = data;
	    		    	$("#main").html(lvar);
	    		    	
	    		    }
	    		});
	    		
	    	});
	      	
	    	
	    }
	});
	

});