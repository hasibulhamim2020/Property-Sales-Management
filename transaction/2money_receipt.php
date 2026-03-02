<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


// Include required JS for receipt handling
// echo '<script type="text/javascript" src="../../../js/receipt_install.js"></script>';

// Include journal functions if not already loaded
// Assuming they are in a separate file; adjust path as needed
// require_once SERVER_CORE . "functions/journal_functions.php"; // or wherever they reside

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Money Receipt';
$page  = 'money_receipt.php';

$proj_id = $_SESSION['proj_id'];
$user_id = $_SESSION['user']['id'];

// Date picker
do_calander('#rec_date');
do_calander('#c_date');

// Variables
$flat = 0;
$data = null;
$flat_no = '';

// If a flat is selected via POST, fetch its details
if (isset($_POST['flat']) && $_POST['flat'] > 0) {
    $flat = (int)$_POST['flat'];
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
if (isset($_POST['save']) && isset($_REQUEST['count']) && $_REQUEST['count'] > 0) {
    $c = (int)$_REQUEST['count'];
    $proj_code   = (int)$_REQUEST['proj_code'];
    $building    = (int)$_REQUEST['building'];
    $flat        = (int)$_REQUEST['flat'];
    $flat_no     = db_escape($_REQUEST['flat_no']);
    $rec_date    = $_SESSION['rec_date'] = $_REQUEST['rec_date'];
    $total_amount = (float)$_REQUEST['total_amount'];
    $party_code   = (int)$_REQUEST['party_code'];
    $pay_mode     = (int)$_REQUEST['pay_mode'];
    $cheq_no      = db_escape($_REQUEST['c_no']);
    $cheq_date    = $_REQUEST['c_date'];
    $bank_name    = db_escape($_REQUEST['bank']);
    $branch       = db_escape($_REQUEST['branch']);
    $manual_no    = db_escape($_REQUEST['manual_no']);
    $remarks      = db_escape($_REQUEST['remarks']);

    // Fetch party commission percentages
    $msql = "SELECT * FROM tbl_party_info WHERE party_code = '$party_code'";
    $mquery = db_query($msql);
    $party = db_fetch_object($mquery);

    // Determine commission percentages based on which roles exist
    if ($party->group_leader > 0 && $party->team_leader > 0 && $party->sr_executive > 0) {
        $non_insentive_per = '0';
        $group_leader_per  = '0.0010';
        $team_leader_per   = '0.0010';
        $sr_executive_per  = '0.0065';
        $other_per         = '0.0015';
    } elseif ($party->group_leader > 0 && $party->team_leader > 0 && $party->sr_executive < 1) {
        $non_insentive_per = '0';
        $group_leader_per  = '0.0010';
        $team_leader_per   = '0.0075';
        $sr_executive_per  = '0.00';
        $other_per         = '0.0015';
    } elseif ($party->group_leader > 0 && $party->team_leader < 1 && $party->sr_executive < 1) {
        $non_insentive_per = '0';
        $group_leader_per  = '0.0085';
        $team_leader_per   = '0';
        $sr_executive_per  = '0';
        $other_per         = '0.0015';
    } else {
        $non_insentive_per = '0';
        $group_leader_per  = '0';
        $team_leader_per   = '0';
        $sr_executive_per  = '0';
        $other_per         = '0.0015';
    }

    $p_by = $_SESSION['user']['id'];
    $rec_no = next_value('rec_no', 'tbl_receipt');

    for ($j = 1; $j <= $c; $j++) {
        if ($_REQUEST['deleted' . $j] == 'no') {
            $pay_code   = (int)$_REQUEST['a' . $j];
            $desc       = db_escape($_REQUEST['b' . $j]);
            $no_inst    = (int)$_REQUEST['c' . $j];
            $inst_amt   = (float)$_REQUEST['d' . $j];
            $rec_amount = (float)$_REQUEST['e' . $j];
            $fid        = (int)$_REQUEST['f' . $j];

            // Commission calculation
            if ($pay_code == 98) { // Development Fee (no commission)
                $non_insentive_commission = 0;
                $group_leader_commission  = 0;
                $team_leader_commission   = 0;
                $sr_executive_commission  = 0;
                $other_commission         = 0;
            } else {
                $non_insentive_commission = $rec_amount * $non_insentive_per;
                $group_leader_commission  = $rec_amount * $group_leader_per;
                $team_leader_commission   = $rec_amount * $team_leader_per;
                $sr_executive_commission  = $rec_amount * $sr_executive_per;
                $other_commission         = $rec_amount * $other_per;
            }

            // Insert into receipt_details
            $sql2 = "INSERT INTO tbl_receipt_details
                     (rec_no, pay_code, inst_no, fid, inst_amount, rec_amount, p_by, remarks,
                      non_insentive_commission, sr_executive_commission, team_leader_commission,
                      group_leader_commission, other_commission, manual_date)
                     VALUES
                     ('$rec_no', '$pay_code', '$no_inst', '$fid', '$inst_amt', '$rec_amount', '$p_by', '$remarks',
                      '$non_insentive_commission', '$sr_executive_commission', '$team_leader_commission',
                      '$group_leader_commission', '$other_commission', '$rec_date')";
            db_query($sql2);

            $add_sql = ($inst_amt == $rec_amount) ? ", rcv_status = 1" : "";

            // Update tbl_flat_cost_installment
            $sql3 = "UPDATE tbl_flat_cost_installment
                     SET rec_no = '$rec_no',
                         rcv_date = '$rec_date',
                         rcv_amount = rcv_amount + '$rec_amount',
                         non_insentive = non_insentive + '$non_insentive_commission',
                         sr_executive_commission = sr_executive_commission + '$sr_executive_commission',
                         team_leader_commission = team_leader_commission + '$team_leader_commission',
                         group_leader_commission = group_leader_commission + '$group_leader_commission',
                         other_commission = other_commission + '$other_commission'
                         $add_sql
                     WHERE fid = '$fid' AND pay_code = '$pay_code' AND inst_no = '$no_inst'
                     LIMIT 1";
            db_query($sql3);
        }
    }

    // Insert into receipt header
    $sql = "INSERT INTO tbl_receipt
            (proj_code, rec_no, rec_date, party_code, flat_no, narration, pay_mode, cheq_no,
             fid, cheq_date, bank_name, branch, rec_amount, manual_no, remarks,
             manual_date, build_code, check_realize_reason, check_realize_status)
            VALUES
            ('$proj_code', '$rec_no', '$rec_date', '$party_code', '$flat_no', '$desc', '$pay_mode', '$cheq_no',
             '$flat', '$cheq_date', '$bank_name', '$branch', '$total_amount', '$manual_no', '$remarks',
             '$rec_date', '$building', '', '0')";
    db_query($sql);

    // Update flat status based on due amount
    $select = "SELECT fid, SUM(inst_amount) AS total_p, SUM(rcv_amount) AS total_r,
                      (SUM(inst_amount)-SUM(rcv_amount)) AS total_due_amt
               FROM tbl_flat_cost_installment
               WHERE fid = '$flat'
               GROUP BY fid";
    $q = db_query($select);
    $r = db_fetch_object($q);
    if ($r->total_due_amt <= 0) {
        db_query("UPDATE tbl_flat_info SET status='Sold' WHERE fid='$flat'");
    }

    $t_twentyfive_percentage = ($r->total_p / 100) * 25;
    $t_ninetynine_percentage = ($r->total_p / 100) * 99;

    if ($r->total_r < $t_twentyfive_percentage) {
        db_query("UPDATE tbl_flat_info SET sr_status='BOOKING' WHERE fid='$flat'");
    } elseif ($r->total_r < $t_ninetynine_percentage) {
        db_query("UPDATE tbl_flat_info SET sr_status='AGREEMENT' WHERE fid='$flat'");
    } else {
        db_query("UPDATE tbl_flat_info SET sr_status='SOLD' WHERE fid='$flat'");
    }

    // Journal entries (sec journal)
    $jv_no = next_journal_sec_voucher_id33();
    $flat_info = find_all_field('tbl_flat_info', '*', "fid='$flat'");
    $party_acc = $flat_info->acc_no;
    $party_name = find_a_field('tbl_party_info', 'party_name', "party_code='$party_code'");
    $cc_code = find_one("SELECT p.proj_cc FROM tbl_project_info p, tbl_flat_info f
                         WHERE p.proj_code = f.proj_code AND f.fid = '$flat'");

    if ($pay_mode == 0) { // Cash
        $dr_head = '1145000100040000';
        $narration_dr = "Received From $party_name, Against: $flat_no";
        $narration_cr = "MR no: $rec_no Against: $flat_no. MMR: $manual_no";
    } elseif ($pay_mode == 4) { // Adjustment
        $dr_head = '4081000100170000';
        $narration_dr = "Adjustment For $party_name, Against: $flat_no";
        $narration_cr = "MR no: $rec_no Against: $flat_no. MMR: $manual_no";
    } elseif ($pay_mode == 3) { // Discount
        $dr_head = '4082000100560000';
        $narration_dr = "Discount For $party_name, Against: $flat_no";
        $narration_cr = "MR no: $rec_no Against: $flat_no. MMR: $manual_no";
    } else { // Cheque/PO etc.
        $dr_head = '1147000200020000';
        $narration_dr = "Received From $party_name, Against: $flat_no. CQ No: $cheq_no, CQ Date: $cheq_date, Bank: $bank_name";
        $narration_cr = "MR no: $rec_no Against: $flat_no. MMR: $manual_no. CQ No: $cheq_no, CQ Date: $cheq_date, Bank: $bank_name";
    }
    $page_for = 'Collection';
    $oi_no = $rec_no;

    add_to_sec_journal33($proj_id, $jv_no, strtotime($rec_date), $dr_head, $narration_dr, $total_amount, 0, $page_for, $oi_no, '', '', $cc_code);
    add_to_sec_journal33($proj_id, $jv_no, strtotime($rec_date), $party_acc, $narration_cr, 0, $total_amount, $page_for, $oi_no, '', '', $cc_code);
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
// AJAX functions (reused from previous migrations)
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

function set_install(flat, payCode) {
    // This function is defined in receipt_install.js; we keep it here for reference.
    // It should fetch installment details for the selected payment head.
}

function check() {
    // Add row logic – defined in receipt_install.js
}
</script>

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <div class="container n-form1 p-3">
                <form id="form1" name="form1" method="post" action="<?= $page ?>">
                    <h4 class="n-form-titel1">Money Receipt</h4>

                    <!-- Top three‑column layout: Project, Receipt Details, Summary -->
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
                                        <input type="text" name="receipt_no" class="form-control" value="<?= next_value('rec_no','tbl_receipt') ?>" readonly />
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
                                            <option value="4">Adjustment</option>
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
                                    <label class="col-sm-4 pl-0 pr-0 col-form-label">Total Amount :</label>
                                    <div class="col-sm-8 p-0">
                                        <input type="text" name="total_amount" id="total_amount" class="form-control" readonly />
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

                        <!-- Right: Summary (last receipts and totals) -->
                        <div class="col-md-4">
                            <div class="tabledesign1">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="bgc-info">
                                            <th>Last 3 Receipt No</th>
                                            <th>Rec Amount</th>
                                            <th>Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($flat) && $flat > 0) {
                                            $sql1 = "SELECT b.rec_no, SUM(b.rec_amount) AS total, b.rec_date
                                                     FROM tbl_receipt b
                                                     JOIN tbl_flat_info c ON b.fid = c.fid
                                                     WHERE c.fid = '$flat'
                                                     GROUP BY b.rec_no
                                                     ORDER BY b.rec_no DESC
                                                     LIMIT 3";
                                            $res1 = db_query($sql1);
                                            while ($row = db_fetch_row($res1)) {
                                                echo '<tr>';
                                                echo '<td>' . $row[0] . '</td>';
                                                echo '<td>' . number_format($row[1], 2) . '</td>';
                                                echo '<td><a href="../../common/voucher_print.php?rec_no=' . $row[0] . '&fid=' . $flat . '&rec_date=' . $row[2] . '" target="_blank"><img src="../../../images/print.png" width="16" height="16" border="0"></a></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <?php if (isset($flat) && $flat > 0) {
                                    $sql1 = "SELECT SUM(b.inst_amount), SUM(b.rcv_amount)
                                             FROM tbl_flat_cost_installment b
                                             JOIN tbl_flat_info c ON b.fid = c.fid
                                             WHERE c.fid = '$flat'";
                                    $res1 = db_query($sql1);
                                    if ($row = db_fetch_row($res1)) {
                                ?>
                                <table class="table table-sm table-bordered mt-2">
                                    <thead>
                                        <tr class="bgc-info">
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td>Total Payable</td><td><?= number_format($row[0], 2) ?></td></tr>
                                        <tr><td>Total Paid</td><td><?= number_format($row[1], 2) ?></td></tr>
                                        <tr><td>Total Due</td><td><?= number_format($row[0] - $row[1], 2) ?></td></tr>
                                    </tbody>
                                </table>
                                <?php } } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Commission Details Row -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <fieldset class="border p-2">
                                <legend>Commission Detail</legend>
                                <input type="hidden" name="sr_executive_commission1" id="sr_executive_commission1" value="<?= isset($data->sr_executive_commission) ? $data->sr_executive_commission : '' ?>" />
                                <input type="hidden" name="non_insentive1" id="non_insentive1" value="<?= isset($data->non_insentive) ? $data->non_insentive : '' ?>" />
                                <input type="hidden" name="team_leader_commission1" id="team_leader_commission1" value="<?= isset($data->team_leader_commission) ? $data->team_leader_commission : '' ?>" />
                                <input type="hidden" name="group_leader_commission1" id="group_leader_commission1" value="<?= isset($data->group_leader_commission) ? $data->group_leader_commission : '' ?>" />
                                <input type="hidden" name="other_commission1" id="other_commission1" value="<?= isset($data->other_commission) ? $data->other_commission : '' ?>" />

                            
                            <table style="width:auto; border-collapse:collapse; width: 100%;">
                <tr>
                    <td style="padding:4px 8px; white-space:nowrap;">Sr Executive :</td>
                    <td style="padding:4px 8px;">
                        <select name="sr_executive" id="sr_executive" class="form-control" style="width:200px;">
                            <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', isset($data->sr_executive) ? $data->sr_executive : '', ''); ?>
                        </select>
                    </td>
                    <td style="padding:4px 8px;">
                        <input type="text" name="sr_executive_commission" id="sr_executive_commission" class="form-control" style="width:150px;" />
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 8px; white-space:nowrap;">Non Insentive :</td>
                    <td style="padding:4px 8px;">
                        <select name="non_insentive" id="non_insentive" class="form-control" style="width:200px;">
                            <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', isset($data->non_insentive) ? $data->non_insentive : '', ''); ?>
                        </select>
                    </td>
                    <td style="padding:4px 8px;">
                        <input type="text" name="non_insentive_commission" id="non_insentive_commission" class="form-control" style="width:150px;" />
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 8px; white-space:nowrap;">Team Leader :</td>
                    <td style="padding:4px 8px;">
                        <select name="team_leader" id="team_leader" class="form-control" style="width:200px;">
                            <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', isset($data->team_leader) ? $data->team_leader : '', ''); ?>
                        </select>
                    </td>
                    <td style="padding:4px 8px;">
                        <input type="text" name="team_leader_commission" id="team_leader_commission" class="form-control" style="width:150px;" />
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 8px; white-space:nowrap;">Group Leader :</td>
                    <td style="padding:4px 8px;">
                        <select name="group_leader" id="group_leader" class="form-control" style="width:200px;">
                            <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', isset($data->group_leader) ? $data->group_leader : '', ''); ?>
                        </select>
                    </td>
                    <td style="padding:4px 8px;">
                        <input type="text" name="group_leader_commission" id="group_leader_commission" class="form-control" style="width:150px;" />
                    </td>
                </tr>
                <tr>
                    <td style="padding:4px 8px; white-space:nowrap;">Others :</td>
                    <td style="padding:4px 8px;">
                        <select name="others" id="others" class="form-control" style="width:200px;">
                            <option>Others</option>
                        </select>
                    </td>
                    <td style="padding:4px 8px;">
                        <input type="text" name="other_commission" id="other_commission" class="form-control" style="width:150px;" />
                    </td>
                </tr>
            </table>





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
                                        <th>Installment No.</th>
                                        <th>Installment Date</th>
                                        <th>Installment Amount</th>
                                        <th>Receive Amount</th>
                                        <th rowspan="2">
                                            <div class="button">
                                                <input type="button" name="add" id="add" value="ADD" class="btn1 btn1-bg-submit" onclick="check();" />
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="pay_code" id="pay_code" class="form-control" onchange="set_install(<?= $flat ?>, this.value);">
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
                                                <input type="text" name="installment_no" id="installment_no" class="form-control" style="width:100px;" />
                                            </span>
                                        </td>
                                        <td>
                                            <span id="inst_date">
                                                <input type="text" name="desc" id="desc" class="form-control" style="width:100px;" readonly />
                                            </span>
                                        </td>
                                        <td>
                                            <span id="inst_amt">
                                                <input type="text" name="installment_amt" id="installment_amt" class="form-control" style="width:100px;" readonly />
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" name="receive_amt" id="receive_amt" class="form-control" style="width:100px;" />
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6">
                                            <span id="tbl">
                                                <table id="rowid<?= $count ?>" class="table table-sm table-bordered" width="100%">
                                                    <tr id="rowid<?= $count ?>" height="30">
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td width="100"></td>
                                                    </tr>
                                                </table>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Hidden count and Save button -->
                    <input type="hidden" name="count" id="count" value="<?= isset($count) && $count > 0 ? $count : '' ?>" />
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <input type="submit" name="save" class="btn1 btn1-bg-submit" value="Update All Information" onclick="check_ability()" />
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