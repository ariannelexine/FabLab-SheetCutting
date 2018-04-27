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
    
    $sheet_type = new Sheet_Type($type_id);
    $cut_sizes = Cut_Sizes::getSheetSizes($type_id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['childBtn'])) {
     echo "<script>console.log( 'Debug Objects: " . json_encode($_POST['child1']) . "' );</script>";
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
<?php } else { ?>
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
            <form id="cform" name="cform" method="post" >
                <table id="childTable" class="table table-striped table-bordered table-hover">
                    <tbody>
                        <tr> <th style="width: 25%; text-align: center"> Size </th><th style='text-align: center'> Child 1 </th><th style='text-align: center'> Child 2 </th> </tr>
                        <?php
                            foreach($cut_sizes as $size) {
                                echo "<tr style='text-align: center' name='cutid" . $size[cut_id] . "'>
                                    <td>" . $size[width] . "x" . $size[height] . "</td>"; ?>
                                    <td>
                                    <select name="child1[]" id="child1" style="margin-right:20px;">
                                    <option value='NULL'>No Child</option>
                                        <?php if($result = $mysqli->query("
                                                SELECT *
                                                FROM `cut_sizes`
                                                WHERE `type_id` = $type_id;
                                        ")){ while($row = $result->fetch_assoc()){
                                                echo("<option value='$row[cut_id]'>$row[width] x $row[height]</option>");
                                            }
                                        }?>
                                    </select>
                                    <b>Amount:</b>
                                    <select name="childAmount1[]"> 
                                    <option disabled hidden selected value=""></option>
                                        <option value=1> 1 </option>
                                        <option value=2> 2 </option>
                                    </select> 
                                    </td>
                                    <td> 
                                    <select name="child2[]" id="child2" style="margin-right:20px;">
                                    <option value='NULL'>No Child</option>
                                        <?php if($result = $mysqli->query("
                                                SELECT *
                                                FROM `cut_sizes`
                                                WHERE `type_id` = $type_id;
                                        ")){ while($row = $result->fetch_assoc()){
                                                echo("<option value='$row[cut_id]'>$row[width] x $row[height]</option>");
                                            }
                                        }?>
                                    </select>
                                    <b>Amount:</b>
                                    <select name="childAmount2[]"> 
                                    <option disabled hidden selected value=""></option>
                                        <option value=1> 1 </option>
                                        <option value=2> 2 </option>
                                    </select> 
                                    </td>
                                  </tr> 
                        <?php } ?>
                    </tbody>
                </table>
                <tr id="buttons">
                    <td>
                        <button onclick="Cancel();" class="btn btn-danger btn-md pull-right">Cancel</button>
                        <button onclick="AddChildren()" class="btn btn-success btn-md pull-right" style="margin-right:8px;">Add Cut Size Children</button>
                        <td align="right"><input type="submit" name="childBtn" value="Submit" tabindex="9"></td>
                    </td>
                </tr>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script type="text/javascript" charset="utf-8">
    // var AddChildren = function() {
    //     var table = document.getElementById("childTable");
    //     for (var i = 0, row; row = table.rows[i]; i++) {
    //         //iterate through rows
    //         //rows would be accessed using the "row" variable assigned in the for loop
    //         for (var j = 0, col; col = row.cells[j]; j++) {
    //             //iterate through columns
    //             //columns would be accessed using the "col" variable assigned in the for loop
    //         }  
    //     }

    // }
</script>
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>
