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
					<select>
					<?php if ($result = $mysqli->query("
                            SELECT DISTINCT sheet_type from Variants
                        ")){
                            while ( $row = $result->fetch_assoc() ){ ?>
							<option>
								<?php echo $row["sheet_type"] ?>
							</option>
						<?php }
					} ?>
					</select>
					
					<b style="margin-left:10px;">Variant: </b>
					<select>
					<?php if ($result = $mysqli->query("
                            SELECT name from Variants
                        ")){
                            while ( $row = $result->fetch_assoc() ){ ?>
							<option>
								<?php echo $row["name"] ?>
							</option>
						<?php }
					} ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">

</script>

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>