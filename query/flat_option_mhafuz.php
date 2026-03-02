<?php
require_once "../../../controllers/routing/default_values.php";
$proj_code = (int)$_GET['proj_code'];
$section_name = (int)$_GET['section_name'];
$sql = "SELECT fid, flat_no FROM tbl_flat_info WHERE proj_code = '$proj_code' AND section_name = '$section_name' ORDER BY flat_no";
$res = db_query($sql);

echo '<select name="flat" id="flat" class="form-control">';
echo '<option value="">-- Select Allotment --</option>';
while ($row = db_fetch_row($res)) {
    echo "<option value=\"$row[0]\">$row[1]</option>";
}
echo '</select>';
?>