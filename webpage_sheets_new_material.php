<!DOCTYPE html>
<html>
<style>
html, body {
	height: 100%;
	min-width:1000px;
	overflow: hidden;
}
.right_panel {
	float:left;
	width:84%;
	min-width:100px;
	height:80%;
	overflow:auto;
	margin: 2px;
	text-align:center;
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

function updateCutListRadioState() {
	var radio_new = document.getElementById("radio_option_new");
	var radio_content = document.getElementById("radioContent");
	
	if(radio_new.checked) {
		radioContent.innerHTML = '<br/><br/><i style="font-size:14px;">(Use comma "," to separate entries, dollar sign "$" is optional, all whitespace is ignored)</i><br/><textarea type="text" rows="4" cols="80" placeholder="32x20:$40, 20x20:$30, 10x10:$15, etc."></textarea>';
	} else {
		// temporary, just for show in the inception 1 presentation.
		radioContent.innerHTML = '<br/><br/><select style="font-size:14px;"><option>Glass (32x20:$50, 20x20:$40, 20x15:$35, 20x10:$30, 10x15:$25, ...</option></select>';
	}
}
</script>
<body>

<?php include 'ui_titlebar.php' ?> 
<?php include 'ui_buttons.php' ?> 

<div class="right_panel">
	<h2 id="sheet_inv_header" style="margin-top:0px;min-width:10px;">New Material</h2>
	<div>
		<b>Name: </b>
		<input type="text" style="width:250px;min-width:10px;" placeholder="Material Name" />
	</div>
	<br/>
	<div>
		<b style="font-size:20px;">Variants:</b>
		<br/>
		<i style="font-size:14px;">(Use comma "," to separate entries, all whitespace is ignored)</i>
		<br/>
		<textarea type="text" rows="4" cols="80" placeholder="Thick, Thin, Red, Blue, etc."></textarea>
	</div>
	<br/>
	<div>
		<b style="font-size:20px;">Cut list:</b>
		<br/>
		<form>
			<input name="cutlist" type="radio" id="radio_option_new" checked="true" onchange="updateCutListRadioState()"/>
			<label>Make a new cut list</label>
			<input name="cutlist" type="radio" id="radio_option_use_old" onchange="updateCutListRadioState()"/>
			<label>Use existing cut list from another material</label>
			<span id="radioContent"></span>
			<script>
				updateCutListRadioState();
			</script>
		</form>
	</div>
</div>
</body>
</html>