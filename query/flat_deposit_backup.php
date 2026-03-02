<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Allotment Wise Deposit';
$page  = 'flat_deposit.php';

// Get filter values
$proj_code = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$building  = isset($_REQUEST['building']) ? (int)$_REQUEST['building'] : 0;

// Function to load buildings based on project (optional AJAX)
function getflatData() {
    // Placeholder for future AJAX
}
?>

<script>
function submit_nav(proj) {
    document.location.href = '<?= $page ?>?proj_code=' + proj;
}
</script>

<div class="container-fluid p-0">
    <!-- Centered filter form (width 50% on medium screens) -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="container n-form1 p-3">
                <form id="form1" name="form1" method="get" action="<?= $page ?>">
                    <h4 class="n-form-titel1">Project Details</h4>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Project :</label>
                        <div class="col-sm-9 p-0">
                            <select name="proj_code" id="proj_code" class="form-control" onchange="submit_nav(this.value)">
                                <option value="">-- Select Project --</option>
                                <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', $proj_code, ''); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Category :</label>
                        <div class="col-sm-9 p-0">
                            <select name="building" id="building" class="form-control">
                                <option value="">-- Select Building --</option>
                                <?php
                                // Only show buildings for the selected project if any
                                $condition = $proj_code ? "proj_code = '$proj_code'" : '';
                                foreign_relation('tbl_building_info', 'bid', 'category', $building, $condition);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="n-form-btn-class">
                        <input type="submit" name="search" class="btn1 btn1-bg-submit" value="Search Details" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="container n-form1">
                <?php if ($proj_code && $building) { ?>
                    <?php
                    // Fetch aggregated data
                    $sql = "SELECT a.flat_no, c.party_code, c.party_name, SUM(a.rcv_amount) as receive_amount, b.status
                            FROM tbl_flat_cost_installment a
                            JOIN tbl_flat_info b ON a.proj_code = b.proj_code AND a.build_code = b.build_code AND a.flat_no = b.flat_no
                            JOIN tbl_party_info c ON b.party_code = c.party_code
                            WHERE a.proj_code = '$proj_code' AND a.build_code = '$building'
                            GROUP BY a.flat_no
                            ORDER BY a.flat_no";
                    $res = db_query($sql);
                    ?>
                    <div class="tabledesign1">
                        <table id="table_head" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr class="bgc-info">
                                    <th>Plot No</th>
                                    <th>Party Code</th>
                                    <th>Party Name</th>
                                    <th>Receive Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                while ($row = db_fetch_row($res)) {
                                    $i++;
                                    $cls = ($i % 2 == 0) ? ' class="alt"' : '';
                                ?>
                                <tr<?= $cls ?>>
                                    <td><?= htmlspecialchars($row[0]) ?></td>
                                    <td><?= $row[1] ?></td>
                                    <td><?= htmlspecialchars($row[2]) ?></td>
                                    <td style="text-align:right"><?= number_format($row[3], 2) ?></td>
                                    <td><?= htmlspecialchars($row[4]) ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <!-- Placeholder table when no selection -->
                    <div class="tabledesign1">
                        <table id="table_head" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr class="bgc-info">
                                    <th>Plot No</th>
                                    <th>Party Code</th>
                                    <th>Party Name</th>
                                    <th>Receive Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="5" class="text-center">Please select a project and building to view data.</td></tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>