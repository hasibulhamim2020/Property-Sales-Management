<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




// Include required JS
echo '<script type="text/javascript" src="../../../js/price_install.js"></script>';

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Price Installment';
$page  = 'price_installment.php';

$proj_id = $_SESSION['proj_id'];
$user_id = $_SESSION['user']['id'];

// Variables
$flat = 0;
$data = null;
$total_inst_amt = 0;

// If a flat is selected via search or GET, fetch its details
$input_source = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

if (isset($input_source['search'])) {
// if (isset($input_source['search']) && isset($input_source['flat']) && $input_source['flat'] > 0) {
    $flat = (int)$input_source['flat'];
    $proj_code = (int)$input_source['proj_code'];
    
    // Get flat data first to check party_code
    echo $sql_flat_check = "SELECT * FROM tbl_flat_info WHERE fid = '$flat' LIMIT 1";
    $q_flat = db_query($sql_flat_check);
    if ($q_flat && db_num_rows($q_flat) > 0) {
        $flat_obj = db_fetch_object($q_flat);
        $p_code = $flat_obj->party_code;
        
        echo $sql = "SELECT a.*, b.team_leader, b.sr_executive, b.group_leader, b.others, b.non_insentive, b.payment_type
                FROM tbl_flat_info a
                LEFT JOIN tbl_party_info b ON a.party_code = b.party_code
                WHERE a.fid = '$flat' LIMIT 1";
                die();


        $q = db_query($sql);
        if (db_num_rows($q) > 0) {
            $data = db_fetch_object($q);
            $section_name = $data->section_name;
            $proj_code = $data->proj_code;
        }
    }
}

// Handle form submission (Update All Information)
if (isset($_POST['count']) && $_POST['count'] > 0 && isset($_POST['flat']) && $_POST['flat'] > 0) {
    $c            = (int)$_REQUEST['count'];
    $proj_code    = (int)$_REQUEST['proj_code'];
    $building     = (int)$_REQUEST['building'];
    $flat         = (int)$_REQUEST['flat'];
    $flat_no      = db_escape($_REQUEST['flat_no']);
    $type         = db_escape($_REQUEST['b_type']);
    $flat_size    = (float)$_REQUEST['flat_size'];
    $floor_no     = db_escape($_REQUEST['floor_no']); // not used in update but kept
    $road         = db_escape($_REQUEST['road_no']);
    $facing       = db_escape($_REQUEST['facing']);
    $sqft_price   = (float)$_REQUEST['sqft_price'];
    $unit_price   = (float)$_REQUEST['unit_price'];
    $disc_price   = (float)$_REQUEST['disc_price'];
    $payable_price= (float)$_REQUEST['payable_price'];
    $development_fee = (float)$_REQUEST['park_price'];
    $total_price  = (float)$_REQUEST['total_price'];
    $party_code   = (int)$_REQUEST['party_code'];
    $entry_date   = date('Y-m-d');
    $executive    = $_POST['sr_executive_commission']; // not used in update
    $team_leader  = $_POST['team_leader_commission'];
    $group_leader = $_POST['group_leader_commission'];
    $other_commission = $_POST['other_commission'];
    $section_name = (int)$_POST['section_name'];

    // Update tbl_flat_info
    $update_res = "UPDATE tbl_flat_info
                   SET flat_no = '$flat_no',
                       floor_no = '$floor_no',
                       road_no = '$road',
                       b_type = '$type',
                       facing = '$facing',
                       flat_size = '$flat_size',
                       sqft_price = '$sqft_price',
                       unit_price = '$unit_price',
                       disc_price1 = '$disc_price',
                       development_fee = '$development_fee',
                       party_code = '$party_code',
                       total_price = '$total_price'
                   WHERE fid = '$flat' LIMIT 1";
    db_query($update_res);

    // Delete existing installments for this flat
    db_query("DELETE FROM tbl_flat_cost_installment WHERE fid = '$flat'");

    // Insert new installments
    for ($j = 1; $j <= $c; $j++) {
        if ($_REQUEST['deleted' . $j] == 'no') {
            $pay_code   = (int)$_REQUEST['a' . $j];
            $total_amt  = (float)$_REQUEST['b' . $j];
            $duration   = (int)$_REQUEST['c' . $j];
            $no_inst    = (int)$_REQUEST['d' . $j];
            $inst_amt   = (float)$_REQUEST['e' . $j];
            $inst_date  = $_REQUEST['f' . $j];

            for ($i = 0; $i < $no_inst; $i++) {
                $dur = $duration * $i;
                $stamp_inst_date = date_2_stamp_add_mon_duration($inst_date, $dur); // custom function
                $final_inst_date = date('Y-m-d', $stamp_inst_date);
                $inst_month = date('F', $stamp_inst_date);
                $int_year   = date('Y', $stamp_inst_date);
                $install_amt = $total_amt;
                $inst_no = $i + 1;

                $insert_res = "INSERT INTO tbl_flat_cost_installment
                               (proj_code, build_code, section_name, flat_no, fid, pay_code, party_code,
                                inst_no, inst_amount, inst_date, inst_month, int_year, rcv_status, rcv_amount,
                                entry_by, entry_date, rcv_date, rec_no, non_insentive, sr_executive_commission,
                                team_leader_commission, group_leader_commission, other_commission, commission_date)
                               VALUES
                               ('$proj_code', '$section_name', '$section_name', '$flat_no', '$flat', '$pay_code', '$party_code',
                                '$inst_no', '$install_amt', '$final_inst_date', '$inst_month', '$int_year', 0, 0,
                                '$user_id', '$entry_date', '', '', 0, 0, 0, 0, 0, '')";
                db_query($insert_res);
            }
        }
    }

    // Journal entry (optional – keep as is, assume functions exist)
    if ($total_price > 0) {
        $project_name = find_a_field('tbl_project_info', 'proj_name', "proj_code='$proj_code'");
        $build_type   = find_a_field('tbl_building_info', 'category', "bid='$building'");
        $ledger_name  = $flat_no . '(' . $build_type . ')' . '(' . $project_name . ')';
        $cr_ledger_id = find_a_field('tbl_flat_info', 'ledger_id', "proj_code='$proj_code' AND build_code='$building' AND flat_no='$flat_no'");
        $jv = next_journal_voucher_id();
        $narration = 'Paid for Flat ' . $ledger_name;
        // pay_invoice_amount($proj_id, $jv, $now, $cr_ledger_id, $dr_ledger_id, $narration, $total_price, 'Extended', $jv);
        // commented because dr_ledger_id is not set; adjust if needed
    }

    $msg = "Installments updated successfully.";
    $type = 1;
}
?>

<style>
.datagtable {
    border-bottom: 1px solid #CCC;
}
.datagtable td {
    border-left: 1px solid #CCC;
}
.datagtable input {
    border: 0;
}
.deleted, .deleted input {
    background: #F00;
    color: #FFF;
}
img {
    border: 0px;
}
.style3 { font-weight: bold; }
</style>

<script>
// Reusable AJAX function
function getData2(url, targetElement, projCode, sectionId) {
    if (projCode == '') return;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(targetElement).innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', url + '?proj_code=' + projCode + '&section_name=' + sectionId, true);
    xhr.send();
}

// Functions defined in price_install.js – placeholders here for clarity
function calculate_unitprice() { /* defined in external JS */ }
function calculate_payable() { /* defined in external JS */ }
function total_price_count() { /* defined in external JS */ }
function set_from_conf() { /* defined in external JS */ }
function set_inst_amt() { /* defined in external JS */ }
function check() { /* defined in external JS */ }
function check_ability() { /* defined in external JS */ }
</script>

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <div class="container n-form1 p-3">
                <form id="form" name="form" method="post" action="<?= $page ?>">
                    <h4 class="n-form-titel1">Price Installment Setup</h4>

                    <!-- Top three‑column row -->
                    <div class="row">
                        <!-- Left column: Project Details + Client Details -->
                        <div class="col-md-4">
                            <fieldset class="border p-2">
                                <legend>Project Details</legend>
                                
                                
                                <div class="form-group row m-0 pl-3 pr-3">
    <label class="col-sm-4 pl-0 pr-0 col-form-label">Project :</label>
    <div class="col-sm-8 p-0">
        <select name="proj_code" id="proj_code" class="form-control"
            onchange="getData2('section_ajax.php', 'section_id', this.value, '');">
            <option value="">-- Select Project --</option>
            <?php 
            foreign_relation(
                'tbl_project_info',
                'proj_code',
                'proj_name',
                isset($proj_code) ? $proj_code : '',
                ''
            ); 
            ?>
        </select>
    </div>
</div>

<div class="form-group row m-0 pl-3 pr-3">
    <label class="col-sm-4 pl-0 pr-0 col-form-label">Section :</label>
    <div class="col-sm-8 p-0">
        <span id="section_id">
            <select name="section_name" id="section_name" class="form-control">
                <option value="">-- Select Section --</option>
            </select>
        </span>
    </div>
</div>


                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Allotment :</label>
                                    <div class="col-sm-8 p-0">
                                        <span id="flat_span">
                                            <select name="flat" id="flat" class="form-control">
                                                <?php
                                                if ($flat > 0) {
                                                    foreign_relation('tbl_flat_info', 'fid', 'CONCAT("RN :", road_no ,"/", "PN ", flat_no)', $flat, '');
                                                } else {
                                                    echo '<option value=""></option>';
                                                }
                                                ?>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div class="n-form-btn-class">
                                    <input type="submit" name="search" id="search" class="btn1 btn1-bg-submit" value="Search details" />
                                </div>
                            </fieldset>

                            <fieldset class="border p-2 mt-2" style="background-color:#e6f2ff;">
                                <legend>Client Details</legend>
                                <div>
                                    <span id="bld">
                                        <span class="style3 text-info" style="font-size:14px;">
                                            <?php
                                            if (isset($data->party_code) && $data->party_code != '') {
                                                $sql = "SELECT a.* FROM tbl_party_info a WHERE a.party_code = " . $data->party_code . " LIMIT 1";
                                                $res = db_query($sql);
                                                if (db_num_rows($res) > 0) {
                                                    $info = db_fetch_object($res);
                                                    echo $info->party_name . '<br />' . $info->pre_house . '<br/>' . $info->ah_mobile_tel;
                                                }
                                            }
                                            ?>
                                        </span>
                                    </span>
                                    <input type="hidden" name="party_code" id="party_code" value="<?= isset($data->party_code) ? $data->party_code : '' ?>" />
                                </div>
                            </fieldset>
                        </div>

                        <!-- Middle column: Flat Details -->
                        <div class="col-md-4">
                            <fieldset class="border p-2">
                                <legend>Flat Details</legend>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Allotment :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="flat_no" id="flat_no" class="form-control" readonly value="<?= isset($data->flat_no) ? htmlspecialchars($data->flat_no) : '' ?>" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Block No. :</label>
                                    <div class="col-sm-8 p-0">
                                        <select name="b_type" id="b_type" class="form-control">
                                            <option value="<?= isset($data->b_type) ? $data->b_type : '' ?>"><?= isset($data->b_type) ? $data->b_type : '' ?></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Floor No. :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="road_no" id="road_no" class="form-control" readonly value="<?= isset($data->road_no) ? htmlspecialchars($data->road_no) : '' ?>" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Facing :</label>
                                    <div class="col-sm-8 p-0">
                                        <select name="facing" id="facing" class="form-control">
                                            <option value="<?= isset($data->facing) ? $data->facing : '' ?>"><?= isset($data->facing) ? $data->facing : '' ?></option>
                                            <option value="North">North</option>
                                            <option value="South">South</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Status :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="status" id="status" class="form-control" value="<?= isset($data->status) ? htmlspecialchars($data->status) : '' ?>" readonly />
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="border p-2 mt-2">
                                <legend>Totals</legend>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Total Price :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="total_price" id="total_price" class="form-control" readonly value="<?= isset($data->total_price) ? $data->total_price : '' ?>" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Config. Amnt. :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="conf_amt" id="conf_amt" class="form-control" readonly />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <!-- Right column: Price Details -->
                        <div class="col-md-4">
                            <fieldset class="border p-2">
                                <legend>Price Details</legend>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Allotment size :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="flat_size" id="flat_size" class="form-control" readonly value="<?= isset($data->flat_size) ? $data->flat_size : '' ?>" onchange="calculate_unitprice();calculate_payable();total_price_count();" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Rate per Sft :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="sqft_price" id="sqft_price" class="form-control" readonly value="<?= isset($data->sqft_price) ? $data->sqft_price : '' ?>" onchange="calculate_unitprice();calculate_payable();total_price_count();" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Price :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="unit_price" id="unit_price" class="form-control" readonly value="<?= isset($data->unit_price) ? $data->unit_price : '' ?>" onchange="calculate_payable();total_price_count();" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Disct. Amount :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="disc_price" id="disc_price" class="form-control" readonly value="<?= isset($data->discount) ? $data->discount : '' ?>" onchange="calculate_payable();total_price_count();" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Payable Price :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="payable_price" id="payable_price" class="form-control" value="<?= (isset($data->unit_price) && isset($data->discount)) ? ($data->unit_price - $data->discount) : '' ?>" readonly onchange="total_price_count();" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Utility Charge :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="utility_price" id="utility_price" class="form-control" value="<?= isset($data->utility_price) ? $data->utility_price : '' ?>" readonly onchange="total_price_count();" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Reserve Fund :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="oth_price" id="oth_price" class="form-control" value="<?= isset($data->reserve) ? $data->reserve : '' ?>" readonly onchange="total_price_count();" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Parking :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="park_price" id="park_price" class="form-control" value="<?= isset($data->park_price) ? $data->park_price : '' ?>" readonly onchange="total_price_count();" />
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <!-- Installment Entry Table -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table table-bordered" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th>Payment Head</th>
                                        <th>Amount</th>
                                        <th>Duration (M)</th>
                                        <th>Total Inst.</th>
                                        <th>Inst. Amount</th>
                                        <th>On or Before</th>
                                        <th rowspan="2" style="vertical-align:middle;">
                                            <div class="button">
                                                <input type="button" name="add" id="add" value="ADD" class="btn1 btn1-bg-submit" onclick="check();" style="width:60px;" />
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="pay_code" id="pay_code" class="form-control" onchange="set_from_conf()">
                                                <?php foreign_relation('tbl_payment_head', 'pay_code', 'pay_desc', '', ''); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <span id="cur">
                                                <input type="text" name="amt" id="amt" class="form-control" onchange="set_inst_amt()" />
                                            </span>
                                        </td>
                                        <td><input type="text" name="duration" id="duration" class="form-control" /></td>
                                        <td><input type="text" name="no_inst" id="no_inst" class="form-control" onchange="set_inst_amt()" /></td>
                                        <td><input type="text" name="inst_amt" id="inst_amt" class="form-control" readonly /></td>
                                        <td><input type="text" name="b_date" id="b_date" class="form-control datepicker" /></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7">
                                            <span id="tbl">
                                                <?php
                                                if (isset($flat) && $flat > 0) {
                                                    $sql = "SELECT pay_code, COUNT(*) AS no_inst, MIN(inst_date) AS inst_date,
                                                                   SUM(inst_amount) AS total_amount, AVG(inst_amount) AS avg_inst_amt
                                                            FROM tbl_flat_cost_installment
                                                            WHERE fid = '$flat'
                                                            GROUP BY pay_code";
                                                    $query = db_query($sql);
                                                    if (db_num_rows($query) > 0) {
                                                        $i = 0;
                                                        $total_inst_amt = 0;
                                                        while ($info = db_fetch_array($query)) {
                                                            $i++;
                                                            $data_row = array(
                                                                'a' => $info['pay_code'],
                                                                'b' => $info['avg_inst_amt'], // total amount per installment? original used inst_amount (single)
                                                                'c' => 1, // original had duration? not used
                                                                'd' => $info['no_inst'],
                                                                'e' => $info['total_amount'],
                                                                'f' => $info['inst_date']
                                                            );
                                                            $count = $i;
                                                            $ins_name = find_a_field('tbl_payment_head', 'pay_short', "pay_code='" . $data_row['a'] . "'");
                                                ?>
                                                <table id="rowid<?= $count ?>" class="table table-sm table-bordered w-100">
                                                    <tr align="left" id="rowid<?= $count ?>" height="30">
                                                        <td width="600">
                                                            <input type="text" name="a<?= $count ?>" class="form-control" value="<?= $data_row['a'] ?>" readonly />
                                                            <?= $ins_name ?>
                                                        </td>
                                                        <td width="220"><input type="text" name="b<?= $count ?>" class="form-control" value="<?= $data_row['b'] ?>" readonly /></td>
                                                        <td width="91"><input type="text" name="c<?= $count ?>" class="form-control" value="<?= $data_row['c'] ?>" readonly /></td>
                                                        <td width="144"><input type="text" name="d<?= $count ?>" class="form-control" value="<?= $data_row['d'] ?>" readonly /></td>
                                                        <td width="115"><input type="text" name="e<?= $count ?>" class="form-control" value="<?= $data_row['e'] ?>" readonly /></td>
                                                        <td width="117"><input type="text" name="f<?= $count ?>" class="form-control" value="<?= $data_row['f'] ?>" readonly /></td>
                                                        <td width="50"><a href="#" onclick="deletethis<?= $count ?>();"><img src="../../../images/delete.png" width="16" height="16" /></a></td>
                                                    </tr>
                                                </table>
                                                <input name="deleted<?= $count ?>" id="deleted<?= $count ?>" type="hidden" value="no" />
                                                <script type="text/javascript">
                                                function deletethis<?= $count ?>() {
                                                    document.getElementById('rowid<?= $count ?>').className = 'deleted';
                                                    document.getElementById("conf_amt").value = (document.getElementById("conf_amt").value * 1) - (document.getElementById("e<?= $count ?>").value * 1);
                                                    document.getElementById('deleted<?= $count ?>').value = 'yes';
                                                    document.getElementById('rowid<?= $count ?>').style.display = 'none';
                                                }
                                                </script>
                                                <?php
                                                            $total_inst_amt += $data_row['e'];
                                                        }
                                                        echo "<script>document.getElementById('conf_amt').value = " . number_format($total_inst_amt, 2, '.', '') . ";</script>";
                                                    }
                                                }
                                                ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Save button -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <input type="button" name="save" id="save" class="btn1 btn1-bg-submit" value="Update All Information" onclick="check_ability()" style="width:150px;" />
                        </div>
                    </div>

                    <!-- Hidden count field -->
                    <input type="hidden" name="count" id="count" value="<?= isset($count) && $count > 0 ? $count : '' ?>" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>