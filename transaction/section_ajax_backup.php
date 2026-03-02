<?php
/**
 * AJAX Handler for Category Selection based on Project
 */
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

print_r($_POST['data']);

$str = $_POST['data'];
$data = explode('##', $str);
$proj_code = $data[0];
?>
<select name="section_name" id="section_name" class="form-control">
    <option value="">-- Select Section --</option>
    <?php 
    if ($proj_code != '') {
        foreign_relation('tbl_add_section', 'section_id', 'section_name', '', "proj_id = '$proj_code'"); 
    }
    ?>
    <!-- <?php foreign_relation('tbl_add_section', 'section_id', 'section_name', $section_name, 1); ?> -->
</select>
