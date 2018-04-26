<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
 //This will import all of the CSS and HTML code nessary to build the basic page
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
$time = $errorMsg = "";
$error = false;

if (empty($_GET["type_id"])){
    $errorMsg = "Type ID is Missing.";
    $error = true;
} else {
    $type_id = filter_input(INPUT_GET,'type_id');
    echo "<script>console.log( 'Debug Objects: " . $type_id . "' );</script>";
    
    $sheet_type = new Sheet_Type($type_id);
    $cut_sizes = Cut_Sizes::getSheetSizes($type_id);
    echo "<script>console.log( 'Debug Objects: " . json_encode($cut_sizes) . "' );</script>";
}
?>

<title><?php echo $sv['site_name'];?> Add Children</title>
<div id="page-wrapper">
<?php 
if($error){
?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Error</h1>
            <?php echo $errorMsg;?>
        </div>
        <!-- /.col-md-12 -->
    </div>
</div>
<?php } ?>