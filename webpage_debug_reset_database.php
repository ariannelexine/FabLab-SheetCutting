<!DOCTYPE html>
<html>
<style>
html, body {
	height: 100%;
	overflow: hidden;
}
.right_panel {
	float:left;
	width:84%;
	height:80%;
	overflow:auto;
	margin: 2px;
}
<?php include 'ui_buttons_style.php' ?> 
</style>
<script> 
// Javascript code
function callPHP(url, params, callback_function) {
    var post = new XMLHttpRequest();
    post.open("POST", url);

    post.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
    post.onreadystatechange = function() { 
		if(post.readyState == 4 && post.status == 200) {
			callback_function(post.responseText);
        }
    }
    post.send(params);
}

function resetDatabase() {
	callPHP("ajax_debug_reset_database.php", 0, function(responseText) {
		var button = document.getElementById("reset_button");
		var header = document.getElementById("reset_header");
		button.style.display = 'none'; // hide button.
		header.innerHTML = 'The database has been reset.';
	});
}
</script>
<body>

<?php include 'ui_titlebar.php' ?> 
<?php include 'ui_buttons.php' ?> 

<div class="right_panel">
<h1 id="reset_header">Reset the database?</h1>
<a id="reset_button" href="javascript:resetDatabase()" id="save_button" class="ui_button ui_close_button" style="width:24%;margin-top:8px;">Yes, reset everything.</a>
</div>
</body>
</html>