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
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-cubes fa-lg"></i> Sheet cutting
                </div>
				<div class="panel-body">
					<b>Material: </b>
					<select id="sheet_type_list">
					<?php if ($result = $mysqli->query("
                            SELECT DISTINCT type from sheet_type
                        ")){
                            while ( $row = $result->fetch_assoc() ) { 
								echo '<option value="' . $row["type"] . '">' .  $row["type"] . '</option>'; 
							}
						} ?>
					</select>
					
					<b style="margin-left:10px;">Variant: </b>
					<select id="name_list" onchange="makeSheetSellingElements()">
					<?php if ($result = $mysqli->query("
                            SELECT name, variant_id from Variants ORDER BY name ASC;
                        ")){
                            while ( $row = $result->fetch_assoc() ) { 
								echo '<option value="' .  $row["name"] . ' (' . $row["variant_id"] . ')' . '">' .  $row["name"] . ' (' . $row["variant_id"] . ')' . '</option>'; 
							}
						} ?>
					</select>
					<div id="sheetSellingElements" style="margin-top:10px;">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" charset="utf-8">
function makeSheetSellingElements() {
	var elements_div = document.getElementById('sheetSellingElements');
	elements_div.innerHTML = '';
	
	var variant_text = document.createElement("b");
	variant_text.innerHTML = "Size:";
	var cutlist = document.createElement("select");
	cutlist.onchange = function() {
		updateStock();
	}
	cutlist.id="size_list";

	var sheet_type = document.getElementById('sheet_type_list');
	var name = document.getElementById('name_list');
	var name_string = name.value.substring(0, name.value.indexOf(" ("));
	//alert(name.value+","+name_string);
	var params = "name="+name_string+"&sheet_type="+sheet_type.value;
	callPHP('ajax_getCutSizes.php', params, function(response){
		var arr = response.split(",");
		for(var i = 0; i < arr.length - 1; i++) {
			var option = document.createElement("option");
			option.value = arr[i];
			option.innerHTML = arr[i];
			cutlist.appendChild(option);
		}
		var stock_and_price = document.createElement("div");
		stock_and_price.id = "stock_and_price";
		stock_and_price.style = "margin-top:10px;";
		elements_div.appendChild(variant_text);
		elements_div.appendChild(cutlist);
		elements_div.appendChild(stock_and_price);
		updateStock();
	});
}

function updateStock() {
	var elements_div = document.getElementById('sheetSellingElements');
	var stock_and_price = document.getElementById('stock_and_price');
	stock_and_price.innerHTML = "";
	
	var sheet_type = document.getElementById('sheet_type_list');
	var name = document.getElementById('name_list');
	var name_string = name.value.substring(0, name.value.indexOf(" ("));
	var size = document.getElementById('size_list').value.split("x");
	var params = "name="+name_string+"&sheet_type="+sheet_type.value+"&width="+size[1]+"&height="+size[0];
	//console.log(params);
	callPHP('ajax_getInventoryStock.php', params, function(response){
		console.log(response);
		var count_label = document.createElement("p");
		var split_response = response.split(",")
		count_label.innerHTML = "Stock: "+split_response[0]+", price = $"+split_response[1];
		stock_and_price.appendChild(count_label);
		var button_for_buy = document.createElement("div");
		button_for_buy.id="button_for_buy";
		stock_and_price.appendChild(button_for_buy);
		makeSaleButton(split_response[0], split_response[1]);
	});
}

function makeSaleButton(count, price) {
	var button_for_buy = document.getElementById('button_for_buy');
	var buyButton = document.createElement("button");
	buyButton.className = "btn btn-success btn-md";
	buyButton.style = "margin-left:8px;";
	buyButton.innerHTML = "Make Cut";
	
	buyButton.onclick = function() {
		var sheet_type = document.getElementById('sheet_type_list');
		var name = document.getElementById('name_list');
		var name_string = name.value.substring(0, name.value.indexOf(" ("));
		var name_id = name.value.substring(name.value.indexOf(" (")+2, name.value.indexOf(" (")+6);
		//console.log(name_id + "," + name_string);
		var size = document.getElementById('size_list').value.split("x");
		var params = "name="+name_string+"&variant_id="+name_id+
		"&sheet_type="+sheet_type.value+"&width="+size[1]+"&height="+size[0]+
		"&count="+count+"&price="+price;
		callPHP('ajax_getCuts.php', params, function(response){
			//buyButton.innerHTML = "The sale has been made!";
			//buyButton.className = "btn btn-info btn-md";
			//setTimeout(function(){ makeSheetSellingElements(); }, 1000);
			console.log(response);
		});
	}
	
	button_for_buy.appendChild(buyButton);
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

makeSheetSellingElements();
</script>

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>