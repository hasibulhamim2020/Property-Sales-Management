<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// Include required JS for receipt handling (adjust path as needed)
echo '<script type="text/javascript" src="../../../js/receipt_install.js"></script>';

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Money Receipt (Fine)';
$page  = 'money_receipt.php';

$proj_id = $_SESSION['proj_id'];
$user_id = $_SESSION['user']['id'];

// Date picker for cheque date
do_calander('#c_date');

// Variables
$flat = 0;
$data = null;
$flat_no = '';

// If a flat is selected via POST, fetch its details
if (isset($_POST['flat']) && $_POST['flat'] > 0) {
    $flat = (int)$_POST['flat'];
    $_SESSION["fid"] = $flat;
    
    $sql = "SELECT a.*, b.team_leader, b.sr_executive, b.group_leader, b.others, b.non_insentive, b.payment_type
            FROM tbl_flat_info a
            JOIN tbl_party_info b ON a.party_code = b.party_code
            WHERE a.fid = '$flat' LIMIT 1";
    $q = db_query($sql);
    if (db_num_rows($q) > 0) {
        $data = db_fetch_object($q);
        $flat_no = $data->flat_no;
    }
}

// Handle form submission (Save)
if (isset($_POST['save'])) {
    $building    = (int)$_REQUEST['building'];
    $flat        = (int)$_REQUEST['flat'];
    $flat_no     = db_escape($_REQUEST['flat_no']);
    $rec_date    = $_SESSION['rec_date'] = $_REQUEST['rec_date'];
    $amount      = (float)$_REQUEST['amount'];
    $party_code  = (int)$_REQUEST['party_code'];
    $pay_mode    = (int)$_REQUEST['pay_mode'];
    $cheq_no     = db_escape($_REQUEST['c_no']);
    $cheq_date   = $_REQUEST['c_date'];
    $bank_name   = db_escape($_REQUEST['bank']);
    $branch      = db_escape($_REQUEST['branch']);
    $manual_no   = db_escape($_REQUEST['manual_no']);
    $remarks     = db_escape($_REQUEST['remarks']);
    $get_mode    = db_escape($_REQUEST['get_mode']); // 'Weaver' or 'Receive'
    $pay_code    = (int)$_REQUEST['pay_code'];
    $inst_no     = (int)$_REQUEST['inst_no'];

    $entry_by = $_SESSION['user']['id'];
    $rec_no   = next_value('rec_no', 'tbl_fine');

    $sql = "INSERT INTO tbl_fine
            (rec_no, manual_no, fid, rec_date, party_code, pay_code, inst_no, narration,
             get_mode, pay_mode, cheq_no, cheq_date, bank_name, branch, amount, entry_by,
             inst_month, inst_year, remarks)
            VALUES
            ('$rec_no', '$manual_no', '$flat', '$rec_date', '$party_code', '$pay_code', '$inst_no', '$remarks',
             '$get_mode', '$pay_mode', '$cheq_no', '$cheq_date', '$bank_name', '$branch', '$amount', '$entry_by',
             '', '', '')";
    db_query($sql);

    $msg = "Fine receipt saved successfully.";
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
</style>

<script>
// AJAX function to load sections and flats
function getData2(url, targetElement, projCode, sectionId) {
    if (projCode == '' || sectionId == '') return;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(targetElement).innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', url + '?proj_code=' + projCode + '&section_name=' + sectionId, true);
    xhr.send();
}
</script>

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <div class="container n-form1 p-3">
                <form id="form1" name="form1" method="post" action="<?= $page ?>">
                    <h4 class="n-form-titel1">Money Receipt (Fine/Penalty)</h4>

                    <!-- Top three-column layout: Project, Receipt Details, Summary -->
                    <div class="row">
                        <!-- Left: Project Details -->
                        <div class="col-md-4">
                            <fieldset class="border p-2">
                                <legend>Project Details</legend>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Project :</label>
                                    <div class="col-sm-8 p-0">
                                        <select name="proj_code" id="proj_code" class="form-control" onchange="getData2('../../common/section_option_mhafuz.php', 'bld', this.value, '');">
                                            <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', isset($proj_code) ? $proj_code : 0, ''); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Section :</label>
                                    <div class="col-sm-8 p-0">
                                        <span id="bld">
                                            <select name="section_name" id="section_name" class="form-control" onchange="getData2('../../common/flat_option_mhafuz.php', 'flat_span', document.getElementById('proj_code').value, this.value);">
                                                <?php foreign_relation('tbl_add_section', 'section_id', 'section_name', isset($section_name) ? $section_name : 0, ''); ?>
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
                                    <input type="submit" name="search" class="btn1 btn1-bg-submit" value="Search details" />
                                    <input type="hidden" name="flat_no" id="flat_no" value="<?= $flat_no ?>" />
                                </div>
                            </fieldset>

                            <!-- Client Details (simple display) -->
                            <fieldset class="border p-2 mt-2" style="background-color:#e6f2ff;">
                                <legend>Client Details</legend>
                                <div>
                                    <span id="bld">
                                        <span class="text-info" style="font-size:14px;">
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

                        <!-- Middle: Receipt Details -->
                        <div class="col-md-4">
                            <fieldset class="border p-2">
                                <legend>Receipt Details</legend>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Receipt No. :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="receipt_no" class="form-control" value="<?= next_value('rec_no', 'tbl_fine') ?>" readonly />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Manual No. :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="manual_no" class="form-control" value="" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Receipt Date :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="date" name="rec_date" id="rec_date" class="form-control datepicker" value="<?= (isset($_SESSION['rec_date']) && $_SESSION['rec_date']!='') ? $_SESSION['rec_date'] : date('Y-m-d') ?>" />
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="border p-2 mt-2">
                                <legend>Payment Details</legend>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Payment Mode :</label>
                                    <div class="col-sm-8 p-0">
                                        <select name="pay_mode" id="pay_mode" class="form-control" required>
                                            <option value="1">Cheque/PO</option>
                                            <option value="0">Cash</option>
                                            <option value="2">Bank Transfer</option>
                                            <option value="3">Discount</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Cheque/PO No. :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="c_no" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Cheque Date :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="date" name="c_date" id="c_date" class="form-control datepicker" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Bank Name :</label>
                                    <div class="col-sm-8 p-0">
                                        <select name="bank" id="bank" class="form-control">
                                            <?php foreign_relation('tbl_bank', 'bank', 'bank', isset($bank) ? $bank : '', ''); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Branch :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="branch" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group row m-0 pl-3 pr-3">
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Remarks :</label>
                                    <div class="col-sm-8 p-0">
                                        <textarea name="remarks" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <!-- Right: Summary (last 5 fines) -->
                        <div class="col-md-4">
                            <div class="tabledesign1">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="bgc-info">
                                            <th>No</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($flat) && $flat > 0) {
                                            $sql1 = "SELECT b.rec_no, b.get_mode, b.amount
                                                     FROM tbl_fine b
                                                     JOIN tbl_flat_info c ON b.fid = c.fid
                                                     WHERE c.fid = '$flat'
                                                     ORDER BY b.rec_no DESC
                                                     LIMIT 5";
                                            $res1 = db_query($sql1);
                                            while ($row = db_fetch_object($res1)) {
                                                echo '<tr>';
                                                echo '<td>' . $row->rec_no . '</td>';
                                                echo '<td>' . htmlspecialchars($row->get_mode) . '</td>';
                                                echo '<td>' . number_format($row->amount, 2) . '</td>';
                                                echo '<td><a href="../../common/voucher_print.php?rec_no=' . $row->rec_no . '&fid=' . $flat . '" target="_blank"><img src="../../../images/print.png" width="16" height="16" border="0"></a></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Fine Entry Row -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table table-bordered" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th>Payment Head</th>
                                        <th>Installment No.</th>
                                        <th>Type</th>
                                        <th>Receive Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="pay_code" id="pay_code" class="form-control" onchange="getData2('ajax_ins.php', 'inst_no', this.value, this.value);">
                                                <?php
                                                if ($flat > 0) {
                                                    $sql = "SELECT DISTINCT a.pay_code, a.pay_desc
                                                            FROM tbl_payment_head a
                                                            JOIN tbl_flat_cost_installment b ON a.pay_code = b.pay_code
                                                            WHERE b.fid = '$flat'";
                                                    join_relation($sql, '');
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <span id="inst_no">
                                                <select name="inst_no" id="inst_no" class="form-control">
                                                    <!-- Options will be loaded via AJAX -->
                                                </select>
                                            </span>
                                        </td>
                                        <td>
                                            <select name="get_mode" id="get_mode" class="form-control" required>
                                                <option value="Weaver">Weaver</option>
                                                <option value="Receive">Receive</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="amount" id="amount" class="form-control" style="width:100px;" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <input type="submit" name="save" class="btn1 btn1-bg-submit" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>