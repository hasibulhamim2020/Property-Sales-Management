<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// Date pickers
do_calander('#birth_date');
do_calander('#register_date');

$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

// ========== CONFIGURATION ==========
$title      = 'Client Info';
$table      = 'tbl_party_info';
$unique     = 'party_code';
$shown      = 'party_name';
$page       = 'client_info.php';
// ====================================

do_datatable('table_head');

$crud = new crud($table);

$$unique = isset($_GET[$unique]) ? (int)$_GET[$unique] : 0;
$filter_proj = isset($_GET['proj_code']) ? (int)$_GET['proj_code'] : 0;

// Handle POST (insert/update/delete) – same logic as before
if (isset($_POST[$shown])) {
    $$unique = (int)$_POST[$unique];

    // File uploads
    $upload_dir = '../../../pictures/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $pic_fields = ['pic_1', 'pic_2', 'pic_3', 'pic_4'];
    foreach ($pic_fields as $pic) {
        if (!empty($_FILES[$pic]['tmp_name']) && $_FILES[$pic]['size'] > 0) {
            $ext = pathinfo($_FILES[$pic]['name'], PATHINFO_EXTENSION);
            $filename = $$unique . '_' . substr($pic, -1) . '.' . $ext;
            $target = $upload_dir . $filename;
            if (move_uploaded_file($_FILES[$pic]['tmp_name'], $target)) {
                $_POST[$pic] = $target;
            }
        }
    }

    if (isset($_POST['insert'])) {
        $_POST['created_by'] = $_SESSION['user']['fname'] ?? $_SESSION['user']['username'];
        $_POST['register_date'] = date('Y-m-d');
        $crud->insert();
        $msg = 'New client added successfully.';
        $type = 1;
        unset($_POST);
        unset($$unique);
    }

    if (isset($_POST['update'])) {
        $_POST['authorised_by'] = $_SESSION['user']['fname'] ?? $_SESSION['user']['username'];
        $crud->update($unique);
        $msg = 'Client updated successfully.';
        $type = 1;
    }

    if (isset($_POST['delete'])) {
        $condition = "$unique = " . $$unique;
        $crud->delete($condition);
        $msg = 'Client deleted successfully.';
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

// Suggest next ID for new records
if (!isset($$unique) || $$unique == 0) {
    $$unique = db_last_insert_id($table, $unique) + 1;
}
?>

<script>
function DoNav(id) {
    document.location.href = '<?= $page ?>?<?= $unique ?>=' + id;
}
function submit_nav(proj) {
    document.location.href = '<?= $page ?>?proj_code=' + proj;
}
</script>

<div class="container-fluid p-0">
    <div class="row">
        <!-- LEFT SIDE: FILTER + CLIENT LIST -->
     <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6 setup-left">
            <!-- Filter form (Project) -->
            <div class="container p-0">
                <form id="filter_form" class="n-form1 pt-0" method="get" action="<?= $page ?>">
                    <h4 align="center" class="n-form-titel1">Search Client</h4>
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Project :</label>
                        <div class="col-sm-9 p-0">
                            <select name="proj_code" id="proj_code" onchange="submit_nav(this.value)" class="form-control">
                                <option value="">-- All Projects --</option>
                                <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', $filter_proj, ''); ?>
                            </select>
                        </div>
                    </div>
                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" type="submit" value="Show" />
                        <input class="btn1 btn1-bg-cancel" type="button" value="Clear" onclick="window.location='<?= $page ?>'" />
                    </div>
                </form>
            </div>

            <!-- Client list table -->
            <div class="container n-form1">
                <table id="table_head" class="table table-bordered" cellspacing="0">
                    <thead>
                        <tr class="bgc-info">
                            <th width="8%">Party Code</th>
                            <th style="text-align:left">Client Name</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = $filter_proj
                            ? "SELECT party_code, party_name FROM $table WHERE proj_code = '$filter_proj' ORDER BY party_code"
                            : "SELECT party_code, party_name FROM $table ORDER BY party_code";
                        $res = db_query($sql);
                        $i = 0;
                        while ($row = mysqli_fetch_row($res)) {
                            $i++;
                            $cls = ($i % 2 == 0) ? ' class="alt"' : '';
                        ?>
                        <tr<?= $cls ?>>
                            <td style="text-align:center"><?= $row[0] ?></td>
                            <td><?= htmlspecialchars($row[1]) ?></td>
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

        <!-- RIGHT SIDE: ADD/EDIT FORM (scrollable) -->
        <div class="col-sm-5 p-0 pl-2">
            <form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" style="padding-bottom: 20px;">
                <?php if (!isset($_GET[$unique]) || $_GET[$unique] == 0) { ?>
                    <h4 align="center" class="n-form-titel1">Create New Client</h4>
                <?php } else { ?>
                    <h4 align="center" class="n-form-titel1">Update Client #<?= $$unique ?></h4>
                <?php } ?>

                <!-- Hidden primary key -->
                <input name="<?= $unique ?>" type="hidden" value="<?= $$unique ?>" />

                <!-- Project (if you want it editable) -->
                <!-- <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Project :</label>
                    <div class="col-sm-9 p-0">
                        <select name="proj_code" class="form-control">
                            <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', isset($proj_code) ? $proj_code : 0, ''); ?>
                        </select>
                    </div>
                </div> -->

                <!-- Client Code (readonly) -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Client Code :</label>
                   <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-6  setup-right">
                        <input type="text" value="<?= $$unique ?>" class="form-control" readonly />
                    </div>
                </div>

                <!-- Client Name -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="req-input col-sm-3 pl-0 pr-0 col-form-label">Client Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="party_name" required value="<?= isset($party_name) ? htmlspecialchars($party_name) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Pictures -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Pic 1 :</label>
                    <div class="col-sm-9 p-0">
                        <?php if (!empty($pic_1)) echo '<img src="' . htmlspecialchars($pic_1) . '" width="50" height="75" class="mb-2" /><br>'; ?>
                        <input type="file" name="pic_1" class="form-control-file" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Pic 2 :</label>
                    <div class="col-sm-9 p-0">
                        <?php if (!empty($pic_2)) echo '<img src="' . htmlspecialchars($pic_2) . '" width="50" height="75" class="mb-2" /><br>'; ?>
                        <input type="file" name="pic_2" class="form-control-file" />
                    </div>
                </div>

                <!-- Father, Mother, Spouse -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Father's Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="fname" value="<?= isset($fname) ? htmlspecialchars($fname) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Mother's Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="mname" value="<?= isset($mname) ? htmlspecialchars($mname) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Spouse's Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="hname" value="<?= isset($hname) ? htmlspecialchars($hname) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Contact Info -->
                <h5 class="mt-3 pl-3">Contact Info</h5>
                <?php
                $contact_fields = [
                    'ah_mobile_tel' => 'Mobile Tel',
                    'ah_office_tel' => 'Office Tel',
                    'ah_residence_tel' => 'Residence Tel',
                    'email_address' => 'Email',
                    'website_address' => 'Website'
                ];
                foreach ($contact_fields as $field => $label):
                ?>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label"><?= $label ?> :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="<?= $field ?>" value="<?= isset($$field) ? htmlspecialchars($$field) : '' ?>" class="form-control" />
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Present Address -->
                <h5 class="mt-3 pl-3">Present Address</h5>
                <?php
                $pre_fields = [
                    'pre_house', 'pre_road', 'pre_village', 'pre_postcode',
                    'pre_postoffice', 'pre_police_station', 'pre_district', 'pre_country'
                ];
                $pre_labels = ['House/Flat', 'Road', 'Village', 'Post Code', 'Post Office', 'Police Station', 'District', 'Country'];
                for ($i = 0; $i < count($pre_fields); $i++):
                ?>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label"><?= $pre_labels[$i] ?> :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="<?= $pre_fields[$i] ?>" value="<?= isset($$pre_fields[$i]) ? htmlspecialchars($$pre_fields[$i]) : '' ?>" class="form-control" />
                    </div>
                </div>
                <?php endfor; ?>

                <!-- Permanent Address -->
                <h5 class="mt-3 pl-3">Permanent Address</h5>
                <?php
                $per_fields = [
                    'per_house', 'per_road', 'per_village', 'per_postcode',
                    'per_postoffice', 'per_police_station', 'per_district', 'per_country'
                ];
                $per_labels = ['House/Flat', 'Road', 'Village', 'Post Code', 'Post Office', 'Police Station', 'District', 'Country'];
                for ($i = 0; $i < count($per_fields); $i++):
                ?>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label"><?= $per_labels[$i] ?> :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="<?= $per_fields[$i] ?>" value="<?= isset($$per_fields[$i]) ? htmlspecialchars($$per_fields[$i]) : '' ?>" class="form-control" />
                    </div>
                </div>
                <?php endfor; ?>

                <!-- Personal Details -->
                <h5 class="mt-3 pl-3">Personal Details</h5>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Occupation :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="prof_code" value="<?= isset($prof_code) ? htmlspecialchars($prof_code) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Nationality :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="nation" value="<?= isset($nation) ? htmlspecialchars($nation) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">National ID :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="national_id_no" value="<?= isset($national_id_no) ? htmlspecialchars($national_id_no) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">VAT No :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="vat_no" value="<?= isset($vat_no) ? htmlspecialchars($vat_no) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">TIN No :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="tin_no" value="<?= isset($tin_no) ? htmlspecialchars($tin_no) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Date of Birth :</label>
                    <div class="col-sm-9 p-0">
                        <input type="date" name="birth_date" id="birth_date" value="<?= isset($birth_date) ? htmlspecialchars($birth_date) : '' ?>" class="form-control datepicker" />
                    </div>
                </div>

                <!-- Company/Department -->
                <h5 class="mt-3 pl-3">Company Info</h5>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Company Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="company_name" value="<?= isset($company_name) ? htmlspecialchars($company_name) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Department :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="department" value="<?= isset($department) ? htmlspecialchars($department) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Contact Person :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="contact_person" value="<?= isset($contact_person) ? htmlspecialchars($contact_person) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Nominee -->
                <h5 class="mt-3 pl-3">Nominee Info</h5>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Nominee Name :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="nominee" value="<?= isset($nominee) ? htmlspecialchars($nominee) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Nominee Pic 1 :</label>
                    <div class="col-sm-9 p-0">
                        <?php if (!empty($pic_3)) echo '<img src="' . htmlspecialchars($pic_3) . '" width="50" height="75" class="mb-2" /><br>'; ?>
                        <input type="file" name="pic_3" class="form-control-file" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Nominee Pic 2 :</label>
                    <div class="col-sm-9 p-0">
                        <?php if (!empty($pic_4)) echo '<img src="' . htmlspecialchars($pic_4) . '" width="50" height="75" class="mb-2" /><br>'; ?>
                        <input type="file" name="pic_4" class="form-control-file" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Nominee Relation :</label>
                    <div class="col-sm-9 p-0">
                        <select name="nrelation" class="form-control">
                            <option value="">Choose One</option>
                            <?php
                            $relations = ['SON','DAUGHTER','WIFE','HUSBAND','FATHER','MOTHER','SISTER','BROTHER','SISTER-IN-LAW','BROTHER-IN-LAW','MOTHER-IN-LAW','FATHER-IN-LAW','FRIEND','OTHERS'];
                            foreach ($relations as $rel) {
                                $selected = (isset($nrelation) && $nrelation == $rel) ? 'selected' : '';
                                echo "<option value=\"$rel\" $selected>$rel</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Nominee Address -->
                <h5 class="mt-3 pl-3">Nominee Address</h5>
                <?php
                $n_fields = [
                    'n_house', 'n_road', 'n_village', 'n_postcode',
                    'n_postoffice', 'n_police_station', 'n_district', 'n_country'
                ];
                $n_labels = ['House/Flat', 'Road', 'Village', 'Post Code', 'Post Office', 'Police Station', 'District', 'Country'];
                for ($i = 0; $i < count($n_fields); $i++):
                ?>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label"><?= $n_labels[$i] ?> :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="<?= $n_fields[$i] ?>" value="<?= isset($$n_fields[$i]) ? htmlspecialchars($$n_fields[$i]) : '' ?>" class="form-control" />
                    </div>
                </div>
                <?php endfor; ?>

                <!-- Nominee Contact -->
                <h5 class="mt-3 pl-3">Nominee Contact</h5>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Mobile Tel :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="n_mobile_tel" value="<?= isset($n_mobile_tel) ? htmlspecialchars($n_mobile_tel) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Office Tel :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="n_office_tel" value="<?= isset($n_office_tel) ? htmlspecialchars($n_office_tel) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Residence Tel :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="n_residence_tel" value="<?= isset($n_residence_tel) ? htmlspecialchars($n_residence_tel) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Additional Info -->
                <h5 class="mt-3 pl-3">Additional Info</h5>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Brand Ambassador :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="brand_ambassador" value="<?= isset($brand_ambassador) ? htmlspecialchars($brand_ambassador) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Ambassador Code :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="ambasidor_account" value="<?= isset($ambasidor_account) ? htmlspecialchars($ambasidor_account) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Client Dealt by :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="account_dealt_by" value="<?= isset($account_dealt_by) ? htmlspecialchars($account_dealt_by) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Special Notes :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="any_special_notes" value="<?= isset($any_special_notes) ? htmlspecialchars($any_special_notes) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Reg. Date :</label>
                    <div class="col-sm-9 p-0">
                        <input type="date" name="register_date" id="register_date" value="<?= isset($register_date) ? htmlspecialchars($register_date) : date('Y-m-d') ?>" class="form-control datepicker" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Created by :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="created_by" value="<?= isset($created_by) ? htmlspecialchars($created_by) : '' ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Authorised by :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" name="authorised_by" value="<?= isset($authorised_by) ? htmlspecialchars($authorised_by) : '' ?>" class="form-control" />
                    </div>
                </div>

                <!-- Commission Reference (if personnel_basic_info exists) -->
                <h5 class="mt-3 pl-3">Commission Reference</h5>
                <?php
                $comm_fields = [
                    'non_insentive' => 'Non Insentive',
                    'sr_executive' => 'Sr Executive',
                    'team_leader' => 'Team Leader',
                    'group_leader' => 'Group Leader',
                    'others' => 'Others'
                ];
                foreach ($comm_fields as $field => $label):
                ?>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label"><?= $label ?> :</label>
                    <div class="col-sm-9 p-0">
                        <select name="<?= $field ?>" class="form-control">
                            <option value="">-- Select --</option>
                            <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'PBI_NAME', isset($$field) ? $$field : '', ''); ?>
                        </select>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Payment Type -->
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Payment Type :</label>
                    <div class="col-sm-9 p-0">
                        <select name="payment_type" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="Cash" <?= (isset($payment_type) && $payment_type == 'Cash') ? 'selected' : '' ?>>Cash</option>
                            <option value="Installment" <?= (isset($payment_type) && $payment_type == 'Installment') ? 'selected' : '' ?>>Installment</option>
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
                        <input class="btn1 btn1-bg-delete" type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this client?');" />
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>