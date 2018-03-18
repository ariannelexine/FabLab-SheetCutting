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
				<a type="button" style="margin-top:-7px;margin-right:-12px;" class="btn btn-info btn-md pull-right" href="http://fabapp/kilns/webpage_addNewSheetMaterial.php">Add new material</a>
                </div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="testTable">
						<thead>
							<tr class="tablerow">
								<th>Material</td>
								<th>Size</th>
								<th>Price</th>
								<th>In Stock</th>
							</tr>
						</thead>
						 <?php if ($result = $mysqli->query("
                            SELECT DISTINCT sheet_type, description, name, height, width, price, count(obj_id) as 'In Stock'
							FROM SHEETS h 
							INNER JOIN VARIANTS v on h.variant_id = v.variant_id
							INNER JOIN CUT_SIZES c on h.size = c.cut_id
							LEFT JOIN SHEET_INVENTORY s on s.variant_id = h.variant_id and s.size = h.size
							GROUP BY h.variant_id, h.size;
                        ")){
                            while ( $row = $result->fetch_assoc() ){ ?>
                                <tr class="tablerow">
									<td>
										<?php echo $row["sheet_type"] . ' (' . $row["name"] . ')'?></td>
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