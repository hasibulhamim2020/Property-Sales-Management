<?php
/**
 * Update Deed Status Page
 * Modernized UI with restored core functionality.
 */

$title = 'Update Deed Status';
$page  = 'update_deed.php';

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// Premium styles
?>
<link href="flat_allotment.css" rel="stylesheet" type="text/css" />

<?php
$proj_code   = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$section_name = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
$fid_to_update = isset($_GET['fid']) ? (int)$_GET['fid'] : 0;

$msg = '';
$msg_type = 0;

// Handle Status Update
if (isset($_POST['update_status'])) {
    $u_fid = (int)$_POST['u_fid'];
    $new_status = mysqli_real_escape_string($GLOBALS['DB'], $_POST['status']);
    $new_sr_status = mysqli_real_escape_string($GLOBALS['DB'], $_POST['sr_status']);
    $res_date = mysqli_real_escape_string($GLOBALS['DB'], $_POST['res_date']);
    $pos_date = mysqli_real_escape_string($GLOBALS['DB'], $_POST['pos_date']);
    
    $sql_up = "UPDATE tbl_flat_info SET 
               status = '$new_status', 
               sr_status = '$new_sr_status', 
               res_date = '$res_date', 
               pos_date = '$pos_date' 
               WHERE fid = '$u_fid'";
    
    if (db_query($sql_up)) {
        $msg = "Unit status updated successfully to $new_status / $new_sr_status!";
        $msg_type = 1;
        $fid_to_update = 0; // Clear after update
    }
}

// Fetch unit data if fid is selected
$unit_info = null;
if ($fid_to_update > 0) {
    $sql_u = "SELECT a.*, p.party_name FROM tbl_flat_info a 
              LEFT JOIN tbl_party_info p ON a.party_code = p.party_code 
              WHERE a.fid = '$fid_to_update'";
    $res_u = db_query($sql_u);
    if ($res_u) $unit_info = mysqli_fetch_object($res_u);
}
?>

<script>
function getData2(url, targetElement, projCode, sectionId) {
    if (projCode == '') return;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(targetElement).innerHTML = xhr.responseText;
        }
    };
    xhr.open('GET', url + '?proj_code=' + projCode + '&section_name=' + sectionId, true);
    xhr.send();
}
</script>

<div class="container-fluid p-0">
    <!-- Filter Section -->
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="container n-form1 p-3 mt-3">
                <form id="form1" name="form1" method="post" action="<?= $page ?>">
                    <h5 class="n-form-titel1"><i class="fas fa-search mr-2"></i>Filter Units</h5>
                    
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-4 pl-0 pr-0 col-form-label">Project :</label>
                        <div class="col-sm-8 p-0">
                            <select name="proj_code" id="proj_code" class="form-control" onchange="getData2('flat_allotment_section_ajax.php', 'bld_span', this.value, '');">
                                <option value="">-- Select Project --</option>
                                <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', $proj_code, ''); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-4 pl-0 pr-0 col-form-label">Block Name :</label>
                        <div class="col-sm-8 p-0">
                            <span id="bld_span">
                                <?php 
                                $_REQUEST['proj_code'] = $proj_code;
                                $_REQUEST['section_name'] = $section_name;
                                include 'flat_allotment_section_ajax.php'; 
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="n-form-btn-class">
                        <input type="submit" name="submit" class="btn1 btn1-bg-submit" value="Show Units" />
                    </div>
                </form>
            </div>
        </div>

        <?php if ($unit_info): ?>
        <!-- Update Form for Selected Unit -->
        <div class="col-md-6">
            <div class="container n-form1 p-3 mt-3 border-primary" style="border-top: 3px solid #679435;">
                <form method="post" action="<?= $page ?>?proj_code=<?= $proj_code ?>&section_name=<?= $section_name ?>&submit=1">
                    <h5 class="n-form-titel1 text-primary">Update Status: <?= htmlspecialchars($unit_info->flat_no) ?></h5>
                    <input type="hidden" name="u_fid" value="<?= $unit_info->fid ?>">
                    
                    <div class="row px-3">
                        <div class="col-md-6 mb-2">
                            <label class="small font-weight-bold">Client:</label>
                            <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($unit_info->party_name ?? 'N/A') ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="small font-weight-bold">Process State:</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="Booked" <?= $unit_info->status == 'Booked' ? 'selected' : '' ?>>Booked</option>
                                <option value="Reserve" <?= $unit_info->status == 'Reserve' ? 'selected' : '' ?>>Reserve</option>
                                <option value="Sold" <?= $unit_info->status == 'Sold' ? 'selected' : '' ?>>Sold</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="small font-weight-bold">Deed/Agreement Status:</label>
                            <select name="sr_status" class="form-control form-control-sm">
                                <option value="BOOKING" <?= $unit_info->sr_status == 'BOOKING' ? 'selected' : '' ?>>Booking Only</option>
                                <option value="AGREEMENT" <?= $unit_info->sr_status == 'AGREEMENT' ? 'selected' : '' ?>>Agreement Done (Deed)</option>
                                <option value="SOLD" <?= $unit_info->sr_status == 'SOLD' ? 'selected' : '' ?>>Final Sold</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="small font-weight-bold">Agreement Date:</label>
                            <input type="date" name="res_date" class="form-control form-control-sm" value="<?= $unit_info->res_date ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="small font-weight-bold">Handover Date:</label>
                            <input type="date" name="pos_date" class="form-control form-control-sm" value="<?= $unit_info->pos_date ?>">
                        </div>
                    </div>
                    
                    <div class="n-form-btn-class mb-0 mt-2">
                        <input type="submit" name="update_status" class="btn1 btn1-bg-update py-1 px-4" value="Update Unit Record" />
                    </div>
                </form>
            </div>
        </div>
        <?php elseif ($msg != ''): ?>
        <div class="col-md-6 mt-3">
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle mr-2"></i> <?= $msg ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Status Results -->
    <?php 
    if (isset($_POST['submit']) && $proj_code > 0 && $section_name > 0) { 
        // Summary counts
        $summary_sql = "SELECT status, COUNT(*) as count 
                        FROM tbl_flat_info 
                        WHERE proj_code = '$proj_code' AND section_name = '$section_name'
                        GROUP BY status";
        $summary_res = db_query($summary_sql);
        $counts = ['Available' => 0, 'Booked' => 0, 'Reserve' => 0, 'Sold' => 0];
        
        if ($summary_res) {
            while($row = mysqli_fetch_object($summary_res)) {
                if(isset($counts[$row->status])) {
                    $counts[$row->status] = $row->count;
                }
            }
        }
    ?>
    
    <div class="allotment-container container mt-4">
        <!-- Summary Dashboard -->
        <div class="summary-container">
            <div class="summary-item available">
                <span class="summary-count"><?= $counts['Available'] ?></span>
                <span class="summary-label">Available</span>
            </div>
            <div class="summary-item booked">
                <span class="summary-count"><?= $counts['Booked'] ?></span>
                <span class="summary-label">Booked</span>
            </div>
            <div class="summary-item reserved">
                <span class="summary-count"><?= $counts['Reserve'] ?></span>
                <span class="summary-label">Reserved</span>
            </div>
            <div class="summary-item sold">
                <span class="summary-count"><?= $counts['Sold'] ?></span>
                <span class="summary-label">Sold</span>
            </div>
        </div>

        <!-- Legend -->
        <div class="legend-container">
            <div class="legend-item"><div class="legend-color" style="background:var(--status-available);"></div> Available</div>
            <div class="legend-item"><div class="legend-color" style="background:var(--status-booked);"></div> Booked</div>
            <div class="legend-item"><div class="legend-color" style="background:var(--status-reserved);"></div> Reserved</div>
            <div class="legend-item"><div class="legend-color" style="background:var(--status-sold);"></div> Sold</div>
        </div>

        <!-- Floor-wise Grid -->
        <?php
        $floor_sql = "SELECT road_no, count(flat_no) as total_flat 
                     FROM tbl_flat_info 
                     WHERE proj_code = '$proj_code' AND section_name = '$section_name'
                     GROUP BY road_no
                     ORDER BY road_no DESC";
        $floor_query = db_query($floor_sql);
        
        if ($floor_query && mysqli_num_rows($floor_query) > 0) {
            while ($floor_data = mysqli_fetch_object($floor_query)) {
                $road_no = $floor_data->road_no;
                
                // Get flats for this road as Floor
                $flat_sql = "SELECT fid, party_code, build_code, flat_no, status 
                             FROM tbl_flat_info
                             WHERE road_no = '$road_no' 
                               AND proj_code = '$proj_code' 
                               AND section_name = '$section_name'
                             ORDER BY flat_no ASC";
                $flat_query = db_query($flat_sql);
                ?>
                <div class="floor-group">
                    <div class="floor-header">
                        <h5 class="floor-title">Floor No : <?= htmlspecialchars($road_no) ?></h5>
                        <span class="badge badge-light"><?= (int)$floor_data->total_flat ?> Flats</span>
                    </div>
                    <div class="flat-grid">
                        <?php
                        while ($data = mysqli_fetch_object($flat_query)) {
                            $status_class = '';
                            $link = '';
                            $rel = 'gb_page_center[800, 560]';
                            $title_attr = 'Party Information';
                            
                            if($data->status == 'Booked') {
                                $status_class = 'flat-booked';
                                $link = "$page?fid=" . $data->fid . "&proj_code=$proj_code&section_name=$section_name&submit=1";
                            } elseif($data->status == 'Reserve') {
                                $status_class = 'flat-reserved';
                                $link = "$page?fid=" . $data->fid . "&proj_code=$proj_code&section_name=$section_name&submit=1";
                            } elseif($data->status == 'Sold') {
                                $status_class = 'flat-sold';
                                $link = "$page?fid=" . $data->fid . "&proj_code=$proj_code&section_name=$section_name&submit=1";
                            } else {
                                $status_class = 'flat-available';
                                $link = "#";
                            }
                            ?>
                            <a href="<?= $link ?>" 
                               class="flat-item <?= $status_class ?>" 
                               data-status="<?= $data->status ?>">
                                <?= htmlspecialchars($data->flat_no) ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php }
        } else { ?>
            <div class="alert alert-info text-center mt-3">
                No flats found for the selected criteria.
            </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>