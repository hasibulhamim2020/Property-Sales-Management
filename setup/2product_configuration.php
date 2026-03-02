<?php
/**
 * Product (Price) Configuration Page
 * Modernized UI with AJAX filtering and real-time calculations.
 */

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ========== CONFIGURATION ==========
$title      = 'Flat Configuration';
$table      = 'tbl_flat_info';
$unique     = 'fid';
$page       = 'product_configuration.php';
// ====================================

$crud = new crud($table);
$$unique = isset($_GET[$unique]) ? (int)$_GET[$unique] : 0;

// Filter values
$filter_proj = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$filter_section = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
$filter_btype = isset($_REQUEST['b_type']) ? $_REQUEST['b_type'] : '';

// Handle POST actions
if (isset($_POST[$unique])) {
    $$unique = (int)$_POST[$unique];

    // ---- INSERT ----
    if (isset($_POST['insert'])) {
        $_POST['entry_by']   = $_SESSION['user']['id'];
        $_POST['entry_date'] = date('Y-m-d');
        
        // Remove non-table fields
        unset($_POST['insert'], $_POST['update'], $_POST['delete'], $_POST['reset']);
        
        if($crud->insert()) {
            $msg = 'New unit configuration saved successfully.';
            $msg_type = 'success';
            unset($$unique);
        }
    }

    // ---- UPDATE ----
    if (isset($_POST['update'])) {
        // 1. Log History (Legacy Requirement)
        $escaped_fid = (int)$$unique;
        $sql_hist = "INSERT INTO tbl_flat_info_history (
                        fid, proj_code, build_code, b_type, section_name, road_no, flat_no, cat_code, cat_id, 
                        floor_no, garag_no, facing, flat_size, sqft_price, unit_price, utility_price, 
                        park_price, reserve, total_price, status, sr_executive_commission, team_leader_commission, 
                        group_leader_commission, other_commission, entry_by, entry_date, edit_by, edit_date, 
                        ledger_id, discount, fine_per, acc_no
                    ) 
                    SELECT fid, proj_code, build_code, b_type, section_name, road_no, flat_no, cat_code, cat_id, 
                           floor_no, garag_no, facing, flat_size, sqft_price, unit_price, utility_price, 
                           park_price, reserve, total_price, status, sr_executive_commission, team_leader_commission, 
                           group_leader_commission, other_commission, entry_by, entry_date, edit_by, edit_date, 
                           ledger_id, discount, fine_per, acc_no
                    FROM tbl_flat_info WHERE fid = '$escaped_fid'";
        db_query($sql_hist);

        // 2. Perform Update
        $_POST['edit_by']   = $_SESSION['user']['id'];
        $_POST['edit_date'] = date('Y-m-d');
        unset($_POST['insert'], $_POST['update'], $_POST['delete'], $_POST['reset']);
        
        if($crud->update($unique)) {
            $msg = 'Unit configuration updated successfully.';
            $msg_type = 'success';
        }
    }

    // ---- DELETE ----
    if (isset($_POST['delete'])) {
        if($crud->delete("$unique = " . $$unique)) {
            $msg = 'Unit configuration removed successfully.';
            $msg_type = 'warning';
            unset($$unique);
        }
    }
}

// Load current record
if ($$unique > 0) {
    $data = db_fetch_object($table, "$unique = " . $$unique);
    if ($data) {
        foreach ($data as $k => $v) { $$k = $v; }
    }
}
?>

<link href="../transaction/flat_allotment.css" rel="stylesheet" type="text/css" />

<script>
function getData2(url, targetElement, val1, val2) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(targetElement).innerHTML = xhr.responseText;
        }
    };
    if (url === 'flat_allotment_section_ajax.php') {
        xhr.open('GET', '../transaction/' + url + '?proj_code=' + val1 + '&section_name=' + val2, true);
        xhr.send();
    } else {
        // Clear dependent dropdowns
        if (targetElement === 'cat_id_span') {
            document.getElementById('b_type_span').innerHTML = '<select name="cat_id" class="form-control"><option value="">-- Select Block --</option></select>';
        }

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('data=' + val1 + '##' + val2);
    }
}

function calculateAmount() {
    var size = parseFloat(document.getElementById('flat_size').value) || 0;
    var rate = parseFloat(document.getElementById('sqft_price').value) || 0;
    document.getElementById('unit_price').value = (size * rate).toFixed(2);
    calculateTotal();
}

function calculateTotal() {
    var unit     = parseFloat(document.getElementById('unit_price').value) || 0;
    var utility  = parseFloat(document.getElementById('utility_price').value) || 0;
    var reserve  = parseFloat(document.getElementById('reserve').value) || 0;
    var parking  = parseFloat(document.getElementById('park_price').value) || 0;
    var discount = parseFloat(document.getElementById('discount').value) || 0;
    document.getElementById('total_price').value = (unit + utility + reserve + parking - discount).toFixed(2);
}

function DoNav(id) {
    window.location.href = '<?= $page ?>?<?= $unique ?>=' + id + '&proj_code=<?= $filter_proj ?>&section_name=<?= $filter_section ?>';
}
</script>

<div class="container-fluid p-0">
    <div class="row m-0">
        <!-- Sidebar: Filter & List -->
        <div class="col-md-5 p-3" style="background: rgba(255,255,255,0.5);">
            <div class="container n-form1 p-3 mb-4">
                <form method="post" action="<?= $page ?>">
                    <h4 class="n-form-titel1">Filter Units</h4>
                    <div class="form-group mb-2">
                        <label class="small font-weight-bold">Project</label>
                        <select name="proj_code" class="form-control form-control-sm" onchange="getData2('flat_allotment_section_ajax.php', 'section_span', this.value, '');">
                            <option value="">-- Select Project --</option>
                            <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', $filter_proj, ''); ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label class="small font-weight-bold">Section Name</label>
                        <span id="section_span">
                            <?php 
                            $_REQUEST['proj_code'] = $filter_proj;
                            $_REQUEST['section_name'] = $filter_section;
                            include '../transaction/flat_allotment_section_ajax.php'; 
                            ?>
                        </span>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn1 btn1-bg-submit py-1 px-3 mt-2">Filter List</button>
                    </div>
                </form>
            </div>

            <!-- List Results -->
            <div class="card-modern shadow-sm overflow-hidden">
                <div class="bg-primary text-white p-2 small font-weight-bold">Unit List</div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0" style="font-size: 13px;">
                        <thead class="bg-light">
                            <tr>
                                <th>Block</th>
                                <th>Category</th>
                                <th>Floor</th>
                                <th>Unit No</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = "SELECT a.fid, a.b_type, b.category, a.road_no, a.flat_no 
                                      FROM tbl_flat_info a
                                      LEFT JOIN tbl_building_info b ON a.cat_id = b.build_code
                                      WHERE 1=1";
                            if($filter_proj > 0) $query .= " AND a.proj_code = '$filter_proj'";
                            if($filter_section > 0) $query .= " AND a.section_name = '$filter_section'";
                            $query .= " ORDER BY a.road_no DESC, a.flat_no ASC LIMIT 100";
                            
                            $res = db_query($query);
                            if ($res && mysqli_num_rows($res) > 0) {
                                while($row = mysqli_fetch_object($res)) {
                                    $active_class = ($$unique == $row->fid) ? 'table-primary font-weight-bold' : '';
                                    ?>
                                    <tr class="<?= $active_class ?>" onclick="DoNav(<?= $row->fid ?>)" style="cursor:pointer">
                                        <td><?= htmlspecialchars($row->b_type) ?></td>
                                        <td><?= htmlspecialchars($row->category ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row->road_no) ?></td>
                                        <td><?= htmlspecialchars($row->flat_no) ?></td>
                                        <td class="text-right"><i class="fa fa-chevron-right text-muted small"></i></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr><td colspan="5" class="text-center p-4 text-muted small">No units found matching selection.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Main Content: Form -->
        <div class="col-md-7 p-3">
            <?php if (isset($msg)): ?>
                <div class="alert alert-<?= $msg_type ?> mb-3"><?= $msg ?></div>
            <?php endif; ?>

            <div class="container n-form1 p-4 shadow-sm">
                <form method="post" id="mainForm">
                    <h4 class="n-form-titel1"><?= $$unique > 0 ? 'Edit Price Configuration' : 'Add New Configuration' ?></h4>
                    <input type="hidden" name="<?= $unique ?>" value="<?= $$unique ?>">

                    <div class="row">


                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Project</label>
                            <select name="proj_code" id="proj_code" class="form-control" onchange="getData2('product_configuration_unit_ajax.php', 'cat_id_span', this.value, '');">
                                <option value="">-- Select Project --</option>
                                <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', isset($proj_code) ? $proj_code : $filter_proj, ''); ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Unit Type (Category)</label>
                            <span id="cat_id_span">
                                <select name="b_type" id="b_type" class="form-control" onchange="getData2('get_blocks_ajax.php', 'b_type_span', this.value, document.getElementById('proj_code').value);">
                                    <option value="">-- Select Category --</option>
                                    <?php 
                                    $p_code = isset($proj_code) ? $proj_code : $filter_proj;
                                    if ($p_code > 0) {
                                        foreign_relation('tbl_building_info', 'DISTINCT category', 'category', isset($b_type) ? $b_type : '', "proj_code = '$p_code'"); 
                                    }
                                    ?>
                                </select>
                            </span>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Block</label>
                            <span id="b_type_span">
                                <select name="cat_id" id="cat_id" class="form-control">
                                    <option value="">-- Select Block --</option>
                                    <?php 
                                    if ($p_code > 0) {
                                        $cat_filter = isset($b_type) ? "proj_code = '$p_code' AND category = '$b_type'" : "proj_code = '$p_code'";
                                        foreign_relation('tbl_building_info', 'build_code', 'build_code', isset($cat_id) ? $cat_id : '', $cat_filter); 
                                    }
                                    ?>
                                </select>
                            </span>
                        </div>


                        
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Floor No</label>
                            <input type="text" name="road_no" value="<?= isset($road_no) ? htmlspecialchars($road_no) : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Flat/Shop No</label>
                            <input type="text" name="flat_no" value="<?= isset($flat_no) ? htmlspecialchars($flat_no) : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Face</label>
                            <select name="facing" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="North" <?= (isset($facing) && $facing == 'North') ? 'selected' : '' ?>>North</option>
                                <option value="South" <?= (isset($facing) && $facing == 'South') ? 'selected' : '' ?>>South</option>
                                <option value="East" <?= (isset($facing) && $facing == 'East') ? 'selected' : '' ?>>East</option>
                                <option value="West" <?= (isset($facing) && $facing == 'West') ? 'selected' : '' ?>>West</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Acc Ledger</label>
                            <input type="text" name="acc_no" value="<?= isset($acc_no) ? htmlspecialchars($acc_no) : '' ?>" class="form-control">
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">Pricing Calculation</h5>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">No of Sft</label>
                            <input type="number" step="0.01" name="flat_size" id="flat_size" value="<?= isset($flat_size) ? $flat_size : '' ?>" class="form-control" onchange="calculateAmount()">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Rate Per Sft</label>
                            <input type="number" step="0.01" name="sqft_price" id="sqft_price" value="<?= isset($sqft_price) ? $sqft_price : '' ?>" class="form-control" onchange="calculateAmount()">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Base Amount</label>
                            <input type="text" name="unit_price" id="unit_price" value="<?= isset($unit_price) ? $unit_price : '' ?>" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Parking</label>
                            <input type="number" step="0.01" name="park_price" id="park_price" value="<?= isset($park_price) ? $park_price : '' ?>" class="form-control" onchange="calculateTotal()">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Utility</label>
                            <input type="number" step="0.01" name="utility_price" id="utility_price" value="<?= isset($utility_price) ? $utility_price : '' ?>" class="form-control" onchange="calculateTotal()">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Reserve</label>
                            <input type="number" step="0.01" name="reserve" id="reserve" value="<?= isset($reserve) ? $reserve : '' ?>" class="form-control" onchange="calculateTotal()">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Discount</label>
                            <input type="number" step="0.01" name="discount" id="discount" value="<?= isset($discount) ? $discount : '' ?>" class="form-control" onchange="calculateTotal()">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Total Price</label>
                            <input type="text" name="total_price" id="total_price" value="<?= isset($total_price) ? $total_price : '' ?>" class="form-control bg-light font-weight-bold text-primary" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Fine %</label>
                            <input type="text" name="fine_per" value="<?= isset($fine_per) ? $fine_per : '' ?>" class="form-control">
                        </div>
                    </div>

                    <h5 class="mt-4 mb-3 text-primary border-bottom pb-2">Sales Commission</h5>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Sr. Executive Commission</label>
                            <input type="text" name="sr_executive_commission" value="<?= isset($sr_executive_commission) ? $sr_executive_commission : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Team Leader Commission</label>
                            <input type="text" name="team_leader_commission" value="<?= isset($team_leader_commission) ? $team_leader_commission : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Group Leader Commission</label>
                            <input type="text" name="group_leader_commission" value="<?= isset($group_leader_commission) ? $group_leader_commission : '' ?>" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Other Commission</label>
                            <input type="text" name="other_commission" value="<?= isset($other_commission) ? $other_commission : '' ?>" class="form-control">
                        </div>
                    </div>

                    <div class="n-form-btn-class pt-3">
                        <?php if ($$unique > 0): ?>
                            <input class="btn1 btn1-bg-update" type="submit" name="update" value="Update Configuration" />
                            <input class="btn1 btn1-bg-delete" type="submit" name="delete" value="Remove" onclick="return confirm('Permanently remove this configuration?');" />
                        <?php else: ?>
                            <input class="btn1 btn1-bg-submit" type="submit" name="insert" value="Save Configuration" />
                        <?php endif; ?>
                        <input class="btn1 btn1-bg-cancel" type="button" value="Clear" onclick="window.location='<?= $page ?>'" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>