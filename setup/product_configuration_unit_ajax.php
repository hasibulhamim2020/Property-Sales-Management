<?php
/**
 * AJAX Handler for Category Selection based on Project
 */
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$str = $_POST['data'];
$data = explode('##', $str);
$proj_code = $data[0];
?>
<select name="b_type" id="b_type" class="form-control" onchange="getData2('get_blocks_ajax.php', 'b_type_span', this.value, '<?= $proj_code ?>');">
    <option value="">-- Select Category --</option>
    <?php 
    if ($proj_code != '') {
        foreign_relation('tbl_building_info', 'DISTINCT category', 'category', '', "proj_code = '$proj_code'"); 
    }
    ?>
</select>
