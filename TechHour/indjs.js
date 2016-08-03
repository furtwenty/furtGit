$(document).ready(function(){
			
			/*
			var btn = $("#npost");
			var btn2 = $("#nbsub");
			var btn3 = $("#logout");
			
			btn.click(
			function(){
	
				$("#dlog").show();
				$("#btitle").val("");
				$("#bsubject").val("");
				$("#blog").val("");
				$("#indx").val("");
			}); */


	(function(){

		$.ajax({
		    type: "POST",
		    dataType: 'html',
		    url: "./php/indcnt.php",
		    success: function (data) {
		    	$( "#cntdiv" ).html( 
		    		'<label id="lbl" class="label label-info"> Page Visits: '+data+'</label>'
				);			 		
		    }
		});

		var check = streamCheck();


		var value = window.setInterval(streamCheck,60000);

		var isOnline = false;

		function streamCheck(){

			$.getJSON("https://api.twitch.tv/kraken/streams/furtwenty?callback=?").done(function(data) {
		    	if(data.stream) {

		    		

		    		console.log(data);

		    		var game = data.stream.game;
		    		var view = data.stream.viewers;
		    		var tit = data.stream.channel.status;
		    		
		    		if(isOnline == false){
		    			isOnline = true;
		        		online(tit,view,game);
		        	}

		    	} else {
		    		isOnline = false;
		        	offline();
		    	}
			});

		}

		function online(title, views, game){

			document.getElementById("on-ind").innerHTML = "<span class='label label-success'>Online</span>";
			document.getElementById("on-game").innerHTML = "<span class='label label-default'>Game : "+game+"</span>";
			document.getElementById("on-views").innerHTML = "<span class='label label-default'>Title : "+title+"</span>";
			document.getElementById("on-tit").innerHTML = "<span class='label label-default'>Viewers : "+views+"</span>";
			//document.getElementById("on-chat").innerHTML = '';

			document.getElementById("on-vid").innerHTML = '<iframe scrolling="no" id="chat_embed" src="https://player.twitch.tv/?channel=furtwenty" height="900" width="1600"></iframe>';

			/*
			//object containing stream info
			var options = {
				width: 1600,
    			height: 900,
		        channel: "furtwenty", 
		        playsinline : true
		        //video: "{VIDEO_ID}"       
			};
			
			player = new Twitch.Player("on-vid", options);
			player.setVolume(0.5);
			*/
		}


		function offline(){

			document.getElementById("on-ind").innerHTML = "<span class='label label-danger'>Offline</span>";
			document.getElementById("on-tit").innerHTML = "<span class='label label-default'>Not Streaming</span>";
			document.getElementById("on-vid").innerHTML = "<span class='label label-default'>No Viewers</span>";
			document.getElementById("on-vid").innerHTML = "";




		}

	})();
	
});			
			
