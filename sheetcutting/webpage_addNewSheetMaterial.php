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
            <h1 class="page-header">New Sheet Material</h1>
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
					<table class="table table-striped table-bordered table-hover">
						<tbody>
							<tr id="materialName">
								<td>
									<b>Material Name:</b> 
									<input style="margin-left:4px;" value="" name="field1" id="field1" tabindex="1" />
								</td>
							</tr>
							<tr id="Variant1" style="height:100px">
								<td>
									<b>Variant:</b> 
									<input tabindex="3"/>
								</td>
							</tr>
							<tr id="addVariant">
								<td>
									<button onclick="AddVariant()" class="btn btn-warning btn-md">Add Variant</button>
								</td>
							</tr>
							<tr id="buttons">
								<td>
									<button onclick="AddMaterial()" class="btn btn-success btn-md">Add Material</button>
									<button onclick="Cancel();" class="btn btn-danger btn-md">Cancel</button>
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
	var lastVariantID = 1;
	var variant_ids_reference = ["Variant1"];
	
	var AddVariant = function() {
		var tableRow = document.createElement("tr");
		tableRow.id = "Variant" + (++lastVariantID);
		variant_ids_reference.push(tableRow.id);
		tableRow.style = "height:100px;";
		var tableEntry = document.createElement("td");
		tableRow.appendChild(tableEntry);
		
		var variant_text = document.createElement("b");
		variant_text.innerHTML = "Variant:";
		
		var variant_textbox = document.createElement("input");
		variant_textbox.style = "margin-left:4px;";
		
		var variant_removeButtonThis = document.createElement("button");
		variant_removeButtonThis.className = "btn btn-danger btn-md";
		variant_removeButtonThis.style = "margin-left:8px;";
		variant_removeButtonThis.innerHTML = "Remove";
		variant_removeButtonThis.onclick = function() {
			DeleteHTMLElement(tableRow.id);
		}
		
		tableEntry.appendChild(variant_text);
		tableEntry.appendChild(variant_textbox);
		// 
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(document.createElement("br"));
		tableEntry.appendChild(variant_removeButtonThis);
		
		var e = document.getElementById("addVariant");
		e.parentNode.insertBefore(tableRow, e);
	}	
	
	var DeleteHTMLElement = function(id) {
		var e = document.getElementById(id);
		variant_ids_reference.splice(variant_ids_reference.indexOf(id));
		console.log(variant_ids_reference);
		e.parentNode.removeChild(e);
	}
	var AddMaterial = function() {
		window.history.back();
	}
	var Cancel = function() {
		window.history.back();
	}
</script>

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>