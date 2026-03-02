<?php
require_once "../../../controllers/routing/default_values.php";

$proj_code = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$section_id = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
?>
<select name="section_name" id="section_name" class="form-control">
    <?php
    if ($proj_code > 0) {
        $condition = "proj_id = '$proj_code'";
        foreign_relation('tbl_add_section', 'section_id', 'section_name', $section_id, $condition);
    } else {
        echo '<option value="">-- Select Project First --</option>';
    }
    ?>
</select>
