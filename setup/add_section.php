<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();


// ini_set('log_errors', 1);
// ini_set('error_log', 'error_log.txt');
// error_reporting(E_ALL);


// ========== EDIT THESE ==========
$title      = 'Add Section';
$table      = 'tbl_add_section';
$unique     = 'section_id';
$shown      = 'section_name';          // field used for redundancy check (optional)
$page       = 'add_section.php';
// ================================

do_datatable('table_head');

$crud = new crud($table);

$$unique = isset($_GET[$unique]) ? (int)$_GET[$unique] : 0;

// Handle POST (insert/update/delete)
if (isset($_POST[$shown])) {
    $$unique = (int)$_POST[$unique];

    // ---- INSERT ----
    if (isset($_POST['insert'])) {
        // Optional redundancy check (you can check section_name + proj_id if needed)
        // For simplicity, we skip check here
        $_POST['entry_by'] = $_SESSION['user']['id'];
        $_POST['entry_at'] = date('Y-m-d H:i:s');
        $crud->insert();
        $msg = 'New section added successfully.';
        $type = 1;
        unset($_POST);
        unset($$unique);
    }

    // ---- UPDATE ----
    if (isset($_POST['update'])) {
        $_POST['edit_by'] = $_SESSION['user']['id'];
        $_POST['edit_at'] = date('Y-m-d H:i:s');
        $crud->update($unique);
        $msg = 'Section updated successfully.';
        $type = 1;
    }

    // ---- DELETE ----
    if (isset($_POST['delete'])) {
        $condition = "$unique = " . $$unique;
        $crud->delete($condition);
        $msg = 'Section deleted successfully.';
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

// For new record, suggest next ID (optional)
if (!isset($$unique) || $$unique == 0) {
    $$unique = db_last_insert_id($table, $unique) + 1;
}
?>

<script>
function DoNav(id) {
    document.location.href = '<?= $page ?>?<?= $unique ?>=' + id;
}
</script>

<div class="container-fluid p-0">
    <div class="row">
        <!-- LEFT SIDE: SECTION LIST (DataTable) -->
         <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
            <div class="container n-form1">
                <table id="table_head" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr class="bgc-info">
                            <th>ID</th>
                            <th>Section Name</th>
                            <th>Project</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT s.section_id, s.section_name, p.proj_name 
                                FROM $table s
                                LEFT JOIN tbl_project_info p ON s.proj_id = p.proj_code
                                ORDER BY s.section_id";
                        $res = db_query($sql);
                        $i = 0;
                        while ($row = mysqli_fetch_row($res)) {
                            $i++;
                            $cls = ($i % 2 == 0) ? ' class="alt"' : '';
                        ?>
                        <tr<?= $cls ?>>
                            <td style="text-align:center"><?= $row[0] ?></td>
                            <td><?= htmlspecialchars($row[1]) ?></td>
                            <td><?= htmlspecialchars($row[2] ?? '') ?></td>
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
        <div class="col-sm-5 p-0 pl-2">
            <form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <?php if (!isset($_GET[$unique]) || $_GET[$unique] == 0) { ?>
                    <h4 class="n-form-titel1">Add New Section</h4>
                <?php } else { ?>
                    <h4 class="n-form-titel1">Edit Section #<?= $$unique ?></h4>
                <?php } ?>

                <!-- Hidden primary key -->
                <input name="<?= $unique ?>" type="hidden" value="<?= $$unique ?>" />

                <!-- Optional: Company dropdown – only if your table has group_for field -->
                <!--
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Company:</label>
                    <div class="col-sm-9 p-0">
                        <select name="group_for" id="group_for" class="form-control">
                            <option value="">-- Select Company --</option>
                            <?php // foreign_relation('user_group', 'id', 'group_name', isset($group_for) ? $group_for : $_SESSION['user']['group'], ''); ?>
                        </select>
                    </div>
                </div>
                -->

                <!-- Section Name (required) -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="req-input col-sm-3 pl-0 pr-0 col-form-label">Section Name:</label>
                 <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
                        <input type="text" name="section_name" required value="<?= isset($section_name) ? htmlspecialchars($section_name) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Project Name -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Project Name:</label>
                    <div class="col-sm-9 p-0">
                        <select name="proj_id" id="proj_id" class="form-control">
                            <option value="">-- Select Project --</option>
                            <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', isset($proj_id) ? $proj_id : '', ''); ?>
                        </select>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="n-form-btn-class">
                    <?php if (!isset($_GET[$unique]) || $_GET[$unique] == 0) { ?>
                        <input class="btn1 btn1-bg-submit" type="submit" name="insert" value="Save" />
                    <?php } else { ?>
                        <input class="btn1 btn1-bg-update" type="submit" name="update" value="Update" />
                    <?php } ?>
                    <input class="btn1 btn1-bg-cancel" type="button" name="reset" value="Reset" onclick="window.location='<?= $page ?>'" />
                    <?php if (isset($_GET[$unique]) && $_GET[$unique] > 0) { ?>
                        <input class="btn1 btn1-bg-delete" type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this section?');" />
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>