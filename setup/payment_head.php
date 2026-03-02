<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

// ========== CONFIGURATION ==========
$title      = 'Payment Head';
$table      = 'tbl_payment_head';
$unique     = 'pay_code';
$shown      = 'pay_desc';          // field used for redundancy check (optional)
$page       = 'payment_head.php';
// ====================================

do_datatable('table_head');

$crud = new crud($table);

$$unique = isset($_GET[$unique]) ? (int)$_GET[$unique] : 0;

// Handle POST (insert/update/delete)
if (isset($_POST[$shown])) {
    $$unique = (int)$_POST[$unique];

    // ---- INSERT ----
    if (isset($_POST['insert'])) {
        // Optional uniqueness check on pay_desc (if desired)
        $pay_desc = $_POST['pay_desc'];
        if (!reduncancy_check($table, 'pay_desc', $pay_desc)) {
            $crud->insert();
            $msg = 'New payment head added successfully.';
            $type = 1;
            unset($_POST);
            unset($$unique);
        } else {
            $type = 2;
            $msg = 'Payment description already exists.';
        }
    }

    // ---- UPDATE ----
    if (isset($_POST['update'])) {
        $crud->update($unique);
        $msg = 'Payment head updated successfully.';
        $type = 1;
    }

    // ---- DELETE ----
    if (isset($_POST['delete'])) {
        $condition = "$unique = " . $$unique;
        $crud->delete($condition);
        $msg = 'Payment head deleted successfully.';
        $type = 1;
        unset($$unique);
    }
}

// Load data for editing
if ($$unique > 0) {
    $condition = "$unique = " . $$unique;
    $data = db_fetch_object($table, $condition);
    if ($data) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
    }
}

// For new record, we don't auto‑increment pay_code; user must enter it
// So we don't set $$unique here.
?>

<script>
function DoNav(id) {
    document.location.href = '<?= $page ?>?<?= $unique ?>=' + id;
}
</script>

<div class="container-fluid p-0">
    <div class="row">
        <!-- LEFT SIDE: PAYMENT HEAD LIST (DataTable) -->
     <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
            <div class="container n-form1">
                <table id="table_head" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr class="bgc-info">
                            <th>Pay Code</th>
                            <th>Description</th>
                            <!-- <th>Short Name</th> -->
                            <!-- <th>Serial</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT pay_code, pay_desc, pay_short, serial FROM $table ORDER BY pay_code";
                        $res = db_query($sql);
                        $i = 0;
                        while ($row = mysqli_fetch_row($res)) {
                            $i++;
                            $cls = ($i % 2 == 0) ? ' class="alt"' : '';
                        ?>
                        <tr<?= $cls ?>>
                            <td style="text-align:center"><?= $row[0] ?></td>
                            <td><?= htmlspecialchars($row[1]) ?></td>
                            <!-- <td><?= htmlspecialchars($row[2]) ?></td> -->
                            <!-- <td><?= $row[3] ?></td> -->
                            <td style="text-align:center">
                                <button type="button" onclick="DoNav('<?= $row[0] ?>');" class="btn2 btn1-bg-update">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIGHT SIDE: ADD/EDIT FORM -->
         <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
            <form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <?php if (!isset($_GET[$unique]) || $_GET[$unique] == 0) { ?>
                    <h4 class="n-form-titel1">Add New Payment Head</h4>
                <?php } else { ?>
                    <h4 class="n-form-titel1">Edit Payment Head #<?= $$unique ?></h4>
                <?php } ?>

                <!-- Hidden primary key (pay_code) is not hidden – we show it as an input -->
                <!-- For edit, it's readonly; for insert, it's editable -->
                <?php if (isset($_GET[$unique]) && $_GET[$unique] > 0) { ?>
                    <input name="<?= $unique ?>" type="hidden" value="<?= $$unique ?>" />
                <?php } ?>

                <!-- Payment Code (only editable on insert) -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="req-input col-sm-3 pl-0 pr-0 col-form-label">Pay Code :</label>
                    <div class="col-sm-9 p-0">
                        <?php if (isset($_GET[$unique]) && $_GET[$unique] > 0) { ?>
                            <input type="text" value="<?= $$unique ?>" class="form-control" readonly />
                        <?php } else { ?>
                            <input type="text" name="<?= $unique ?>" readonly  value="<?= isset($$unique) && $$unique > 0 ? $$unique : '' ?>" class="form-control" />
                        <?php } ?>
                    </div>
                </div>

                <!-- Description (pay_desc) -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="req-input col-sm-3 pl-0 pr-0 col-form-label">Description :</label>
                    <div class="col-sm-9 p-0">
                        <textarea name="pay_desc" id="pay_desc" class="form-control" rows="3"><?= isset($pay_desc) ? htmlspecialchars($pay_desc) : '' ?></textarea>
                    </div>
                </div>

                <!-- Short Name (pay_short) -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Short Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="pay_short" id="pay_short" value="<?= isset($pay_short) ? htmlspecialchars($pay_short) : '' ?>" class="form-control" />
                    </div>
                </div> -->

                <!-- Serial -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Serial :</label>
                    <div class="col-sm-9 p-0">
                        <input type="number" name="serial" id="serial" value="<?= isset($serial) ? htmlspecialchars($serial) : '' ?>" class="form-control" />
                    </div>
                </div> -->

                <!-- Form Buttons -->
                <div class="n-form-btn-class">
                    <?php if (!isset($_GET[$unique]) || $_GET[$unique] == 0) { ?>
                        <input class="btn1 btn1-bg-submit" type="submit" name="insert" value="Save" />
                    <?php } else { ?>
                        <input class="btn1 btn1-bg-update" type="submit" name="update" value="Update" />
                    <?php } ?>
                    <input class="btn1 btn1-bg-cancel" type="button" name="reset" value="Reset" onclick="window.location='<?= $page ?>'" />
                    <?php if (isset($_GET[$unique]) && $_GET[$unique] > 0) { ?>
                        <input class="btn1 btn1-bg-delete" type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this payment head?');" />
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>