<?php
/*
 *   CC BY-NC-AS UTA FabLab 2016-2017
 *   FabApp V 0.9
 */
 //This will import all of the CSS and HTML code nessary to build the basic page
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/header.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/sheetcutting/class_sheet.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['payBtn'])){
    $selectPay = filter_input(INPUT_POST, "selectPay");
    $totalCost = filter_input(INPUT_POST, "totalCost");
    if ( preg_match("/^\d{1,3}$/", $selectPay) ){
        //The person paying may not be the person who is authorized to pick up a print
        $payee = Users::withID(filter_input(INPUT_POST,'payee'));
        if (is_object($payee)){
            echo "<script> console.log('SP: $selectPay, payee: ".$payee->getOperator()."'); </script>";
			$order_num = rand();
			$result = Acct_charge::insertPOS($totalCost, $order_num, $selectPay, $payee, $staff);
        } else {
            echo "<script> console.log('SP: $selectPay, payee: ".$payee."'); </script>";
            $errorMsg = $payee;
        }
    }
	header("Location:webpage_cutSheet_final.php");
}

?>
<title><?php echo $sv['site_name'];?></title>
<div id="page-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">Payment for Sheet</h1>
        </div>
        <!-- /.col-md-12 -->
    </div>
	
	<?php 
	$errorMsg = "";
	if(!isset($_POST['mav_id'])) {
		//echo '<b>Error: Mav ID is not set</b>';
		$errorMsg = "Error: Mav ID is not set";
	}
	if(!isset($_SESSION['Cuts'])) {
		//echo '<b>Error: Cut list is not set</b>';
		$errorMsg = "Error: Cut list is not set";
	}
	
	if(isset($_POST['cut_list_instructions'])) {
		if(strlen($_POST['cut_list_instructions']) > 0){
			$_SESSION['cut_list_instructions'] = $_POST['cut_list_instructions']; // save cut instructions to session.
			$_SESSION['inv_data'] = $_POST['inv_data']; // save inventory data to session.
			$_SESSION['staff_id'] = $staff->getOperator(); // store staff id to session (to pass into ajax_updateDatabaseWithCuts.php)
			
			$cut_data = unserialize($_SESSION['Cuts']);
			$cut_data_list = $cut_data[0];
			$sheet = $cut_data_list[0];
			
			$sell_amount = 1; // currently hardcoded.
			$total_cost = $sheet->price * $sell_amount;
			
			$has_cuts = true;
		} else {
			
			//$errorMsg = $_POST['sell_sheet_info'];
			$sheet_info = explode(";", $_POST['sell_sheet_info']);
			
			$sheet = new Sheet($sheet_info[0], $sheet_info[1], $sheet_info[2], -1, $sheet_info[3], $sheet_info[4], $sheet_info[5], $sheet_info[6]);
			$sell_amount = $sheet_info[7];
			$total_cost = $sheet->price * $sell_amount;
			
			$_SESSION['sheet_info'] = serialize([$sheet, $sell_amount, $total_cost]); // save sheet info to session.
			
			$has_cuts = false;
		}
	} else {
		$errorMsg = "Something bad happened";
	}
	
	if($errorMsg != "") {
		echo $errorMsg;
		include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
		die();
	}
	?>
	
    <!-- /.row -->
    <div class="row">
		<div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fas fa-calculator fa-lg"></i> Review
                </div>
				<div class="panel-body">
					<table class="table table-striped table-bordered table-hover" id="testTable">
						<thead>
							<tr class="tablerow">
								<th colspan="2" style="text-align:center">Selling</th>
							</tr>
						</thead>
						<tbody>
							<tr class="tablerow">
								<th>Material</th> <td><?php echo $sheet->material_name; ?></td>
							</tr>
							<tr class="tablerow">
								<th>Variant</th> <td><?php echo $sheet->variant_name; ?></td>
							</tr>
							<tr class="tablerow">
								<th>ID</th> <td><?php echo $sheet->id; ?></td>
							</tr>
							<tr class="tablerow">
								<th>Size</th> <td><?php echo $sheet->width.'x'.$sheet->height; ?></td>
							</tr>
							<tr class="tablerow">
								<th>Count</th> <td><?php echo $sell_amount; ?></td>
							</tr>
						</tbody>
					</table>
					<table class="table table-striped table-bordered table-hover" id="testTable">
						<thead>
							<tr class="tablerow">
								<th colspan="2" style="text-align:center">Inventory</th>
							</tr>
						</thead>
						<tbody>
							<tr class="tablerow">
								<th style="width:50%">Amount in Inventory</th> <td><?php echo $sheet->amount; ?></td>
							</tr>
							<tr class="tablerow">
								<th>Requires Cuts?</th> <td><?php echo ($has_cuts ? "Yes" : "No"); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fas fa-calculator"></i> Method of Payment
                </div>
                <form method="post" action="" onsubmit="return openWin()">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Payment </td>
                            <td><select name="selectPay" id="selectPay" onchange="updateBtn(this.value)">
                                <option hidden selected>Select</option>
								
                                <?php
									$user = Users::withID($_POST['mav_id']);
                                    $accounts = Accounts::listAccts($user, $staff);
                                    //$ac_owed = Acct_charge::checkOutstanding($ticket->getUser()->getOperator());
                                    //if (isset($ac_owed[$ticket->getTrans_id()])){
                                    //    unset($accounts[0]);
                                    //}
									$pre_select = "";
                                    foreach($accounts as $a){
                                        if ($pre_select == $a->getA_id()){
                                            echo("<option value='".$a->getA_id()."' title='".$a->getDescription()."' selected>".$a->getName()."</option>");
                                        } else {
                                            echo("<option value='".$a->getA_id()."' title='".$a->getDescription()."'>".$a->getName()."</option>");
                                        }
                                    }
									
                                ?>
                            </select></td>
                        </tr>
                        <tr>
                            <td>Payee</td>
                            <td><input type="text" class="form-control" placeholder="Enter ID #" value="<?php echo $_POST['mav_id'] ?>"
                                    maxlength="10" name="payee" id="payee"></td>
                        </tr>
                        <tr>
                            <td style="width:35%">Amount due</td>
                            <td>
                                <input type="hidden" id="totalCost" name="totalCost" value="<?php echo '$' . $total_cost; ?>"><b><?php echo '$' . $total_cost; ?></b></input>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /.panel-body -->
                <div class="panel-footer" align="right">
                    <button id="payBtn" name="payBtn" class="btn btn-primary" disabled>Submit</button>
                </div>
            </form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	var myWindow;
	var openBoolean = false;
	var btn = document.getElementById("payBtn");
	function openWin() {
		var selectPay = document.getElementById("selectPay").value;
		if (selectPay === "2" && (<?php echo $total_cost;?> >= .01)){
			if (!openBoolean) {
				myWindow = window.open("<?php echo $sv['paySite'];?>", "myWindow", "top=100,width=750,height=500");
				btn.classList.toggle("btn-danger");
				btn.innerHTML = "Confirm Payment";
				openBoolean = !openBoolean;
				return false;
			} else {
				var message = "Did you take payment from CSGold? \nDid you logout of <?php echo $sv['paySite_name'];?>?";
				var answer = confirm(message);
				if (answer){
					myWindow.close();
					btn.innerHTML = "Confirm Payment";
					setTimeout(function(){console.log("waiting");},1500);
					openBoolean = !openBoolean;
					return true;
				}
				openBoolean = !openBoolean;
				return false;
			}
		}
	}
	function updateBtn(x){
		if (x == 2){
			if (<?php echo $total_cost;?> >= .01){
				btn.innerHTML = "Launch <?php echo $sv['paySite_name'];?>";
			} else {
				btn.innerHTML = "Complete";
			}
		} else {
			btn.innerHTML = "Submit";
		}
		
		if (stdRegEx("payee", /^\d{10}$/, "Please enter ID #")){
			btn.disabled = false;
		} else {
			btn.disabled = true;
		}
		
	}


	window.onload = function() {
		<?php 
			//echo 'alert(\''.$_SESSION['Cuts'].'\');';
		?>
    };
</script>

<?php
//Standard call for dependencies
include_once ($_SERVER['DOCUMENT_ROOT'].'/pages/footer.php');
?>