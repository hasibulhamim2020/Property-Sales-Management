<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Money Receipt View';
$page  = 'money_receipt_view.php';

// Handle receipt deletion
if (isset($_POST['del']) && isset($_POST['del_rec_no']) && $_POST['del_rec_no'] > 0) {
    $del_rec_no = (int)$_POST['del_rec_no'];

    // Fetch details to update tbl_flat_cost_installment
    $sql = "SELECT a.pay_code, a.inst_no, a.inst_amount, a.rec_amount,
                   b.proj_code, b.build_code, b.flat_no
            FROM tbl_receipt_details a
            JOIN tbl_receipt b ON a.rec_no = b.rec_no
            WHERE a.rec_no = '$del_rec_no'";
    $query = db_query($sql);
    if (db_num_rows($query) > 0) {
        while ($data = db_fetch_object($query)) {
            $pay_code   = $data->pay_code;
            $inst_no    = $data->inst_no;
            $inst_amount= $data->inst_amount;
            $rec_amount = (int)$data->rec_amount;
            $proj_code  = $data->proj_code;
            $build_code = $data->build_code;
            $flat_no    = $data->flat_no;

            // Find previous receipt for this instalment (if any)
            $sql_old = "SELECT b.rec_no, b.rec_date
                        FROM tbl_receipt_details a
                        JOIN tbl_receipt b ON a.rec_no = b.rec_no
                        WHERE a.pay_code = '$pay_code'
                          AND a.inst_no = '$inst_no'
                          AND b.proj_code = '$proj_code'
                          AND b.build_code = '$build_code'
                          AND b.flat_no = '$flat_no'
                          AND a.rec_no < '$del_rec_no'
                        ORDER BY a.rec_no DESC
                        LIMIT 1";
            $query_old = db_query($sql_old);
            if (db_num_rows($query_old) > 0) {
                $data_old = db_fetch_object($query_old);
                $old_rec_info = "rcv_date = '" . db_escape($data_old->rec_date) . "', rec_no = '" . $data_old->rec_no . "'";
            } else {
                $old_rec_info = "rcv_date = '0000-00-00', rec_no = '0'";
            }

            $update = "UPDATE tbl_flat_cost_installment
                       SET rcv_amount = rcv_amount - $rec_amount,
                           rcv_status = '0',
                           $old_rec_info
                       WHERE proj_code = '$proj_code'
                         AND build_code = '$build_code'
                         AND flat_no = '$flat_no'
                         AND pay_code = '$pay_code'
                         AND inst_no = '$inst_no'
                       LIMIT 1";
            db_query($update);
        }
    }

    // Delete from receipt and receipt_details
    db_query("DELETE FROM tbl_receipt WHERE rec_no = '$del_rec_no'");
    db_query("DELETE FROM tbl_receipt_details WHERE rec_no = '$del_rec_no'");

    $msg = "Receipt deleted successfully.";
    $type = 1;
}

// Get filter values
$proj_code   = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$section_name = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
$flat        = isset($_REQUEST['flat']) ? (int)$_REQUEST['flat'] : 0;

$client_info = '';
$address     = '';
$mobile      = '';

// If Payment button clicked, fetch client details
if (isset($_POST['payment']) && $flat > 0) {
    $sql_flat = "SELECT party_code FROM tbl_flat_info WHERE fid = '$flat' LIMIT 1";
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
    }
}
?>

<script>
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

function getData(url, targetElement, flatId) {
    if (flatId == '') return;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(targetElement).innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', url + '?flat=' + flatId, true);
    xhr.send();
}
</script>

<div class="container-fluid p-0">
    <!-- Top two-column form -->
    <div class="row">
        <!-- Left: Project Details -->
        <div class="col-sm-6">
            <div class="container n-form1 p-3">
                <form id="form1" name="form1" method="post" action="<?= $page ?>">
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
                        <input type="button" name="payment" class="btn1 btn1-bg-submit" value="Payment" onclick="getData('../../common/search_client1.php', 'nid', document.getElementById('flat').value);" />
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

    <!-- AJAX content areas -->
    <div class="row mt-3">
        <div class="col-12">
            <span id="nid"></span>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <span id="iid"></span>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>