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
                </div>
                <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
						<tbody>
							<tr id="newInventory">
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
							</tr>
                            <tr id="addMoreInventory">
								<td>
									<button onclick="AddMoreInventory()" class="btn btn-warning btn-md">Add Another Sheet</button>
								</td>
							</tr>
                            <tr id="buttons">
								<td>
									<button onclick="Cancel();" class="btn btn-danger btn-md pull-right" >Cancel</button>
                                    <button onclick="AddInventory()" class="btn btn-success btn-md pull-right" style="margin-right:8px;">Add to Inventory</button>
								</td>
							</tr>
						</tbody>
					</table>
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
        var variantid = document.getElementById("variantSelect").value;
        var cutid = document.getElementById("sizeSelect").value;
		var amount = document.getElementById("addAmount").value;

		var params = "variantid=" + variantid + "&cutid=" + cutid + "&amount=" + amount;
		
		callPHP('ajax_addNewInventory.php', params, function(response){
			alert(response);
		});
}

var Cancel = function() {
    window.history.back();
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