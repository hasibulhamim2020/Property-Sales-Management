<?php
/**
 * AJAX Handler for Block Selection based on Category and Project
 */
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$str = $_POST['data'];
$data = explode('##', $str);
$cat_id = $data[0]; // This is actually the category string (b_type)
$proj_code = $data[1];
?>
<select name="cat_id" id="cat_id" class="form-control">
    <option value="">-- Select Block --</option>
    <?php 
    if ($proj_code != '') {
        $filter = "proj_code = '$proj_code'";
        if ($cat_id != '') {
            $filter .= " AND category = '$cat_id'";
        }
        foreign_relation('tbl_building_info', 'build_code', 'build_code', '', $filter); 
    }
    ?>
</select>
