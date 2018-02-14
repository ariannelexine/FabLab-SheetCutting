<!DOCTYPE html>
<html>
<style>
html, body {
	height: 100%;
	overflow: hidden;
}
.left_panel {
	float:left;
	width:15%;
	height:80%;
	border-style:solid;
	border-width:1px;
	margin-right:2px;
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

function callPHP(url, params) {
    var post = new XMLHttpRequest();
    post.open("POST", url);

    post.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
    post.onreadystatechange = function() { 
		if(post.readyState == 4 && post.status == 200) {
			alert(post.responseText);
        }
    }
    post.send(params);
}
</script>
<body>
<div style="height:18%"> 
	<?php include 'ui_titlebar.php' ?> 
</div>
<div class="left_panel">
	<?php include 'ui_buttons.php' ?> 
</div>
<div class="right_panel">

<?php
include 'functions_util.php';

session_start();
$this_page_id = 'newMaterial';

if(isset($_SESSION['page'])){
	if($_SESSION['page'] != $this_page_id) {
		session_unset(); // clear out all variables in session.
		$_SESSION['page'] = $this_page_id;
		$_SESSION['subpage'] = 0;
	}
} else {
	$_SESSION['page'] = $this_page_id;
	$_SESSION['subpage'] = 0;
}

$_SESSION['test'] = 'Hello world!';
echo '<input id="clickMe" type="button" value="clickme" onclick="callPHP(\'ajax_post_to_session.php\', \'{WHATWHAT}\');"/>';
?>
</div>
</body>
</html>