	// list of markers on the map
	var markers = [];
	var disableWaitAjax=false;

	// init html editor (for posting)
	CKEDITOR.replace('postbody');


	//object for interoperation with google maps api js
	var myData; 
	var map;
	var yourPos; 
	var myLatLng = null;
	function initMap() { //callback function (called when coords are ready)
		  map = new google.maps.Map(document.getElementById('bgmap'), {
		center:	{lat: yourPos.coords.latitude, lng: yourPos.coords.longitude},
			    zoom: 6
	  });
		myLatLng =  {lat: yourPos.coords.latitude, lng: yourPos.coords.longitude};	
	   if (document.getElementById("lat")!=null) { 
		$("#lat").text(Math.round(parseFloat(myLatLng.lat)*100000)/100000) ;
                $("#lng").text(Math.round(parseFloat(myLatLng.lng)*100000)/100000);
	    }
	
	}
	// service function for gathering coordinates
	function getLocation()
	{
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
		       alert("Geolocation is not supported by this browser.");
		}
		if (document.getElementById("lat")!=null) {
			$("#lat").text('NA');
	  	        $("#lng").text('NA');
		}
	}

	//callback function called by browser when coordinates are ready
	function showPosition(position) {
		yourPos = position; //store current coords
		initMap();		// initizialize google maps
		getData();		// gathering data close to current position
	}		


	// open post module
	function newpost()
	{
		 $("#post").css("visibility","visible");
		 $("#post").css("position","relative");
	}
	// close post module and reset field
	function closePost()
	{
		if (!confirm("All data will be lost. Continue?")) return;
		_cPost();
	}
	function _cPost()
	{
		 $("#post").css("visibility","hidden");
		 $("#post").css("position","fixed");
	}
	// service function: call this when you want to update data close to your position
	function updateData()
	{
		_cPost();
		getData();
	}

	// service function: call this when you want to publish new item in knowleddge
	function savePost()
	{

		var lat=$("#lat").text();
		var lng=$("#lng").text();
		var avatar=$("#photo2p").attr("src");
		var postbody=CKEDITOR.instances.postbody.getData();
		$.ajax({
                        type: 'POST',
                        dataType: "json",
                        data: {
				postbody:postbody,
				lat:lat,
				lng:lng,
				avatar:avatar,
				subf:"post"
                        },
			url: "http://169.44.65.209/core/srv/post.php",
			success: function (responseData, textStatus, jqXHR) {
				if (responseData["res"]!=1)
				{
					alert('An error occurred');
					return;
				}

					updateData();
					$("<div>A new piece of knowledge was loaded.<br/>Thank you!</div>").dialog();

				
                        },

                        error: function (responseData, textStatus, errorThrown) {
                        }
		});

	}


	// service function: this function publish your current location and SID
	// (consider SID as your unique ID in system) in order to enable you to 
	// chat with other entitiy near to your location.
	function pushCoords()
	{
		var lat=$("#lat").text();
		var lng=$("#lng").text();
			var d =$("#distfromyou").val();
		
		if ($("#sid")==null) return;
		var sid=$("#sid").val();
		if (sid==null)
			return;

		$("#sid").attr("readonly","readonly");
		$("#sid").attr("enabled","false");
		
		setTimeout('pushCoords()',3000);
		disableWaitAjax = true;

		$.ajax({
				type:'POST',
				dataType:"json",
				data: {
					subf:"pingchat",
					lat:lat,
					sid:sid,
					d:d,
					lng:lng
				},
				url : "http://169.44.65.209/core/srv/post.php",
				success: function (responseData,textStatus,jqXHR) {
					$("#chatroom").html("");
					for (k in responseData["data"])
					{
						$("#chatroom").append("<p><img src='http://www.free-icons-download.net/images/anonymous-icon-16523.png' style='width:16px;'/>"+k+"</p>");
					}
				},
				error: function(responseData,textStatus,errorThrown)
				{
				}
			});
		disableWaitAjax=false;


	}


	// service function: this functoin interact with Knowledge in order to retreive
	// item data closed to your position. Do not call this function directly but use 
	// updateData instead!
	function getData()
	{



			//remove markers 
			 for (var i = 0; i < markers.length; i++) {
				    markers[i].setMap(null);
			  }



			// first get hot theme near user 
			var d =$("#distfromyou").val();
			var lat=$("#lat").text();
			var lng=$("#lng").text();
			$.ajax({
				type:'POST',
				dataType:"json",
				data: {
					subf:"hotThemeNear",
					lat:lat,
					d:d,
					lng:lng
				},
				url : "http://169.44.65.209/core/srv/post.php",
				success: function (responseData,textStatus,jqXHR) {
					$("#hottheme").html('');


									//reset hotthemes
					var ht = responseData["hottheme"];
					i = 0;
					for (it in ht)
					{
						if (it.length<3) continue;
						$("#hottheme").append("<div class='hotitem'>"+it+"</div>");				
						if (i==8) break;
						i+=1;
					}


					//show post on map
					var postNum = responseData['data'].length;

					myData= responseData['data'];

					 var infowindow = new google.maps.InfoWindow({
					    content: ""
					  });

					
					$("#posts").html("");

						for (i=0;i<postNum;i++)
						{

 						  var markerIcon = "https://www.nicb.org/images/HotSpots/mapMarkerSmall.png";
			 			var postIcon = "http://www.free-icons-download.net/images/anonymous-icon-16523.png";

						 if (myData[i]['avatar']!=null) {
							markerIcon = myData[i]['avatar'];
							postIcon = markerIcon;
							}

						 $("#posts").append("<div><div class='pbody'><strong>"+myData[i]['dtc15']+" "+ myData[i]['orc15']+"</strong><br/><img class='pavataricon' src='"+postIcon+"'/>"+myData[i]['body']+"</div></div>");

		
						  var markPos = {lat:parseFloat(myData[i]['lat']),lng:parseFloat(myData[i]['lng'])};
							image = markerIcon;
							  var marker = new google.maps.Marker({
							    map: map,
							    position: markPos,
								icon:image,
							    title:"k" 
							  });
				 			  markers.push(marker);


	 google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
        return function() {
          infowindow.setContent(myData[i]['body']);
          infowindow.open(map, marker);
        }
      })(marker, i));



						}

				},
				error: function(responseData,textStatus,errorThrown) {
				}
		});
	}




// Service function for image embeddending (data64 format for now)
$("#photo2").change(function() {
	var file =$("#photo2")[0].files[0];
	var reader  = new FileReader();
	 reader.addEventListener("load", function () {
		var img = document.createElement("img");
		img.addEventListener("load", function() {
			var canvas = document.createElement("canvas");
			var ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0);
			var MAX_WIDTH = 32;
			var MAX_HEIGHT = 32;
			var width = img.width;
			var height = img.height;
			if (width > height) {
			  if (width > MAX_WIDTH) {

			    height *= MAX_WIDTH / width;

			    width = MAX_WIDTH;

			  }

			} else {

			  if (height > MAX_HEIGHT) {

			    width *= MAX_HEIGHT / height;

			    height = MAX_HEIGHT;

			  }

			}

			canvas.width = width;

			canvas.height = height;

			var ctx = canvas.getContext("2d");

			ctx.drawImage(img, 0, 0, width, height);

			var dataurl = canvas.toDataURL("image/jpeg,0.5");

			$("#photo2p").attr("src",dataurl);



		},false);

		img.src=reader.result;

	  }, false);



	reader.readAsDataURL(file);





    });








		$("#photo3").change(function() {
		var file =$("#photo3")[0].files[0];
		var reader  = new FileReader();
		 reader.addEventListener("load", function () {
		var img = document.createElement("img");
		img.addEventListener("load", function() {
			var canvas = document.createElement("canvas");
			var ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0);
			var MAX_WIDTH = 320;
			var MAX_HEIGHT = 240;
			var width = img.width;
			var height = img.height;
			if (width > height) {
			  if (width > MAX_WIDTH) {

			    height *= MAX_WIDTH / width;

			    width = MAX_WIDTH;

			  }

			} else {

			  if (height > MAX_HEIGHT) {

			    width *= MAX_HEIGHT / height;

			    height = MAX_HEIGHT;

			  }

			}
			canvas.width = width;
			canvas.height = height;
			var ctx = canvas.getContext("2d");
			ctx.drawImage(img, 0, 0, width, height);
			var dataurl = canvas.toDataURL("image/jpeg,0.6");
			CKEDITOR.instances.postbody.insertHtml("<img style='float:left;margin-right:10px;margin-bottom:10px;max-width:200px;' src='"+dataurl+"'/>");
		},false);
		img.src=reader.result;
	  }, false);
	reader.readAsDataURL(file);
    });


