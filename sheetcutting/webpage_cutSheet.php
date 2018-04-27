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
            <h1 class="page-header">Make a cut</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-cubes fa-lg"></i> Sheet cutting
                </div>
				<div class="panel-body">
					<b>Material: </b>
					<select id="sheet_type_list" onchange="makeVariantsAndCutSizesSelects()">
					<?php if ($result = $mysqli->query("
                            SELECT DISTINCT type from sheet_type
                        ")){
                            while ( $row = $result->fetch_assoc() ) { 
								echo '<option value="' . $row["type"] . '">' .  $row["type"] . '</option>'; 
							}
						} ?>
					</select>
					<span id="sheetSellingElements" style="margin-top:10px;"/>
				</div>
			</div>
		</div>
        <!-- /.col-md-8 -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-cubes fa-lg"></i> Inventory
                </div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" >
					<thead>
						<tr class="tablerow">
							<th>Size</td>
							<th>Price</td>
							<th>Stock</th>
						</tr>
					</thead>
					<tbody id="inventory_table_body">
					</tbody>
					</table>
				</div>
			</div>
		</div>
		
        <!-- /.col-md-4 -->
	</div>
</div>

<script type="text/javascript" charset="utf-8">

function createDropDownList(id, str_array, onchange){
	var list = document.createElement("select");
	list.style = "margin-right:4px";
	list.onchange = onchange;
	list.id = id;
	for(var i = 0; i < str_array.length; i++) {
		var option = document.createElement("option");
		option.value = str_array[i];
		option.innerHTML = str_array[i];
		list.appendChild(option);
	}
	return list;
}

function createLabel(label) {
	var label_elem = document.createElement("b");
	label_elem.innerHTML = label;
	return label_elem;
}

function createFancyLabel(label, style, className) {
	var label_elem = document.createElement("b");
	label_elem.innerHTML = label;
	label_elem.style = style;
	label_elem.className = className;
	return label_elem;
}

function makeVariantsAndCutSizesSelects(){
	var table_body = document.getElementById('inventory_table_body');
	table_body.innerHTML = ""; // clear table
	var elements_div = document.getElementById('sheetSellingElements');
	elements_div.innerHTML = ''; // clear sheetSellingElements element
	var sheet_type = document.getElementById('sheet_type_list');
	var params = "sheet_name=" + sheet_type.value;
	
	callPHP('ajax_getVariantsAndCutSizes.php', params, function(response){
		//console.log(response);
		var data = JSON.parse(response);
		var variants = data[0];
		var cut_sizes = data[1];
		elements_div.appendChild(createLabel("Variant: "));
		elements_div.appendChild(createDropDownList('name_list', variants, function(){ updateStock(); }));
		elements_div.appendChild(createLabel("Cut Size: "));
		elements_div.appendChild(createDropDownList('size_list', cut_sizes, function(){ updateStock(); }));
		elements_div.appendChild(document.createElement("br")); // new line
		
		var stock_and_price = document.createElement("div");
		stock_and_price.id = "stock_and_price";
		stock_and_price.style = "margin-top:10px;";
		elements_div.appendChild(stock_and_price);
		updateStock();
	});
	
	//makeSheetSellingElements();
}

function makeAssociatedArrayWithStockData(data){
	var dictionary = {};
	var stock = data[0];
	var price_and_cutid = data[1];
	
	for(var i = 0; i < price_and_cutid.length; i++) {
		var size = price_and_cutid[i][0] + "x" + price_and_cutid[i][1];
		dictionary[size] = { cut_id : price_and_cutid[i][2], size: size, price : price_and_cutid[i][3], stock : 0 };
	}
	
	for(var i = 0; i < stock.length; i++) {
		var size = stock[i][0] + "x" + stock[i][1];
		dictionary[size].stock = stock[i][2];
	}
	
	return dictionary;
}

function updateInventoryPanel(arr){
	var table_body = document.getElementById('inventory_table_body');
	table_body.innerHTML = ""; // clear table
	
	for(var key in arr){
		table_body.innerHTML += 
		"<tr>" +
		"<td>" + key + "</td>" +
		"<td>$" + arr[key].price + "</td>" +
		"<td>" + arr[key].stock + "</td>" +
		"</tr>";
	}
}

function updateStock() {
	console.log("Update stock!");
	var stock_and_price = document.getElementById('stock_and_price');
	stock_and_price.innerHTML = ""; // clear stock_and_price element
	var cut_info = document.getElementById('cut_info_table');
	if(cut_info != undefined) {
		cut_info.parentNode.removeChild(cut_info); // remove cut_info_table div if it already exists.
	}
	
	var sheet_type = document.getElementById('sheet_type_list');
	var name = document.getElementById('name_list');
	var name_string = name.value.substring(0, name.value.indexOf(" ("));
	var size = document.getElementById('size_list').value;
	var params = "variant_name="+name_string+"&sheet_type="+sheet_type.value;
	//console.log(params);
	callPHP('ajax_getInventoryStock.php', params, function(response){
		//console.log(response);
		var data = JSON.parse(response);
		var inv_data = makeAssociatedArrayWithStockData(data);
		updateInventoryPanel(inv_data);
		
		
		var button_for_buy = document.createElement("div");
		button_for_buy.id="button_for_buy";
		stock_and_price.appendChild(button_for_buy);
		makeSaleButton(inv_data, size);
		
		/*
		var count_label = document.createElement("p");
		var split_response = response.split(",")
		count_label.innerHTML = "Stock: "+split_response[0]+", price = $"+split_response[1];
		stock_and_price.appendChild(count_label);
		var button_for_buy = document.createElement("div");
		button_for_buy.id="button_for_buy";
		stock_and_price.appendChild(button_for_buy);
		makeSaleButton(split_response[0], split_response[1], split_response[2]);
		*/
	});
}

function makeSaleButton(inv_data, size) {
	var button_for_buy = document.getElementById('button_for_buy');
	var buyButton = document.createElement("button");
	buyButton.style = "margin-left:8px;";
	if(inv_data[size].stock > 0) {
		var info = document.createElement("div");
		info.style = "padding-top:10px";
		buyButton.className = "btn btn-success btn-md";
		buyButton.innerHTML = "Sell sheet";
		buyButton.onclick = function() { alert("SOLD!"); }
		info.appendChild(buyButton);
		button_for_buy.appendChild(info);
	} else {
		//buyButton.className = "btn btn-info btn-md";
		//buyButton.innerHTML = "See Cuts";
		//buyButton.onclick = function() {
			var sheet_type = document.getElementById('sheet_type_list');
			var name = document.getElementById('name_list');
			var name_string = name.value.substring(0, name.value.indexOf(" ("));
			var name_id = name.value.substring(name.value.indexOf(" (")+2, name.value.indexOf(" (")+6);
			//console.log(name_id + "," + name_string);
			var width_height = size.split("x");
			var params = "name="+name_string+"&variant_id="+name_id+
			"&sheet_type="+sheet_type.value+"&width="+width_height[0]+"&height="+width_height[1]+
			"&count="+inv_data[size].stock+"&price="+inv_data[size].price+"&cut_id="+inv_data[size].cut_id;
			//console.log(params);
			callPHP('ajax_getCuts.php', params, function(response){
				showCutTreeResults(response, inv_data, size);
			});
		//}
	}
	
}

function getInventoryByCutId(inv_data, id){
	for(var key in inv_data){
		if(inv_data[key].cut_id == id)
			return inv_data[key];
	}
	return undefined;
}

function showCutTreeResults(response, inv_data, size) {
	var data;
	
	try {
		//console.log(response);
        data = JSON.parse(response);
    } catch (e) {
		
		var elements_div = document.getElementById('sheetSellingElements');
		var cut_info = document.createElement("div");
		cut_info.id = "cut_info_table";
		cut_info.innerHTML += "<br><b>Out of stock! No cuts can be made!</b><br/>";
	
		elements_div.appendChild(cut_info);
		
        return;
    }
	
	
	var list = data[0];
	var cut_into = data[1];
	
	var elements_div = document.getElementById('sheetSellingElements');
	var cut_info = document.createElement("div");
	cut_info.id = "cut_info_table";
	cut_info.style = "padding-top:10px";
	var table = document.createElement("table");
	table.className = "table table-striped table-bordered table-hover";
	var tbody = document.createElement("tbody");
	var table_header = document.createElement("th");
	
	var confirm = document.createElement("button");
	confirm.className = "btn btn-success btn-md";
	confirm.style = "margin-left:8px;";
	confirm.innerHTML = "Confirm Cut(s)";
	
	confirm.onclick = function() {
		window.location.href = "webpage_cutSheet_accepted.php";
	}
	
	cut_info.appendChild(confirm);
	
	
	cut_info.appendChild(document.createElement("br"));
	cut_info.appendChild(document.createElement("hr"));
	cut_info.appendChild(createFancyLabel("Preview of cuts:", "font-size: 1.5em;", ""));
	cut_info.appendChild(document.createElement("br"));
	cut_info.appendChild(document.createElement("br"));
	
	cut_info.appendChild(createFancyLabel("Disclaimer: Only the official cut sizes are used in this table.", "margin-bottom:4px;background-color: #FFFF90;border: none;", "panel-heading col-md-12"));
	cut_info.appendChild(table);
	table.appendChild(tbody);
	tbody.appendChild(table_header);
	
	table_header.innerHTML = "<td>Make the following cuts:</td>";
	
	
	for(var i = list.length-1; i >= 0; i--){
		var current_sheet_size = list[i].width + "x" + list[i].height;
		if(current_sheet_size === size) { // sanity check
			break; 
		}
		
		var cut_amounts = cut_into[i].length;
		if(cut_amounts > 0) {
			var message = "Cut a " + current_sheet_size + " sheet into ";
			
			if(cut_amounts == 1) {
				var cut_amount = cut_into[i][0][1];
				var child_sheet = getInventoryByCutId(inv_data, cut_into[i][0][0]);
				message += "2 " + child_sheet.size + " sheets";
			} else { 
				var child_sheet_1 = getInventoryByCutId(inv_data, cut_into[i][0][0]);
				var child_sheet_2 = getInventoryByCutId(inv_data, cut_into[i][1][0]);
				if(child_sheet_1 != undefined && child_sheet_2 != undefined) {
					message += "a " + child_sheet_1.size + " sheet and a " + child_sheet_2.size + " sheet";
				} else {
					console.log(child_sheet_1 + "/" + child_sheet_2);
				}
			}
			
			tbody.innerHTML += "<tr><td>" + message + "</tr></td>";
			//console.log(message);
		}
		//console.log(list[i].width + "," + list[i].height + ": " + cut_into[i]);
	}
	elements_div.appendChild(cut_info);
}



// I'm not sure how jon wants us to call php functions
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

makeVariantsAndCutSizesSelects();
</script>

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>