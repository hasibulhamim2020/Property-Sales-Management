<?php
require_once "../../../controllers/routing/default_values.php";
$proj_code = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$selected_fid = isset($_REQUEST['fid']) ? (int)$_REQUEST['fid'] : 0;
?>
<select name="flat" id="flat" class="form-control">
    <option value="">-- Select Unit --</option>
    <?php
    if ($proj_code > 0) {
        $sql = "SELECT fid, road_no, flat_no FROM tbl_flat_info WHERE proj_code = '$proj_code' ORDER BY road_no ASC, flat_no ASC";
        $res = db_query($sql);
        if ($res) {
            while ($row = db_fetch_array($res)) {
                $selected = ($row['fid'] == $selected_fid) ? 'selected' : '';
                $label = "Floor: " . $row['road_no'] . " / Unit: " . $row['flat_no'];
                echo "<option value=\"{$row['fid']}\" $selected>$label</option>";
            }
        }
    }
    ?>
</select>
