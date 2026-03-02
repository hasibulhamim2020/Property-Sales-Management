<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// Date pickers for date fields
do_calander('#f_date');
do_calander('#t_date');

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Collection Summary';
$page  = 'collection_summary.php';

// Get submitted dates
$f_date = isset($_REQUEST['f_date']) ? $_REQUEST['f_date'] : '';
$t_date = isset($_REQUEST['t_date']) ? $_REQUEST['t_date'] : '';
?>

<div class="container-fluid p-0">
    <!-- Centered filter form (width 50% on medium screens) -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="container n-form1 p-3">
                <form id="form1" name="form1" method="get" action="<?= $page ?>">
                    <h4 class="n-form-titel1">Collection Summary</h4>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">From :</label>
                        <div class="col-sm-9 p-0">
                            <input type="date" name="f_date" id="f_date" class="form-control datepicker" value="<?= htmlspecialchars($f_date) ?>" />
                        </div>
                    </div>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">To :</label>
                        <div class="col-sm-9 p-0">
                            <input type="date" name="t_date" id="t_date" class="form-control datepicker" value="<?= htmlspecialchars($t_date) ?>" />
                        </div>
                    </div>
                    <div class="n-form-btn-class">
                        <input type="submit" name="submit" class="btn1 btn1-bg-submit" value="Filter" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="container n-form1">
                <?php if ($f_date && $t_date) { ?>
                    <?php
                    // Fetch receipts between dates
                    $sql = "SELECT rec_no, rec_date, party_code, proj_code, build_code as allotment_type, flat_no as allotment_no, pay_mode, rec_amount
                            FROM tbl_receipt
                            WHERE rec_date BETWEEN '$f_date' AND '$t_date'
                            ORDER BY rec_date";
                    $res = db_query($sql);
                    ?>
                    <div class="tabledesign2">
                        <table id="table_head" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr class="bgc-info">
                                    <th>Rec Date</th>
                                    <th>Party Code</th>
                                    <th>Proj Code</th>
                                    <th>Allotment Type</th>
                                    <th>Allotment No</th>
                                    <th>Pay Mode</th>
                                    <th>Rec Amount</th>
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
                                    <td><?= $row[1] ?></td>
                                    <td><?= $row[2] ?></td>
                                    <td><?= $row[3] ?></td>
                                    <td><?= htmlspecialchars($row[4] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row[5] ?? '') ?></td>
                                    <td><?= $row[6] ?></td>
                                    <td style="text-align:right"><?= number_format($row[7], 2) ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <!-- Placeholder when no dates selected -->
                    <div class="tabledesign2">
                        <table id="table_head" class="table table-bordered" cellspacing="0">
                            <thead>
                                <tr class="bgc-info">
                                    <th>Rec Date</th>
                                    <th>Party Code</th>
                                    <th>Proj Code</th>
                                    <th>Allotment Type</th>
                                    <th>Allotment No</th>
                                    <th>Pay Mode</th>
                                    <th>Rec Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="7" class="text-center">Please select a date range to view collection summary.</td></tr>
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