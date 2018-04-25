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
							<tr id="inventory0">
                            <td>
                            <b>Select Type:</b>
                                <select name="typeSelect" id="typeSelect0" style="margin-right:12px;" onchange="getSheetInfo(0)">
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
                                <select name="variant" id="variantSelect0" style="margin-right:12px;">
                                    <option disabled hidden selected value="">Variant</option>
                                </select>
                                <b>Select Size:</b> 
                                <select name="size" id="sizeSelect0" style="margin-right:12px;">
                                    <option disabled hidden selected value="">Size</option>
                                </select>
                                <b>Amount:</b>
                                <input type="number" id="addAmount0" value="" style="sheet: 60px; margin-right:12px;" id="amount" />
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
var lastID = 0;
var id_reference = [];

var getSheetInfo = function(id) {
    var params = "sheet_type=" + document.getElementById("typeSelect" + id).value;
    callPHP('ajax_getSheetInfo.php', params, function(response){
        var response_split = response.split("cuts");
       
        var variant_list = document.getElementById("variantSelect" + id);
        variant_list.innerHTML = response_split[0];
        
        var variant_list = document.getElementById("sizeSelect" + id);
        variant_list.innerHTML = response_split[1];
	});
}

var AddMoreInventory = function() {
        var id = ++lastID;
        var tableRow = document.createElement("tr");
		tableRow.id = "inventory" + (id);
		id_reference.push(tableRow.id);
		tableRow.style = "height:100px;";
		var tableEntry = document.createElement("td");
		tableRow.appendChild(tableEntry);

        var sheet_name = document.createElement("b");
		sheet_name.innerHTML = "Sheet Type: ";
        var sheet_select = document.createElement("SELECT");
        sheet_select.id = "typeSelect" + id;
        var option = document.createElement("option");
        option.text = "Sheet";
        option.selected = "true";
        option.value = "";
        option.disabled = "disabled";
        option.hidden = "true";
        sheet_select.add(option);

        <?php if($result = $mysqli->query("
                SELECT *
                FROM `sheet_type`;
        ")){
                while($row = $result->fetch_assoc()){
                        echo("var x = document.createElement('option');
                             x.value ='$row[type_id]';
                             x.text = '$row[type]';
                             sheet_select.add(x);");
                }
        }?>

        var variant_name = document.createElement("b");
		variant_name.innerHTML = "Select Variant: ";
        var variant_select = document.createElement("SELECT");
        variant_select.id = "variantSelect" + id;
        var option = document.createElement("option");
        option.text = "Variant";
        option.selected = "true";
        option.value = "";
        option.disabled = "disabled";
        option.hidden = "true";
        variant_select.add(option);

        var size_name = document.createElement("b");
		size_name.innerHTML = "Select Size: ";
        var size_select = document.createElement("SELECT");
        size_select.id = "sizeSelect" + id;
        var option = document.createElement("option");
        option.text = "Size";
        option.selected = "true";
        option.value = "";
        option.disabled = "disabled";
        option.hidden = "true";
        size_select.add(option);
        var amount_name = document.createElement("b");
        amount_name.innerHTML = "Amount: ";
        var amount_textbox = document.createElement("input");
		amount_textbox.style = "margin-left:4px;";
		amount_textbox.id = "amountTextBox" + id;
        
        sheet_select.onchange = function() { getSheetInfo(id); }

        tableEntry.appendChild(sheet_name);
        tableEntry.appendChild(sheet_select);
        tableEntry.appendChild(variant_name);
        tableEntry.appendChild(variant_select);
        tableEntry.appendChild(size_name);
        tableEntry.appendChild(size_select);
        tableEntry.appendChild(amount_name);
        tableEntry.appendChild(amount_textbox);
	
		var e = document.getElementById("addMoreInventory");
		e.parentNode.insertBefore(tableRow, e);
        console.log(id_reference);
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

var DeleteHTMLElement = function(array, id) {
    var e = document.getElementById(id);
    e.parentNode.removeChild(e);
    var index = array.indexOf(id);
    if (index > -1) {
        array.splice(index, 1);
        console.log(array);
    }
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