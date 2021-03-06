<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
 //This will import all of the CSS and HTML code nessary to build the basic page
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/sheetcutting/class/all_classes.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   echo "<script>console.log( 'Debug Objects: " . $_POST["matName"] . "' );</script>";
   $type_id = Sheet_Type::insertSheetType($_POST["matName"]);
   if (is_int($type_id)) {
       Variants::insertVariants($type_id, $_POST["variants"]);
       Variants::insertColorVariants($type_id, $_POST["colorvariants"]);
       Cut_Sizes::insertCutSizes($type_id, $_POST["sizes"]);
       header("Location:newCutChildren.php?type_id=".$type_id);
   }
}

?>

<title><?php echo $sv['site_name'];?> New Sheet Material</title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Manage Sheet Material</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-cubes fa-lg"></i> Add new Sheet Material
                </div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="materialTable">
						<tbody>
							<tr id="materialName">
								<td>
									<b>Material Name:</b> 
									<input style="margin-left:4px;" value="" name="sheetType" id="sheetType" tabindex="1" required/>
								</td>
							</tr>
						</tbody>
					</table>
                    <table class="table table-striped table-bordered table-hover" id="variantTable">
						<tbody>
							<thead>
								<th>
									<b>Variants</b>
								</th>
							</thead>
                            <div id="hidden_form_container" style="display:none;"></div>
                            <tr id="addVariant">
								<td>
									<button onclick="AddVariant()" class="btn btn-warning btn-md">Add Variant</button>
									<button onclick="AddColorVariant()" class="btn btn-warning btn-md" style="margin-left:8px;">Add Color Variant</button>
								</td>
							</tr>
							<thead>
								<th>
									<b>Cut Sizes</b>
								</th>
							</thead>
                            <tr id="addSize">
								<td>
									<button onclick="AddSize()" class="btn btn-info btn-md">Add Cut Sizes</button>
								</td>
							</tr>
                            <tr id="buttons">
								<td>
									<button onclick="Cancel();" class="btn btn-danger btn-md pull-right">Cancel</button>
									<button id="submitBtn" onclick="SubmitMaterial()" class="btn btn-success btn-md pull-right" style="margin-right:8px;">Save </button>
								</td>
							</tr>
                        </tbody>
					</table> 
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" charset="utf-8">
	var lastcolorVariantID = 0;
	var lastVariantID = 0;
	var lastSizeID = 0;
	var colorvariant_id_reference = [];
	var variant_id_reference = [];
	var size_id_reference = [];

	window.onload = function(){
		document.getElementById("submitBtn").disabled = true;
		$('#sheetType').keyup(function(){
			if($(this).val().length !=0)
				document.getElementById("submitBtn").disabled = false;
			else
				document.getElementById("submitBtn").disabled = true;
		})
	};
	
	var AddColorVariant = function() {
		var tableRow = document.createElement("tr");
		tableRow.id = "colorVariant" + (++lastcolorVariantID);
		colorvariant_id_reference.push(tableRow.id);
		tableRow.style = "height:100px;";
		var tableEntry = document.createElement("td");
		tableRow.appendChild(tableEntry);
		
		// Variant ID 
		var variant_text = document.createElement("b");
		variant_text.innerHTML = "Variant ID:";
		variant_text.style = "margin-left:4px;";
		var variant_textbox = document.createElement("input");
		variant_textbox.style = "margin-left:4px;";
		variant_textbox.id = "variantid";

		// Variant name 
		var colorvariant_name = document.createElement("b");
		colorvariant_name.innerHTML = "Name:";
		colorvariant_name.style = "margin-left:4px;";
		var colorname_textbox = document.createElement("input");
		colorname_textbox.style = "margin-left:4px;";
		colorname_textbox.id = "variantname";

		// Variant Description 
		var colorvariant_desc = document.createElement("b");
		colorvariant_desc.innerHTML = "Description:";
		colorvariant_desc.style = "margin-left:4px;";
		var colordesc_textbox = document.createElement("input");
		colordesc_textbox.style = "margin-left:4px;";
		colordesc_textbox.id = "variantdesc";

		// Variant colorhex
		var variant_color = document.createElement("b");
		variant_color.innerHTML = "Colorhex:";
		variant_color.style = "margin-left:4px;";
		var color_textbox = document.createElement("input");
		color_textbox.style = "margin-left:4px;";
		color_textbox.id = "variantcolor";
		
		var colorvariant_removeButtonThis = document.createElement("button");
		colorvariant_removeButtonThis.className = "btn btn-danger btn-md";
		colorvariant_removeButtonThis.style = "margin-left:8px;";
		colorvariant_removeButtonThis.innerHTML = "Remove";
		colorvariant_removeButtonThis.onclick = function() {
			DeleteHTMLElement(colorvariant_id_reference, tableRow.id);
		}
		
		tableEntry.appendChild(variant_text);
		tableEntry.appendChild(variant_textbox);
		tableEntry.appendChild(colorvariant_name);
		tableEntry.appendChild(colorname_textbox);
		tableEntry.appendChild(colorvariant_desc);
		tableEntry.appendChild(colordesc_textbox);
		tableEntry.appendChild(variant_color);
		tableEntry.appendChild(color_textbox);
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(colorvariant_removeButtonThis);
		
		var e = document.getElementById("addVariant");
		e.parentNode.insertBefore(tableRow, e);
	}	
	
	var AddSize = function() {
		var tableRow = document.createElement("tr");
		tableRow.id = "size" + (++lastSizeID);
		size_id_reference.push(tableRow.id);
		tableRow.style = "height:100px;";
		var tableEntry = document.createElement("td");
		tableRow.appendChild(tableEntry);
		
		// Width
		var width_text = document.createElement("b");
		width_text.innerHTML = "Width:";
		width_text.style = "margin-left:4px;";
		var width_textbox = document.createElement("input");
		width_textbox.style = "margin-left:4px;";
		width_textbox.id = "width";

		// Height
		var height_text = document.createElement("b");
		height_text.innerHTML = "Height:";
		height_text.style = "margin-left:4px;";
		var height_textbox = document.createElement("input");
		height_textbox.style = "margin-left:4px;";
		height_textbox.id = "height";

		// Price
		var price_text = document.createElement("b");
		price_text.innerHTML = "Price: $";
		price_text.style = "margin-left:4px;";
		var price_textbox = document.createElement("input");
		price_textbox.style = "margin-left:4px;";
		price_textbox.id = "price";
		
		var variant_removeButtonThis = document.createElement("button");
		variant_removeButtonThis.className = "btn btn-danger btn-md";
		variant_removeButtonThis.style = "margin-left:8px;";
		variant_removeButtonThis.innerHTML = "Remove";
		variant_removeButtonThis.onclick = function() {
			DeleteHTMLElement(size_id_reference, tableRow.id);
		}
		
		tableEntry.appendChild(width_text);
		tableEntry.appendChild(width_textbox);
		tableEntry.appendChild(height_text);
		tableEntry.appendChild(height_textbox);
		tableEntry.appendChild(price_text);
		tableEntry.appendChild(price_textbox);
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(variant_removeButtonThis);
		
		var e = document.getElementById("addSize");
		e.parentNode.insertBefore(tableRow, e);
	}

	var AddVariant = function() {
		var tableRow = document.createElement("tr");
		tableRow.id = "Variant" + (++lastVariantID);
		variant_id_reference.push(tableRow.id);
		tableRow.style = "height:100px;";
		var tableEntry = document.createElement("td");
		tableRow.appendChild(tableEntry);

		// Variant name 
		var variant_name = document.createElement("b");
		variant_name.innerHTML = "Name:";
		variant_name.style = "margin-left:4px;";
		var name_textbox = document.createElement("input");
		name_textbox.style = "margin-left:4px;";
		name_textbox.id = "variantname";

		// Variant Description 
		var variant_desc = document.createElement("b");
		variant_desc.innerHTML = "Description:";
		variant_desc.style = "margin-left:4px;";
		var desc_textbox = document.createElement("input");
		desc_textbox.style = "margin-left:4px;";
		desc_textbox.id = "variantdesc";
		
		var variant_removeButtonThis = document.createElement("button");
		variant_removeButtonThis.className = "btn btn-danger btn-md";
		variant_removeButtonThis.style = "margin-left:8px;";
		variant_removeButtonThis.innerHTML = "Remove";
		variant_removeButtonThis.onclick = function() {
			DeleteHTMLElement(variant_id_reference, tableRow.id);
		}
		
		tableEntry.appendChild(variant_name);
		tableEntry.appendChild(name_textbox);
		tableEntry.appendChild(variant_desc);
		tableEntry.appendChild(desc_textbox);
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(variant_removeButtonThis);
		
		var e = document.getElementById("addVariant");
		e.parentNode.insertBefore(tableRow, e);
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

/*
	Get array of all color variants attributes in the textboxes and 
	create a JSON object for each variant and add it into an array
	of variant objects. The array will turn into a json string 
	to be attatched to the post params to be sent to the server. 
*/
function getColorVariantJSON() {
	var variant_array = []; // Array of all the variant object

	var variantLength = colorvariant_id_reference.length;
	for (var i = 0; i < variantLength; i++) {
		var variant_id = colorvariant_id_reference[i];
		var row = document.getElementById(variant_id);

		var variantid = row.querySelector("#variantid");
		var variantid_string = variantid.value;

		var variantname = row.querySelector("#variantname");
		var variantname_string = variantname.value;

		var variantdesc = row.querySelector("#variantdesc");
		var variantdesc_string = variantdesc.value;

		var variantcolor = row.querySelector("#variantcolor");
		var variantcolor_string = variantcolor.value;
		
		var object = { 
			"colorid" : variantid_string, 
			"colorname" : variantname_string, 
			"colordescription": variantdesc_string, 
			"colorhex": variantcolor_string 
		};
		variant_array.push(object);
	}
	return JSON.stringify(variant_array);
}

/*
	Get array of all variants attributes in the textboxes and 
	create a JSON object for each variant and add it into an array
	of variant objects. The array will turn into a json string 
	to be attatched to the post params to be sent to the server. 
*/
function getVariantJSON() {
	var variant_array = []; // Array of all the variant object

	var variantLength = variant_id_reference.length;
	for (var i = 0; i < variantLength; i++) {
		var variant_id = variant_id_reference[i];
		var row = document.getElementById(variant_id);

		var variantname = row.querySelector("#variantname");
		var variantname_string = variantname.value;

		var variantdesc = row.querySelector("#variantdesc");
		var variantdesc_string = variantdesc.value;

		var object = { 
			"name" : variantname_string, 
			"description": variantdesc_string, 
		};
		variant_array.push(object);
	}
	return JSON.stringify(variant_array);
}

/*
	Get array of all size attributes in the textboxes and 
	create a JSON object for each size and add it into an array
	of size objects. The array will turn into a json string 
	to be attatched to the post params to be sent to the server. 
*/
function getSizesJSON() {
	var size_array = []; // Array of all the size objects

	var sizeLength = size_id_reference.length;
	for (var i = 0; i < sizeLength; i++) {
		var size_id = size_id_reference[i];
		var row = document.getElementById(size_id);

		var width = row.querySelector("#width");
		var width_value = width.value;

		var height = row.querySelector("#height");
		var height_value = height.value;

		var price = row.querySelector("#price");
		var price_value = price.value;
		
		var object = { 
			"width" : width_value, 
			"height" : height_value, 
			"price": price_value
		};
		size_array.push(object);
	}
	return JSON.stringify(size_array);
}
	
var SubmitMaterial = function() {
  var theForm, matName;
  
  theForm = document.createElement('form');
  theForm.method = 'post';
  
  matName = document.createElement('input');
  matName.type = 'hidden';
  matName.name = 'matName';
  matName.value = document.getElementById("sheetType").value;

  colorvariants = document.createElement('input');
  colorvariants.type = 'hidden';
  colorvariants.name = 'colorvariants';
  colorvariants.value = getColorVariantJSON();

  variants = document.createElement('input');
  variants.type = 'hidden';
  variants.name = 'variants';
  variants.value = getVariantJSON();

  sizes = document.createElement('input');
  sizes.type = 'hidden';
  sizes.name = 'sizes';
  sizes.value = getSizesJSON();

  theForm.appendChild(matName);
  theForm.appendChild(colorvariants);
  theForm.appendChild(variants);
  theForm.appendChild(sizes);

  document.getElementById('hidden_form_container').appendChild(theForm);
  
  if (confirm('Insert ' + matName.value + ' into the database?')) {
	theForm.submit();
	} else {
		// Do nothing!
	}
}
</script>
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>