<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
 //This will import all of the CSS and HTML code nessary to build the basic page
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/sheetcutting/class_sheet.php');

$has_cut_instructions = isset($_SESSION['cut_list_instructions']);

?>
<title><?php echo $sv['site_name'];?></title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
				<?php 
					if($has_cut_instructions) {
						echo 'Cut Sheet';
					} else {
						echo 'Sheets Sold!';
					}
				?>
			</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
	
	<?php
		if($has_cut_instructions) {
			echo '<b class="panel-heading" style="margin-bottom:16px;margin-right:8px;background-color: #B0EFB0;border: none;">The cut instructions are now printing.</b>';
			echo '<button class="btn btn-warning btn-md">Print again</button><br><br>';
		}
	?>
	
    <!-- /.row -->
    <div class="row">
		<div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas <?php echo ($has_cut_instructions ? "fa-cut" : "fa-calculator") ?> fa-lg"></i> 
					<?php  
						if($has_cut_instructions) {
							echo '<b>Cut Instructions</b>';
						} else {
							echo 'Review';
						}
					?>
                </div>
				<div class="panel-body">
					<?php
						if($has_cut_instructions) {
							$instructions = explode(';', $_SESSION['cut_list_instructions']);
							echo '<table class="table table-striped table-bordered table-hover"><thead><td><b>Make the following cuts:</b></td></thead>';
							echo '<tbody>';
							foreach ($instructions as $statement){
								echo '<tr><td>' . $statement . '</td></tr>';
							}
							echo '</tbody></table>';
							echo '<button style="width:100%" class="btn btn-success btn-md" onclick="updateDatabaseWithCuts()">I have made all of these cuts, so please update the database.</button>';
						} else {
							$sell_sheet_information = unserialize($_SESSION['sheet_info']);
							$sheet = $sell_sheet_information[0];
							$sell_amount = $sell_sheet_information[1];
							$total_cost = $sell_sheet_information[2];
							echo '<table class="table table-striped table-bordered table-hover"><tbody><td><b style="font-size:1.2em">';
							echo 'Sold ' . $sell_amount . ' ' . $sheet->width . 'x' . $sheet->height . ' ';
							echo ($sell_amount > 1 ? 'sheets ' : 'sheet ');
							echo 'for $' . $total_cost;
							echo '</b></td></tbody></table>';
							echo '<button style="width:100%" class="btn btn-success btn-md" onclick="updateDatabaseWithSoldSheets()">The user has picked up the sheets, please update the database</button>';
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
function updateDatabaseWithCuts(){
	callPHP('ajax_updateDatabaseWithCuts.php', "", function(response){
		window.location.href = 'webpage_inventory.php';
	});
}

function updateDatabaseWithSoldSheets() {
	// Selling sheets is unimplemented, should be easy to add in.
	window.location.href = 'webpage_inventory.php';
}

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