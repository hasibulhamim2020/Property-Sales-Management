<?php
/**
 * AJAX Handler to fetch client details for auto-fill
 */
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$str = $_POST['data'];
$data = explode('##', $str);
$party_code = (int)$data[0];

$response = array('status' => 'error', 'data' => null);

if ($party_code > 0) {
    $sql = "SELECT * FROM tbl_party_info WHERE party_code = $party_code LIMIT 1";
    $res = db_query($sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $response['status'] = 'success';
        $response['data'] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
