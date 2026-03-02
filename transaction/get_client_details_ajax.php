<?php
/**
 * AJAX Handler for fetching detailed client information
 */
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

header('Content-Type: application/json');

$party_code = isset($_POST['party_code']) ? (int)$_POST['party_code'] : 0;

if ($party_code > 0) {
    $sql = "SELECT party_name, ah_mobile_tel, ah_office_tel, pre_house, pre_road, pre_village 
            FROM tbl_party_info 
            WHERE party_code = $party_code 
            LIMIT 1";
    $res = db_query($sql);
    if ($res && $data = mysqli_fetch_assoc($res)) {
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Client not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid client code.']);
}
exit;
