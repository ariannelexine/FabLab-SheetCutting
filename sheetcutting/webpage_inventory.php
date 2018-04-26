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
            <h1 class="page-header">Sheet Material Inventory</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-cubes fa-lg"></i> Inventory
				<a type="button" style="margin-top:-7px;margin-right:-12px;" class="btn btn-info btn-md pull-right" href="http://fabapp/sheetcutting/webpage_addNewInventory.php"> 
				<span class="glyphicon glyphicon-plus-sign"></span> Add New Inventory
				</a>
                </div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="testTable">
						<thead>
							<tr class="tablerow">
								<th>Material</td>
								<th>ID</td>
								<th>Size</th>
								<th>Price</th>
								<th>In Stock</th>
							</tr>
						</thead>
						 <?php if ($result = $mysqli->query("
                            SELECT DISTINCT type, v.variant_id, v.colorhex, name, width, height, price, count(obj_id) as 'In Stock'
							FROM sheet_type s
							LEFT JOIN cut_sizes as c ON s.type_id = c.type_id
							LEFT JOIN variants as v ON s.type_id = v.type_id
							LEFT JOIN sheet_inventory as i ON i.variant_id = v.variant_id AND i.cut_id = c.cut_id
							WHERE i.removed_date IS NULL
							GROUP BY name, width, height;
                        ")){
                            while ( $row = $result->fetch_assoc() ){ ?>
                                <tr class="tablerow">
									<td>
										<span style="float:left;margin-right:6px;">
											<?php 
												echo ' ' . $row["type"]; 
												if($row["name"] != NULL) {
													echo ' (' . $row["name"] . ')';
												}
											?>
										</span>
										<div class="color-box" style="float:right;background-color: #<?php echo $row['colorhex'];?>;"/>
									</td>
									<td>
										<?php echo $row["variant_id"]?></td>
									</td>
									<td>
										<?php echo $row["width"] . 'x' . $row["height"];?></td>
									</td>
									<td>
										<?php echo '$' . $row["price"]; ?></td>
									</td>
									<td>
										<?php echo $row["In Stock"];?></td>
									</td>
								</tr>
							<?php }
                        } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	window.onload = function() {
	   	$('#testTable').DataTable();
    };
</script>

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>