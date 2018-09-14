<?php
$con = new mysqli("localhost", "root", "", "billmaker");
mysqli_query($con, "SET NAMES 'utf8' ");
if ($con->connect_error) {
    die("Could not connect to database");
}

$res = array('error' => false);

$action = 'read';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == 'read') {
    $result = $con->query("SELECT * FROM unit");
    $loadunits = array();

    while ($row = $result->fetch_assoc()) {
        array_push($loadunits, $row);
    }
    $res['loadunits'] = $loadunits;
}

if ($action == 'create') {
    $host_id = $_POST['host_id'];
    $elec_unit = $_POST['elec_unit'];
    $water_unit = $_POST['water_unit'];
    $date_unit = $_POST['date_unit'];
    $time_unit = $_POST['time_unit'];

    $result = $con->query("INSERT INTO unit (host_id, elec_unit, water_unit, date_unit, time_unit) VALUES ('$host_id','$elec_unit','$water_unit','$date_unit','$time_unit')");
    if ($result) {
        $res['message'] = "Unit added";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not insert";
    }
}

if ($action == 'update') {
    $unit_id = $_POST['unit_id'];
    $host_id = $_POST['host_id'];
    $elec_unit = $_POST['elec_unit'];
    $water_unit = $_POST['water_unit'];
    $date_unit = $_POST['date_unit'];
    $time_unit = $_POST['time_unit'];

    $result = $con->query("UPDATE unit SET host_id = '$host_id', elec_unit = '$elec_unit', water_unit = '$water_unit', date_unit = '$date_unit', time_unit = '$time_unit' WHERE unit_id = '$unit_id'");

    if ($result) {
        $res['message'] = "Unit update";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not update";
    }
}

if ($action == 'delete') {
    $id = $_POST["id"];

    $result = $con->query("DELETE FROM room WHERE id = '$id'");

    if ($result) {
        $res['message'] = "Room deleted";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not deleted";
    }
}

$con->close();

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
echo json_encode($res);
die();
