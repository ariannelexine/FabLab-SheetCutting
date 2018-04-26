<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
 //This will import all of the CSS and HTML code nessary to build the basic page
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
?>
<title><?php echo $sv['site_name'];?> Base</title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">New Inventory </h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">
                    <i class="fas fa-cubes fa-lg"></i> Add new Inventory
                    <a type="button" style="margin-top:-7px;margin-right:-12px;" class="btn btn-info btn-md pull-right" href="http://fabapp/sheetcutting/webpage_inventory.php"> 
                    View Inventory
                    </a>
            </div>
                <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                        <form id = "iform">
                        <tr id="newInventory" class="tablerow">
                        <td>
                        <b>Select Type:</b>
                            <select name="typeSelect" id="typeSelect" style="margin-right:12px;" onchange="getSheetInfo()">
                            <option disabled hidden selected value="">Sheet</option>
                                <?php if($result = $mysqli->query("
                                        SELECT *
                                        FROM `sheet_type`;
                                ")){
                                        while($row = $result->fetch_assoc()){
                                                echo("<option value='$row[type_id]'>$row[type]</option>");
                                        }
                                }?>
                            </select>
                            <b>Select Variant:</b> 
                            <select name="variant" id="variantSelect" style="margin-right:12px;">
                                <option disabled hidden selected value="">Variant</option>
                            </select>
                            <b>Select Size:</b> 
                            <select name="size" id="sizeSelect" style="margin-right:12px;">
                                <option disabled hidden selected value="">Size</option>
                            </select>
                            <b>Amount:</b>
                            <input type="number" id="addAmount" value="" style="width: 60px; margin-right:12px;" id="amount" />
                        </td>
                        </form>
                        </tr>
                        <tr id="buttons">
                            <td>
                                <button onclick="Cancel();" class="btn btn-danger btn-md pull-right" >Cancel</button>
                                <button onclick="AddInventory()" class="btn btn-success btn-md pull-right" style="margin-right:8px;"><span class="glyphicon glyphicon-ok"></span> Add to Inventory</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id = "alert_placeholder"></div>
            </div>
        </div>
    </div>

<script>
var getSheetInfo = function() {
    var params = "sheet_type=" + document.getElementById("typeSelect").value;
    callPHP('ajax_getSheetInfo.php', params, function(response){
        var response_split = response.split("cuts");
       
        var variant_list = document.getElementById("variantSelect");
        variant_list.innerHTML = response_split[0];
        
        var variant_list = document.getElementById("sizeSelect");
        variant_list.innerHTML = response_split[1];
	});
}

var AddInventory = function() {
        var variant = document.getElementById("variantSelect");
        var cut = document.getElementById("sizeSelect");
		var amount = document.getElementById("addAmount");
        var type = document.getElementById("typeSelect");

		var params = "variantid=" + variant.value + "&cutid=" + cut.value + "&amount=" + amount.value;
		
		callPHP('ajax_addNewInventory.php', params, function(response){
            if(response != 0) {
                var msg = "Successfully added " + response + " '" + cut.options[cut.selectedIndex].text + " " + variant.options[variant.selectedIndex].text + " " + type.options[type.selectedIndex].text + "' sheets.";
                $('#alert_placeholder').append('<div id="alertdiv" class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + msg + '</div>')
                resetFields();
            }
            else {
                $('#alert_placeholder').append('<div id="alertdanger" class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Failed to add new inventory.</div>')
                setTimeout(function() { // this will automatically close the alert and remove this if the users doesnt close it in 3 secs
                $("#alertdanger").fadeOut();
                }, 3000);
            }
		});
}

var Cancel = function() {
    resetFields();
}

var resetFields = function() {
    document.getElementById("iform").reset();
                document.getElementById("variantSelect").innerHTML = '<option disabled hidden selected value="">Variant</option>';
                document.getElementById("sizeSelect").innerHTML = '<option disabled hidden selected value="">Size</option>';
}

// I'm not sure how jon wants us to call php functions, so this is just temporary.
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

</script>
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>