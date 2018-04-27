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
   //echo "<script>console.log(" . json_encode($_POST). ");</script>"; 
    Cut_Sizes::addChildren($_POST['cArray']);
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
                <button style="margin-top:-7px;" type="button" class="btn btn-info pull-right" data-container="body" data-trigger="hover" data-toggle="popover" 
                data-placement="left" data-title="Define the child sizes and the number of pieces that a base sheet can be cut into." data-content="
                <strong>Example</strong>
                <br />'35x20' is cut into 1 '20x20' and 1 '20x15'
                <br />'96x48' is cut into 10 '18x24' and 1 '24x12'"> 
                <span class="glyphicon glyphicon-info-sign"></span> Info </button>
            </div>
            <div class="panel-body">
            <form id="cform" name="cform" method="post" >
                <table id="childTable" class="table table-striped table-bordered table-hover">
                    <tbody>
                        <thead>
                            <tr>
                                <th style="width: 25%; text-align: center"> Size </th>
                                <th style='text-align: center'> Child 1 </th>
                                <th style='text-align: center'> Child 2 </th>
                            </tr>
                        </thead>
                        <?php
                            foreach($cut_sizes as $size) { ?>
                                <tr style='text-align: center'>
                                <?php echo "<td>" . $size[width] . "x" . $size[height] . "</td>"; ?>
                                    <td>
                                    <?php echo "<select name='cArray[$size[cut_id]][child1]' style='margin-right:20px;'>"; ?>
                                    <option value='NULL'>No Child</option>
                                        <?php if($result = $mysqli->query("
                                                SELECT *
                                                FROM `cut_sizes`
                                                WHERE `type_id` = $type_id;
                                        ")){ while($row = $result->fetch_assoc()){
                                                echo("<option value='$row[cut_id]'>$row[width]x$row[height]</option>");
                                            }
                                        }?>
                                    </select>
                                    <b>Amount:</b>
                                    <?php echo "<input type='number' name='cArray[$size[cut_id]][amount1]' value='' style='width: 60px; margin-right:12px;'/>"; ?>
                                    </td>
                                    <td> 
                                    <?php echo "<select name='cArray[$size[cut_id]][child2]' style='margin-right:20px;'>"; ?>
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
                                    <?php echo "<input type='number' name='cArray[$size[cut_id]][amount2]' value='' style='width: 60px; margin-right:12px;'/>"; ?>
                                    </td>
                                  </tr> 
                        <?php } ?>
                    </tbody>
                </table>
                <tr id="buttons">
                    <td>
                        <button onclick="Cancel();" class="btn btn-danger btn-md pull-right">Cancel</button>
                        <!-- <button onclick="AddChildren()" class="btn btn-success btn-md pull-right" style="margin-right:8px;">Add Cut Size Children</button> -->
                        <input type="submit" name="childBtn" value="Add Cut Size Children" class="btn btn-success btn-md pull-right" style="margin-right:8px;">
                    </td>
                </tr>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script type="text/javascript" charset="utf-8">
    window.onload = function() {
        $(function () {
            $('[data-toggle="popover"]').popover({ html : true})
        })
    }; 
</script>
<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>
