<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Allotment Wise Installment';
$page  = 'allotment_wise_installment.php';

// Get submitted values
$proj_code   = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$section_name = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
$flat        = isset($_REQUEST['flat']) ? (int)$_REQUEST['flat'] : 0;

$client_info = '';
$address     = '';
$mobile      = '';
$total_inst  = 0;
$total_rcv   = 0;

// If form submitted, fetch client details and payment head summary
if (isset($_POST['submit']) && $flat > 0) {
    // Get flat and party info
    $sql_flat = "SELECT party_code, proj_code, build_code, flat_no 
                 FROM tbl_flat_info 
                 WHERE fid = '$flat' LIMIT 1";
    $res_flat = db_query($sql_flat);
    if (db_num_rows($res_flat) > 0) {
        $flat_data = db_fetch_object($res_flat);
        $party_code = $flat_data->party_code;

        $sql_party = "SELECT party_name, pre_house, per_road, per_village, per_postoffice, per_district, ah_mobile_tel 
                      FROM tbl_party_info 
                      WHERE party_code = '$party_code' LIMIT 1";
        $res_party = db_query($sql_party);
        if (db_num_rows($res_party) > 0) {
            $party = db_fetch_object($res_party);
            $client_info = $party->party_name;
            $address = trim($party->pre_house . ', ' . $party->per_road . ', ' . $party->per_village . ', ' . $party->per_postoffice . ', ' . $party->per_district, ', ');
            $mobile = $party->ah_mobile_tel;
        }

        // Get totals
        $sql_total = "SELECT SUM(inst_amount), SUM(rcv_amount) 
                      FROM tbl_flat_cost_installment 
                      WHERE proj_code = '{$flat_data->proj_code}' 
                        AND build_code = '{$flat_data->build_code}' 
                        AND flat_no = '{$flat_data->flat_no}' 
                      LIMIT 1";
        $res_total = db_query($sql_total);
        if ($row_total = db_fetch_row($res_total)) {
            $total_inst = $row_total[0];
            $total_rcv  = $row_total[1];
        }
    }
}
?>

<script>
// Function to load flats based on project and section (AJAX)
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

// Function to show receipt details (could open a popup)
function getData(url, targetDiv, recNo) {
    // Example: load receipt details into a modal or a new window
    // For simplicity, we'll open a new window.
    window.open(url + '?rec_no=' + recNo, '_blank', 'width=800,height=600');
}
</script>

<div class="container-fluid p-0">
    <!-- Top two-column form -->
    <div class="row">
        <!-- Left: Project Details -->
        <div class="col-sm-6">
            <div class="container n-form1 p-3">
                <form action="<?= $page ?>" method="post" name="form2" id="form2">
                    <h4 class="n-form-titel1">Project Details</h4>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Project :</label>
                        <div class="col-sm-9 p-0">
                            <select name="proj_code" id="proj_code" class="form-control">
                                <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', $proj_code, ''); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Section :</label>
                        <div class="col-sm-9 p-0">
                            <select name="section_name" id="section_name" class="form-control" onchange="getData2('../../common/flat_option_mhafuz.php', 'flat_span', document.getElementById('proj_code').value, this.value);">
                                <?php foreign_relation('tbl_add_section', 'section_id', 'section_name', $section_name, ''); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Plot No. :</label>
                        <div class="col-sm-9 p-0">
                            <span id="flat_span">
                                <select name="flat" id="flat" class="form-control">
                                    <?php
                                    if ($proj_code && $section_name) {
                                        $sql_flat_opts = "SELECT fid, flat_no FROM tbl_flat_info WHERE proj_code = '$proj_code' AND section_name = '$section_name' ORDER BY flat_no";
                                        $res_opts = db_query($sql_flat_opts);
                                        while ($opt = db_fetch_row($res_opts)) {
                                            $selected = ($opt[0] == $flat) ? 'selected' : '';
                                            echo "<option value=\"$opt[0]\" $selected>$opt[1]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="n-form-btn-class">
                        <input type="submit" name="submit" class="btn1 btn1-bg-submit" value="Search Details" />
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Client Details -->
        <div class="col-sm-6">
            <div class="container n-form1 p-3">
                <h4 class="n-form-titel1">Client Details</h4>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($client_info) ?>" readonly />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Address :</label>
                    <div class="col-sm-9 p-0">
                        <textarea class="form-control" rows="2" readonly><?= htmlspecialchars($address) ?></textarea>
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Mobile No. :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($mobile) ?>" readonly />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Head Summary Table -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="container n-form1">
                <h4 class="n-form-titel1">Payment Head Summary</h4>
                <?php if ($flat > 0) { ?>
                    <?php
                    // Fetch payment head summary
                    $sql_head = "SELECT a.rec_no, c.pay_code, c.pay_desc, SUM(a.inst_amount) AS inst_amount, SUM(a.rcv_amount) AS rcv_amount
                                 FROM tbl_flat_cost_installment a
                                 JOIN tbl_flat_info b ON a.proj_code = b.proj_code AND a.build_code = b.build_code AND a.flat_no = b.flat_no
                                 JOIN tbl_payment_head c ON a.pay_code = c.pay_code
                                 WHERE b.fid = '$flat'
                                 GROUP BY a.pay_code
                                 ORDER BY a.pay_code";
                    $res_head = db_query($sql_head);
                    ?>
                    <div class="tabledesign2">
                        <table id="table_head" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr class="bgc-info">
                                    <th>Pay Code</th>
                                    <th>Pay Desc</th>
                                    <th>Inst Amount</th>
                                    <th>Rcv Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                while ($row = db_fetch_row($res_head)) {
                                    $i++;
                                    $cls = ($i % 2 == 0) ? ' class="alt"' : '';
                                    // Make row clickable to show receipt details
                                    $rec_no = $row[0]; // rec_no from the first column (rec_no)
                                ?>
                                <tr<?= $cls ?> onclick="getData('../../common/rec_no.php', 'receipt_details', '<?= $rec_no ?>');" style="cursor:pointer;">
                                    <td><?= $row[1] ?></td>
                                    <td><?= htmlspecialchars($row[2]) ?></td>
                                    <td style="text-align:right"><?= number_format($row[3], 2) ?></td>
                                    <td style="text-align:right"><?= number_format($row[4], 2) ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6 offset-md-6">
                            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                <tr>
                                    <td style="text-align:right"><strong>Total Instalment:</strong></td>
                                    <td style="text-align:right"><input type="text" class="form-control" value="<?= number_format($total_inst, 2) ?>" readonly style="width:150px; text-align:right" /></td>
                                    <td style="text-align:right"><strong>Total Received:</strong></td>
                                    <td style="text-align:right"><input type="text" class="form-control" value="<?= number_format($total_rcv, 2) ?>" readonly style="width:150px; text-align:right" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <!-- Placeholder when no flat selected -->
                    <div class="tabledesign2">
                        <table id="table_head" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr class="bgc-info">
                                    <th>Pay Code</th>
                                    <th>Pay Desc</th>
                                    <th>Inst Amount</th>
                                    <th>Rcv Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="4" class="text-center">Please select a project, section, and flat to view summary.</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6 offset-md-6">
                            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                <tr>
                                    <td style="text-align:right"><strong>Total Instalment:</strong></td>
                                    <td style="text-align:right"><input type="text" class="form-control" value="0.00" readonly style="width:150px; text-align:right" /></td>
                                    <td style="text-align:right"><strong>Total Received:</strong></td>
                                    <td style="text-align:right"><input type="text" class="form-control" value="0.00" readonly style="width:150px; text-align:right" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>