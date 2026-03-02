<?php
/**
 * Flat Allotment Status Page
 * Modernized UI with restored core functionality.
 */

$title = 'Allotment Status';
$page  = 'flat_allotment.php';

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// Premium styles
?>
<link href="flat_allotment.css" rel="stylesheet" type="text/css" />

<?php
// Get submitted values
$proj_code   = isset($_REQUEST['proj_code']) ? (int)$_REQUEST['proj_code'] : 0;
$section_name = isset($_REQUEST['section_name']) ? (int)$_REQUEST['section_name'] : 0;
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
    <!-- Filter Section - Restored original structure for layout compatibility -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="container n-form1 p-3 mt-3">
                <form id="form1" name="form1" method="post" action="<?= $page ?>">
                    <h4 class="n-form-titel1">Project Details</h4>
                    
                    
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Project :</label>
                        <div class="col-sm-9 p-0">
                            <select name="proj_code" id="proj_code" class="form-control" onchange="getData2('flat_allotment_section_ajax.php', 'bld_span', this.value, '');">
                                <?php foreign_relation('tbl_project_info', 'proj_code', 'proj_name', $proj_code, ''); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row m-0 pl-3 pr-3">
                        <label class="col-sm-3 pl-0 pr-0 col-form-label">Section Name :</label>
                        <div class="col-sm-9 p-0">
                            <span id="bld_span">
                                <?php include 'flat_allotment_section_ajax.php'; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="n-form-btn-class">
                        <input type="submit" name="submit" class="btn1 btn1-bg-submit" value="Show Status" />
                    </div>
                </form>
            </div>
        </div>
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
                                $link = "party_info.php?fid=" . $data->fid . "&party_code=" . $data->party_code;
                                $rel = 'gb_page_center[480, 320]';
                            } elseif($data->status == 'Reserve') {
                                $status_class = 'flat-reserved';
                                $link = "party_info.php?fid=" . $data->fid . "&party_code=" . $data->party_code;
                                $rel = 'gb_page_center[480, 320]';
                            } elseif($data->status == 'Sold') {
                                $status_class = 'flat-sold';
                                $link = "party_info.php?fid=" . $data->fid . "&party_code=" . $data->party_code;
                                $rel = 'gb_page_center[480, 320]';
                            } else {
                                $status_class = 'flat-available';
                                $link = "party_info.php?fid=" . $data->fid . "&flat_no=" . $data->flat_no . "&build_code=" . $data->build_code;
                            }
                            ?>
                            <a href="<?= $link ?>" 
                               class="flat-item <?= $status_class ?>" 
                               target="_blank"
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