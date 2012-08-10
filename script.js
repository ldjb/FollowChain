step_one = true;

var xmlhttp = new XMLHttpRequest();

function generateBoxes() {
	document.getElementById("userbox-wrapper").innerHTML = "";
	document.getElementById("tweet-text").innerHTML = "";
	step_one = true;
	current_screen_name = document.getElementById("screen_name_input").value;
	newUserbox();
	setInterval(function() {newUserbox();} , 5000);
}

function newUserbox() {

if (step_one == true) {
	xmlhttp.open("GET","lookup.php?screen_name="+current_screen_name,true);
}
else {
	xmlhttp.open("GET","ajax.php?screen_name="+current_screen_name,true);
}
xmlhttp.send();
xmlhttp.onreadystatechange=function() {
if (xmlhttp.readyState==4 && xmlhttp.status==200) {

	var response = xmlhttp.responseText;
	
	if (response == "Error: Cannot connect to Twitter API") {
		document.getElementById("tweet-text").innerHTML = response;
	}
	
	var obj = jQuery.parseJSON(response);
	document.getElementById("userbox-wrapper").innerHTML = document.getElementById("userbox-wrapper").innerHTML + '<div class="userbox" style="background-image: url(\'' + obj.profile_image_url + '\');" title="'+ obj.screen_name +'"></div>';
	document.getElementById("tweet-text").innerHTML = "<strong>" + obj.screen_name + ":</strong> " + obj.tweet;
	document.getElementById("userbox-wrapper").scrollTop = document.getElementById("userbox-wrapper").scrollHeight;
	
	current_screen_name = obj.screen_name;
	step_one = false;
}
}
}