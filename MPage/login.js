/**
 *  js routines for login.html landing page
 */

$(document).ready(function() {

	// GET THE DOM OBJECTS
	var btn1 = $("#sub1");
	var btn2 = $("#regusr");
	var btn3 = $("#subusr");
	var btn4 = $("#chk");
	var btn5 = $("#cnlusr");
	
	
	btn1.click (function () {
		
		var ussname = $("#usrid").val();
		var uspass = $("#usrpass").val();

		$("#ndiv").html("");
		$("#pdiv").html("");

	 	$.post("checkLogin.php",
		
	 	{a:ussname,b:uspass},
			
		function(data){
	 		
	 
	 		var object = JSON.parse(data);
	 		//alert(object.result.errname);
	 		//alert(object.result.errpass);
	 		//alert(object.result.user);
	 		//alert(object.result.pass);

	 		if(object.result.errname=='invalid'){
	 			
	 			$("#ndiv").html("* Name Required");
	 			

	 		}
	 		if(object.result.errpass=='invalid'){
	 			
	 			$("#pdiv").html("* Pass Word Required");

	 		}
	 		
	 		if(object.result.user=='invalid'){
	 			
	 			$("#ndiv").html("* Invalid UserName");
	 			$("#usrid").focus(
	 				    function(){
	 				        $(this).val('');
	 				    });
	 			$("#usrpass").focus(
	 				    function(){
	 				        $(this).val('');
	 				    });
	 			
	 			
	 		}else if(object.result.pass=='invalid'){
	 			$("#pdiv").html("* Invalid PassWord");
	 			$("#usrpass").focus(
	 				    function(){
	 				        $(this).val('');
	 				    });
	 			
	 		}else if(object.result.pass=='valid' && object.result.user=='valid' ){
	 			
		 		alert("Logging In");
		 		window.location.href = "mPage.html";
		 		
		 		/* used for multiple user types
		 		if(object.result.libr=='true'){
		 			window.location.href = "librarian.html";
		 		}else{
		 			window.location.href = "student.html";
		 		}
		 		*/
		 		$("#usrpass").val("");
		 		$("#usrid").val("");
	 		}
	 		
		}
	 	
	 	);
	});
	
	btn2.click (function () {

		$("#regdiv").show();
			
	});
	
	btn3.click (function () {
				
				var uname = $("#runame").val();
				var upass = $("#rpass").val();
				var	cnfupass = $("#rcpass").val();
				var uemail = $("#remail").val();
				var utele = $("#rtel").val();
				var frname = $("#rfname").val();
				var lsname = $("#rlname").val();

			 	$.post( "regusr.php",
			 			
			 	{unam:uname,upas:upass,cnfp:cnfupass,ueml:uemail,utel:utele,frnm:frname,lsnm:lsname},
			 			
			 	function(data){
					
			 		var object = JSON.parse(data);
			 		//alert(object.result.erruname);
			 		//alert(object.result.errtele);
			 		//alert(object.result.errcpass);

			 		console.log(object);
			 	
			 		// valid flags for submission feild
			 		var f1,f2,f3,f4,f5,f6,f7 = 0;
			 		
			 		//checks for invalid or missing username
			 		if(object.result.erruname=='missing'){
			 			
			 			$("#eruname").html(" * Name Required");
			 	
			 		}else if(object.result.erruname=='invalid'){
			 		
			 			$("#eruname").html(" * Invalid format :: Alpha numeric only");
			 		
			 		}else{
			 			f1 = 1;
			 			$("#eruname").html("");

			 		}
			 		
			 		//checks for invalid or missing password
			 		if(object.result.errupass=='missing'){
			 			
			 			$("#erupass").html(" * Pass Word Required");

			 		}else{
			 			f2 = 1;
			 			$("#erupass").html("");

			 		}
			 		
			 		//checks for invalid or missing confirmation password
					if(object.result.errcpass=='missing'){
			 			
			 			$("#ercpass").html(" * Comfirmation Required");

			 		}else if(object.result.errcpass=='nomatch'){
			 			
			 			$("#ercpass").html(" *Passwords Do not Match");
			 			$("#rcpass").html("");
			 			
			 		}else{
			 			f3 = 1;
			 			$("#ercpass").html("");

			 		}
			 		
			 		//checks for invalid or missing email
					if(object.result.erremail=='missing'){
			 			
			 			$("#eremail").html(" * Email Required");

			 		}else if(object.result.erremail=='invalid'){
			 		
			 			$("#eremail").html(" * Invalid format :: Example@email.com ");
			 		
			 		}else{
			 			f4 = 1;
			 			$("#eremail").html("");

			 		}
			 		
			 		if(object.result.errtele=='invalid'){
			 		
			 			$("#ertel").html(" * Invalid format :: XXX-XXX-XXXX or XXXXXXXXXX");
			 		
			 		}else{
			 			f5 = 1;
			 			$("#ertel").html("");

			 		}
			 		
			 		
			 		//librarian flag is unset by default and valid by default
			 		//user is by default a non librarian
					
			 		f6 = 1;
			 		
					
			 		//checks for invalid or missing first name
					if(object.result.errfname=='missing'){
			 			
			 			$("#erfname").html(" * First Name Required");

			 		}else if(object.result.errfname=='invalid'){
			 		
			 			$("#erfname").html(" * Invalid format :: Alphanumeric only ");
			 		
			 		}else{
			 			f7 = 1;
			 			$("#erfname").html("");

			 		}
			 		
			 		//checks for invalid or missing last name
					if(object.result.errlname=='missing'){
			 			
			 			$("#erlname").html(" * Last Name Required");

			 		}else if(object.result.errlname=='invalid'){
			 		
			 			$("#erlname").html(" * Invalid format :: Alphanumeric only ");
			 		
			 		}else{
			 			f8 = 1;
			 			$("#erlname").html("");

			 		}
			 		
			 		//if all feild flags are valid completion is acknoledged.
			 		if((f1==1)&&(f2==1)&&(f3==1)&&(f4==1)&&(f5==1)&&(f6==1)&&(f7==1)&&(f8==1)){
			 			
			 			$("#regdiv").hide();
			 			alert("Registration Complete :: Please Login.");
			 			$("#runame").val("");
			 			$("#rpass").val("");
			 			$("#rcpass").val("");
			 			$("#remail").val("");
			 			$("#rtel").val("");
			 			$("#rfname").val("");
			 			$("#rlname").val("");
			 		
			 			$("#eruname").html("");
			 			$("#erupass").html("");
			 			$("#ercpass").html("");
			 			$("#eremail").html("");
			 			$("#ertel").html("");
			 			$("#erfname").html("");
			 			$("#erlname").html("");

			 			
			 		}
			 		
			 	});
		});
	
	btn4.click (function () {

		window.location.href = "conn.php";
			
	});
	
	btn5.click (function () {

		$("#regdiv").hide();
		$("#runame").val("");
		$("#rpass").val("");
		$("#rcpass").val("");
		$("#remail").val("");
		$("#rtel").val("");
		$("#rfname").val("");
		$("#rlname").val("");
		
		$("#eruname").html("");
		$("#erupass").html("");
		$("#ercpass").html("");
		$("#eremail").html("");
		$("#ertel").html("");
		$("#erfname").html("");
		$("#erlname").html("");

	});

});
