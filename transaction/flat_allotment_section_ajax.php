<?php
require_once "../../../controllers/routing/default_values.php";

$proj_code = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$section_id = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
?>
<select name="section_name" id="section_name" class="form-control">
    <?php
    if ($proj_code > 0) {
        $condition = "proj_code = '$proj_code'";
        foreign_relation('tbl_building_info', 'DISTINCT build_code', 'build_code', $section_id, $condition);
    } else {
        echo '<option value="">-- Select Project First --</option>';
    }
    ?>
</select>
