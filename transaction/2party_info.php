<?php
/**
 * Adaptive Party Information & Booking Page
 * Handles:
 * 1. Data Entry/Booking/Reservation for Available units.
 * 2. Detailed Profile View for Booked, Reserved, or Sold units.
 */

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$fid = isset($_REQUEST['fid']) ? (int)$_REQUEST['fid'] : 0;
$party_code = isset($_REQUEST['party_code']) ? (int)$_REQUEST['party_code'] : 0;
$msg = '';
$type = 0; // 1: Success, 2: Error

// --- HANDLE FORM SUBMISSION (Booking/Reservation) ---
if (isset($_POST['insert_party'])) {
    $p_name = mysqli_real_escape_string($GLOBALS['DB'], $_POST['party_name']);
    $p_mobile = mysqli_real_escape_string($GLOBALS['DB'], $_POST['ah_mobile_tel']);
    $status_to_set = $_POST['status_to_set'] ?: 'Booked';

    // 1. Create Party Record
    $fields = "party_name, ah_mobile_tel, pre_house, pre_road, pre_village, ah_office_tel, " .
              "proj_code, party_code, register_date, created_by, " .
              "ah_residence_tel, email_address, website_address, per_house, per_road, per_village, per_postcode, per_postoffice, per_district, per_country, " .
              "pre_postcode, pre_postoffice, pre_district, pre_country, n_house, n_road, n_postcode, n_postoffice, n_village, n_district, n_country, " .
              "n_mobile_tel, n_office_tel, n_residence_tel, vat_no, national_id_no, company_name, department, contact_person, brand_ambassador, " .
              "ambasidor_account, account_dealt_by, any_special_notes, authorised_by, pic_1, pic_2, pic_3, pic_4, pic_1_caption, pic_2_caption, " .
              "pic_3_caption, pic_4_caption, pre_police_station, per_police_station, n_police_station, non_insentive, sr_executive, team_leader, " .
              "group_leader, others, payment_type, ledger_id, agent_code1, agent_code2, agent_code3, agent_code4";
              
    $empty_strings = implode(", ", array_fill(0, 51, "''"));
    $zeros = "0, 0, 0, 0, 0";
    
    $sql_party = "INSERT INTO tbl_party_info ($fields) 
                  VALUES ('$p_name', '$p_mobile', 
                          '".mysqli_real_escape_string($GLOBALS['DB'], $_POST['pre_house'])."', 
                          '".mysqli_real_escape_string($GLOBALS['DB'], $_POST['pre_road'])."', 
                          '".mysqli_real_escape_string($GLOBALS['DB'], $_POST['pre_village'])."', 
                          '".mysqli_real_escape_string($GLOBALS['DB'], $_POST['ah_office_tel'])."',
                          0, 0, '".date('Y-m-d')."', 'system', 
                          $empty_strings, $zeros)";
    
    if (db_query($sql_party)) {
        $new_party_code = mysqli_insert_id($GLOBALS['DB']);
        
        // 2. Update Flat Status
        $sql_flat = "UPDATE tbl_flat_info SET status = '$status_to_set', party_code = '$new_party_code' WHERE fid = '$fid'";
        if (db_query($sql_flat)) {
            $msg = "Unit successfully " . strtolower($status_to_set) . "!";
            $type = 1;
            $party_code = $new_party_code; // Switch to profile view
        }
    }
}

// --- FETCH DATA ---
$flat_data = null;
if ($fid > 0) {
    $sql_flat = "SELECT * FROM tbl_flat_info WHERE fid = $fid LIMIT 1";
    $res_flat = db_query($sql_flat);
    if ($res_flat) $flat_data = mysqli_fetch_object($res_flat);
}

$party_data = null;
if ($party_code > 0) {
    $sql_party = "SELECT * FROM tbl_party_info WHERE party_code = $party_code LIMIT 1";
    $res_party = db_query($sql_party);
    if ($res_party) $party_data = mysqli_fetch_object($res_party);
} elseif ($flat_data && $flat_data->party_code > 0) {
    $party_code = $flat_data->party_code;
    $sql_party = "SELECT * FROM tbl_party_info WHERE party_code = $party_code LIMIT 1";
    $res_party = db_query($sql_party);
    if ($res_party) $party_data = mysqli_fetch_object($res_party);
}

$is_available = ($flat_data && $flat_data->status == 'Available');
?>

<style>
    :root {
        --primary: #679435;
        --secondary: #3f590a;
        --light: #f8fbc1;
        --danger: #e74c3c;
        --warning: #f1c40f;
    }
    .party-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 0 15px;
    }
    .card-modern {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .card-header-modern {
        background: var(--primary);
        color: white;
        padding: 15px 20px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .unit-badge {
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
    }
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table tr { border-bottom: 1px solid #f0f0f0; }
    .info-table tr:nth-child(even) { background: #fafafa; }
    .info-label {
        width: 35%;
        padding: 12px 20px;
        font-weight: 600;
        color: #666;
        text-align: right;
    }
    .info-value { padding: 12px 20px; color: #333; }
    
    .form-section { padding: 25px; }
    .form-group-modern { margin-bottom: 20px; }
    .form-label-modern {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #555;
    }
    .form-control-modern {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border 0.3s;
    }
    .form-control-modern:focus {
        border-color: var(--primary);
        outline: none;
    }
    .btn-action {
        padding: 10px 25px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s, opacity 0.2s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-action:hover { transform: translateY(-2px); opacity: 0.9; }
    .btn-book { background: var(--primary); color: white; margin-right: 10px; }
    .btn-reserve { background: var(--warning); color: #333; }
</style>

<div class="party-container">
    <?php if ($msg): ?>
        <div class="alert alert-<?= $type == 1 ? 'success' : 'danger' ?> shadow-sm mb-4">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <div class="card-modern">
        <div class="card-header-modern">
            <span><?= $is_available ? 'Unit Booking Form' : 'Client Profile' ?></span>
            <?php if ($flat_data): ?>
                <span class="unit-badge">Unit: <?= htmlspecialchars($flat_data->flat_no) ?> (<?= htmlspecialchars($flat_data->status) ?>)</span>
            <?php endif; ?>
        </div>

        <?php if ($is_available): ?>
            
            
            <!-- BOOKING FORM FOR AVAILABLE UNITS -->
            <div class="form-section">
                <form method="post" id="bookingForm">
                    <input type="hidden" name="fid" value="<?= $fid ?>">
                    <input type="hidden" name="status_to_set" id="status_to_set" value="Booked">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Client Name</label>
                                <input type="text" name="party_name" class="form-control-modern" placeholder="Full Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Contact Number</label>
                                <input type="text" name="ah_mobile_tel" class="form-control-modern" placeholder="Mobile / Phone">
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">Address Details</label>
                        <div class="row">
                            <div class="col-md-4 mb-2"><input type="text" name="pre_house" class="form-control-modern" placeholder="House/Flat"></div>
                            <div class="col-md-4 mb-2"><input type="text" name="pre_road" class="form-control-modern" placeholder="Road/Block"></div>
                            <div class="col-md-4 mb-2"><input type="text" name="pre_village" class="form-control-modern" placeholder="Area/Village"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">Telephone (Off)</label>
                                <input type="text" name="ah_office_tel" class="form-control-modern">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" name="insert_party" class="btn-action btn-book" onclick="document.getElementById('status_to_set').value='Booked'">Confirm Booking</button>
                        <button type="submit" name="insert_party" class="btn-action btn-reserve" onclick="document.getElementById('status_to_set').value='Reserve'">Place Reservation</button>
                    </div>
                </form>
            </div>
            
        <?php elseif ($party_data): ?>
            <!-- INFO TABLE FOR BOOKED/SOLD UNITS -->
            <table class="info-table">
                <tr>
                    <td class="info-label">Client Code :</td>
                    <td class="info-value"><?= htmlspecialchars($party_data->party_code) ?></td>
                </tr>
                <tr>
                    <td class="info-label">Client Name :</td>
                    <td class="info-value"><?= htmlspecialchars($party_data->party_name) ?></td>
                </tr>
                <tr>
                    <td class="info-label">Address :</td>
                    <td class="info-value">
                        <?= htmlspecialchars(trim(($party_data->pre_house ?? '') . ' ' . ($party_data->pre_road ?? '') . ' ' . ($party_data->pre_village ?? ''))) ?: 'N/A' ?>
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Contact No :</td>
                    <td class="info-value"><?= htmlspecialchars($party_data->ah_mobile_tel ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <td class="info-label">Telephone (Off) :</td>
                    <td class="info-value"><?= htmlspecialchars($party_data->ah_office_tel ?? 'N/A') ?></td>
                </tr>
                <?php if ($flat_data): ?>
                <tr>
                    <td class="info-label">Current Status :</td>
                    <td class="info-value">
                        <span class="badge badge-<?= $flat_data->status == 'Sold' ? 'danger' : ($flat_data->status == 'Reserve' ? 'warning' : 'primary') ?>">
                            <?= htmlspecialchars($flat_data->status) ?>
                        </span>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
            <div class="p-4 text-center">
                <!-- <button class="btn btn-secondary btn-sm" onclick="window.history.back()">Go Back</button>
                <button class="btn btn-outline-primary btn-sm ml-2" onclick="window.print()">Print Details</button> -->
            </div>
        <?php else: ?>
            <div class="p-5 text-center text-muted">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <p>No party information associated with this unit.</p>
                <button class="btn btn-primary" onclick="window.close()">Close Tab</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
require_once SERVER_CORE."routing/layout.bottom.php";
?>
