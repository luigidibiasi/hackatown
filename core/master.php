<?php
	include_once("dbms.php");
?>



<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

		<link href='https://fonts.googleapis.com/css?family=Kreon' rel='stylesheet' type='text/css'>
		<link href="../core/master.css" rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<div id="head1">
					<div class="h1item">
						<img onclick="newpost();" id="hlogo" src="logo.png"/>

					</div>
						<input onclick="newpost();" class="button" type="button" value="Post a news" style="float:right;margin-left:10px;"/> 
 						<input onclick="location.href='reviewer.php'" class="button" type="button" value="For Hackhaton reviewer... click here" style="color:white;background-color:green;float:right;margin-left:10px;"/>  


					<div class="h1item">
					</div>
				</div>
				<div id="post">
				 Your avatar: <input id="photo2" type="file">
				 <br/>
				 <img src="" id="photo2p"/>
				 <br/>
				 Insert image: <input id="photo3" type="file"> 
					<textarea id="postbody"></textarea>
				 <div style="text-align:right">
					Post coords: lat <span id="lat"></span> lng <span id="lng"></span>
				        <input onclick="closePost()" class="button" type="button" value="Close" style="margin-right:10px;"/>
				        <input onclick="savePost();" class="button" type="button" value="Post" style="margin-right:10px;"/>
			        </div>

				</div>
				<div><img src="http://www.creative-imobiliare.ro/templates/bootstrap2-responsive/assets/img/icons/option_id/87.png"/> Hot themes near <select onchange="updateData()" id="distfromyou"><option value="10">10 Km</option><option value="100">100 Km</option><option value="2000">2000 Km</option><option value="5000">5000 Km</option><option value="1000000">All world</option></select> you</div>
				<div id="hottheme">
					
				</div>

				<div id="mapchat">
				<div id="bgmap" style="display:inline-block;width:70%;">
				</div>
				<div id="chat" style="display:inline-block;width:25%;vertical-align:top;">
					<h3>Chat with nearest people</h3>
					<div>Your nick: <input id="sid" type=text" style="width:100px;"/> <input type="button" onclick="pushCoords()" value="join"/></div>
					<h4>Peoples in chat:</h4>
					<div id="chatroom">
					</div>
				</div>
				</div>
			</div>
			<img src="http://cdn.mysitemyway.com/etc-mysitemyway/icons/legacy-previews/icons-256/green-jelly-icons-people-things/063495-green-jelly-icon-people-things-eye.png" style="width:16px;"/> What's happening near you?
			<div id="posts">
			</div>
			<!-- if not full screen page -->
			<script src="//cdn.ckeditor.com/4.5.7/full/ckeditor.js"></script>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMU8dH03GN691XmeNB7XGHxEc5euMCUuQ&callback=getLocation"> </script>
			<script src="../core/master.js">			</script>

		</div>	


  <div class="modal"><!-- Place at bottom of page -->
                <div style="text-align:center;">
                </div>
        </div>


 <style>
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 )
                url('http://i.stack.imgur.com/FhHRx.gif')
                50% 50%
                no-repeat;
}
body.loading {
    overflow: hidden;
}
body.loading .modal {
    display: block;
}
</style>

<script>
$(document).on({
    ajaxStart: function() { if(disableWaitAjax) return; $("body").addClass("loading");    },
     ajaxStop: function() { if(disableWaitAjax) return; $("body").removeClass("loading"); }
});

</script>

	</body>
</html>
