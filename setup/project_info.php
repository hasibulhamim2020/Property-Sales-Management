<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ini_set('log_errors', 1);
// ini_set('error_log', 'error_log.txt');
// error_reporting(E_ALL);


// Date pickers for date fields
do_calander('#proj_start_date');
do_calander('#proj_ho_date');
do_calander('#work_start');
do_calander('#expc_date');
// do_calander('#fdate');
// do_calander('#tdate');


$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

// ========== EDIT THESE ==========
$title      = 'Project Info';
$table      = 'tbl_project_info';
$unique     = 'proj_code';
$shown      = 'proj_name';          // field used for redundancy check (optional)
$page       = 'project_info.php';
// ================================

do_datatable('table_head');

$crud = new crud($table);

$$unique = isset($_GET[$unique]) ? $_GET[$unique] : 0;

// Handle POST (insert/update/delete)
if (isset($_POST[$shown])) {
    $$unique = $_POST[$unique];

    // ---- INSERT ----
    if (isset($_POST['insert'])) {
        // Redundancy check (optional)
        $proj_name = $_POST['proj_name'];
        if (!reduncancy_check($table, 'proj_name', $proj_name)) {
            $_POST['entry_by'] = $_SESSION['user']['id'];
            $_POST['entry_at'] = date('Y-m-d H:i:s');
            $crud->insert();
            $msg = 'New project added successfully.';
            $type = 1;
            unset($_POST);
            unset($$unique);
        } else {
            $type = 2;
            $msg = 'Project name already exists.';
        }
    }

    // ---- UPDATE ----
    if (isset($_POST['update'])) {
        $_POST['edit_by'] = $_SESSION['user']['id'];
        $_POST['edit_at'] = date('Y-m-d H:i:s');
        $crud->update($unique);
        $msg = 'Project updated successfully.';
        $type = 1;
    }

    // ---- DELETE ----
    if (isset($_POST['delete'])) {
        $condition = "$unique = " . $$unique;
        $crud->delete($condition);
        $msg = 'Project deleted successfully.';
        $type = 1;
        unset($$unique);
    }
}

// Load data for editing
if ($$unique > 0) {
    $condition = "$unique = " . $$unique;
    $data = db_fetch_object($table, $condition);
    foreach ($data as $key => $value) {
        $$key = $value;
    }
}

// For new record, suggest next ID (optional)
if (!isset($$unique) || $$unique == 0) {
    $$unique = db_last_insert_id($table, $unique) + 1;
}


?>

<script>
$(function() {
    // Optional: add any custom JS here
});

function DoNav(id) {
    document.location.href = '<?= $page ?>?<?= $unique ?>=' + id;
}
</script>

<div class="container-fluid p-0">
    <div class="row">
        <!-- LEFT SIDE: PROJECT LIST (DataTable) -->
         <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
            <div class="container n-form1">
                <table id="table_head" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr class="bgc-info">
                            <th>ID</th>
                            <th>Project Name</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT proj_code, proj_name, proj_add FROM tbl_project_info ORDER BY proj_code";
                        $res = db_query($sql);
                        $i = 0;
                        while ($row = mysqli_fetch_row($res)) {
                            $i++;
                            $cls = ($i % 2 == 0) ? ' class="alt"' : '';
                        ?>
                        <tr<?= $cls ?>>
                            <td style="text-align:center"><?= $row[0] ?></td>
                            <td><?= htmlspecialchars($row[1]) ?></td>
                            <td><?= htmlspecialchars($row[2]) ?></td>
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
                    <h4 class="n-form-titel1">Add New Project</h4>
                <?php } else { ?>
                    <h4 class="n-form-titel1">Edit Project #<?= $$unique ?></h4>
                <?php } ?>

                <?php if (isset($msg)): ?>
                    <div class="alert alert-<?= $type == 1 ? 'success' : 'danger' ?> shadow-sm mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <span><?= $msg ?></span>
                            <?php if ($type == 1): ?>
                                <div class="ml-3">
                                    <a href="product_configuration.php?proj_code=<?= $$unique ?>" class="btn btn-sm btn-light font-weight-bold">
                                        Next: Configure Units <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                    <a href="../transaction/flat_allotment.php?proj_code=<?= $$unique ?>&submit=1" class="btn btn-sm btn-outline-light font-weight-bold ml-1">
                                        View Dashboard
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Hidden fields -->
                <input name="<?= $unique ?>" type="hidden" value="<?= $$unique ?>" />

                <!-- Company (group_for) – remove if not needed -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Company:</label>
                    <div class="col-sm-9 p-0">
                        <select name="group_for" id="group_for" class="form-control">
                            <option value="">-- Select Company --</option>
                            <?php foreign_relation('user_group', 'id', 'group_name', isset($group_for) ? $group_for : $_SESSION['user']['group'], ''); ?>
                        </select>
                    </div>
                </div> -->

                <!-- Project Name -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="req-input col-sm-3 pl-0 pr-0 col-form-label">Project Name:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="proj_name" required value="<?= isset($proj_name) ? htmlspecialchars($proj_name) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Project Brief -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Project Brief:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="proj_brf" value="<?= isset($proj_brf) ? htmlspecialchars($proj_brf) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Address -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Address:</label>
                    <div class="col-sm-9 p-0">
                        <textarea name="proj_add" class="form-control" rows="2"><?= isset($proj_add) ? htmlspecialchars($proj_add) : '' ?></textarea>
                    </div>
                </div>

                <!-- Project Value (if this field exists; otherwise remove) -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Project Value:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="proj_value" value="<?= isset($proj_value) ? htmlspecialchars($proj_value) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Budgeted Cost -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Budgeted Cost:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="proj_budget_cost" value="<?= isset($proj_budget_cost) ? $proj_budget_cost : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Sand Filling -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Sand Filling:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="sand_filling" value="<?= isset($sand_filling) ? $sand_filling : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Tree Plantation -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Tree Plantation:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="tree_plantation" value="<?= isset($tree_plantation) ? $tree_plantation : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Registary -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Registary:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="registary" value="<?= isset($registary) ? $registary : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Legal Expenses -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Legal Exp:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="legal_exp" value="<?= isset($legal_exp) ? $legal_exp : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Road Expenses -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Road Exp:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="road_exp" value="<?= isset($road_exp) ? $road_exp : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Bricks -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Bricks:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="bricks" value="<?= isset($bricks) ? $bricks : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Cement -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Cement:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="cement" value="<?= isset($cement) ? $cement : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Rod -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Rod:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="rod" value="<?= isset($rod) ? $rod : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Lebor -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Lebor:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="lebor" value="<?= isset($lebor) ? $lebor : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Miscell -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Miscell:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="miscell" value="<?= isset($miscell) ? $miscell : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Broker Exp -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Broker Exp:</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="broker_exp" value="<?= isset($broker_exp) ? $broker_exp : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Project Status (dropdown) -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Status:</label>
                    <div class="col-sm-9 p-0">
                        <select name="proj_status" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="ACTIVE" <?= (isset($proj_status) && $proj_status == 'ACTIVE') ? 'selected' : '' ?>>ACTIVE</option>
                            <option value="INACTIVE" <?= (isset($proj_status) && $proj_status == 'INACTIVE') ? 'selected' : '' ?>>INACTIVE</option>
                            <option value="COMPLETED" <?= (isset($proj_status) && $proj_status == 'COMPLETED') ? 'selected' : '' ?>>COMPLETED</option>
                        </select>
                    </div>
                </div>

                <!-- Start Date -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Start Date:</label>
                    <div class="col-sm-9 p-0">
                        <input type="date" name="proj_start_date" id="proj_start_date" value="<?= isset($proj_start_date) ? $proj_start_date : '' ?>" class="form-control datepicker" />
                    </div>
                </div> -->

                <!-- Handover Date -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Handover Date:</label>
                    <div class="col-sm-9 p-0">
                        <input type="date" name="proj_ho_date" id="proj_ho_date" value="<?= isset($proj_ho_date) ? $proj_ho_date : '' ?>" class="form-control datepicker" />
                    </div>
                </div> -->

                <!-- Work Start Date -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Work Start:</label>
                    <div class="col-sm-9 p-0">
                        <input type="date" name="work_start" id="work_start" value="<?= isset($work_start) ? $work_start : '' ?>" class="form-control datepicker" />
                    </div>
                </div> -->

                <!-- Expected Completion Date -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Expected Completion:</label>
                    <div class="col-sm-9 p-0">
                        <input type="date" name="expc_date" id="expc_date" value="<?= isset($expc_date) ? $expc_date : '' ?>" class="form-control datepicker" />
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
                        <input class="btn1 btn1-bg-delete" type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this project?');" />
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>