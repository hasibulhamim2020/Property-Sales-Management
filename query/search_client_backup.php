<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// Include Greybox scripts (optional – adjust paths if needed)
?>
<script type="text/javascript">
    var GB_ROOT_DIR = "../../../assets/greybox/"; // adjust to your actual path
</script>
<script type="text/javascript" src="../../../assets/greybox/AJS.js"></script>
<script type="text/javascript" src="../../../assets/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="../../../assets/greybox/gb_scripts.js"></script>
<link href="../../../assets/greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />

<?php
$_SESSION['execution_no'] = $_SESSION['user']['id'].'0000'.time();

$title = 'Client Status';
$page  = 'client_status.php';

// Get filter values
$proj_code   = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$section_name = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
$flat        = isset($_REQUEST['flat']) ? (int)$_REQUEST['flat'] : 0;

// Note: $info is not defined in the original code; we leave fields empty.
// If you want to populate them, you'd need to fetch flat info here.
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
                        <input type="text" class="form-control" value="" readonly />
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Address :</label>
                    <div class="col-sm-9 p-0">
                        <textarea class="form-control" rows="2" readonly></textarea>
                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label class="col-sm-3 pl-0 pr-0 col-form-label">Mobile No. :</label>
                    <div class="col-sm-9 p-0">
                        <input type="text" class="form-control" value="" readonly />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plot Details and AJAX area (two columns) -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="container n-form1 p-3">
                <h4 class="n-form-titel1">Plot Details</h4>
                <table class="table table-sm">
                    <tr>
                        <td width="40%">Plot Size (Katha) :</td>
                        <td><input type="text" class="form-control" value="" readonly /></td>
                    </tr>
                    <tr>
                        <td>Rate Per Khata :</td>
                        <td><input type="text" class="form-control" value="" readonly /></td>
                    </tr>
                    <tr>
                        <td>Unit Price :</td>
                        <td><input type="text" class="form-control" value="" readonly /></td>
                    </tr>
                    <tr>
                        <td>Discount Amount :</td>
                        <td><input type="text" class="form-control" value="" readonly /></td>
                    </tr>
                    <tr>
                        <td>Payable Unit price :</td>
                        <td><input type="text" class="form-control" value="" readonly /></td>
                    </tr>
                    <tr>
                        <td>Development Price :</td>
                        <td><input type="text" class="form-control" value="" readonly /></td>
                    </tr>
                    <tr>
                        <td>Total Price :</td>
                        <td><input type="text" class="form-control" value="" readonly /></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <span id="nid"></span>
        </div>
    </div>

    <!-- Instalment List (AJAX) -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="container n-form1">
                <h4 class="n-form-titel1">Instalment Details</h4>
                <div class="tabledesign2">
                    <span id="iid"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>