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
    $result = $con->query("SELECT * FROM room_unit ORDER BY room_number ASC");
    $room_units = array();

    while ($row = $result->fetch_assoc()) {
        array_push($room_units, $row);
    }
    $res['room_units'] = $room_units;
}

if ($action == 'history') {
    $result = $con->query("SELECT DISTINCT unit_date_now, host_id FROM room_unit ORDER BY room_number ASC");
    $room_units = array();

    while ($row = $result->fetch_assoc()) {
        array_push($room_units, $row);
    }
    $res['room_units'] = $room_units;
}

if ($action == 'create') {
    $room_id = $_POST['room_id'];
    $host_id = $_POST['host_id'];
    $name_title = $_POST['name_title'];
    $fullname = $_POST['fullname'];
    $nickname = $_POST['nickname'];
    $room_number = $_POST['room_number'];
    $room_price = $_POST['room_price'];
    $cable_price = $_POST['cable_price'];
    $trash_price = $_POST['trash_price'];
    $park_price = $_POST['park_price'];
    $other_price = $_POST['other_price'];
    $elec_unit = $_POST['elec_unit'];
    $water_unit = $_POST['water_unit'];
    $unit_date_now = $_POST['unit_date_now'];
    $elec_unit_now = $_POST['elec_unit_now'];
    $elec_unit_lastmonth = $_POST['elec_unit_lastmonth'];
    $water_unit_now = $_POST['water_unit_now'];
    $water_unit_lastmonth = $_POST['water_unit_lastmonth'];
    $res_elec = $_POST['res_elec'];
    $res_water = $_POST['res_water'];
    $res_elec_price = $_POST['res_elec_price'];
    $res_water_price = $_POST['res_water_price'];
    $res_service_price = $_POST['res_service_price'];
    $result_bill = $_POST['result_bill'];
    $unit_date = $_POST['unit_date'];
    $unit_time = $_POST['unit_time'];

    $result = $con->query("INSERT INTO room_unit (room_id, host_id, name_title, fullname, nickname, room_number, room_price, cable_price,
     trash_price, park_price, other_price, elec_unit, water_unit, unit_date_now, elec_unit_now, elec_unit_lastmonth, water_unit_now,
     water_unit_lastmonth, res_elec, res_water, res_elec_price, res_water_price, res_service_price, result_bill, unit_date, unit_time) VALUES
        ('$room_id','$host_id','$name_title','$fullname','$nickname','$room_number','$room_price','$cable_price','$trash_price','$park_price','$other_price','$elec_unit','$water_unit','$unit_date_now','$elec_unit_now','$elec_unit_lastmonth','$water_unit_now',
        '$water_unit_lastmonth','$res_elec','$res_water','$res_elec_price','$res_water_price','$res_service_price','$result_bill','$unit_date','$unit_time')");
    if ($result) {
        $res['message'] = "room unit added";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not insert";
    }
}

if ($action == 'update') {
    $room_id = $_POST['room_id'];
    $host_id = $_POST['host_id'];
    $name_title = $_POST['name_title'];
    $fullname = $_POST['fullname'];
    $nickname = $_POST['nickname'];
    $room_number = $_POST['room_number'];
    $room_price = $_POST['room_price'];
    $cable_price = $_POST['cable_price'];
    $trash_price = $_POST['trash_price'];
    $park_price = $_POST['park_price'];
    $other_price = $_POST['other_price'];
    $elec_unit = $_POST['elec_unit'];
    $water_unit = $_POST['water_unit'];
    $unit_date_now = $_POST['unit_date_now'];
    $elec_unit_now = $_POST['elec_unit_now'];
    $elec_unit_lastmonth = $_POST['elec_unit_lastmonth'];
    $water_unit_now = $_POST['water_unit_now'];
    $water_unit_lastmonth = $_POST['water_unit_lastmonth'];
    $res_elec = $_POST['res_elec'];
    $res_water = $_POST['res_water'];
    $res_elec_price = $_POST['res_elec_price'];
    $res_water_price = $_POST['res_water_price'];
    $res_service_price = $_POST['res_service_price'];
    $result_bill = $_POST['result_bill'];
    $unit_date = $_POST['unit_date'];
    $unit_time = $_POST['unit_time'];

    $result = $con->query("UPDATE room_unit SET name_title = '$name_title', fullname = '$fullname',
    nickname = '$nickname', room_price = '$room_price', cable_price = '$cable_price',
    trash_price = '$trash_price', park_price = '$park_price', other_price = '$other_price', elec_unit = '$elec_unit',
    water_unit = '$water_unit', unit_date_now = '$unit_date_now', elec_unit_now = '$elec_unit_now', elec_unit_lastmonth = '$elec_unit_lastmonth',
    water_unit_now = '$water_unit_now', water_unit_lastmonth = '$water_unit_lastmonth', res_elec = '$res_elec', res_water = '$res_water',
    res_elec_price = '$res_elec_price', res_water_price = '$res_water_price', res_service_price = '$res_service_price',
    result_bill = '$result_bill', unit_date = '$unit_date', unit_time = '$unit_time' WHERE room_number = '$room_number' AND host_id = '$host_id' AND room_id = '$room_id'");

    if ($result) {
        $res['message'] = "room_unit update";
    } else {
        $res['err'] = true;
        $res['message'] = "room_unit Could not update";
    }
}

if ($action == 'delete') {
    $room_id = $_POST["room_id"];

    $result = $con->query("DELETE FROM room_unit WHERE room_id = '$room_id'");

    if ($result) {
        $res['message'] = "room_unit deleted";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not deleted";
    }
}

if ($action == 'set') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $room_number = $_POST['room_number'];

    $result = $con->query("UPDATE test SET username = '$username', name = '$name' WHERE email = '$email' AND room_number = '$room_number' ");

    if ($result) {
        $res['message'] = "User set";
    } else {
        $res['err'] = true;
        $res['message'] = "Could not set";
    }
}

$con->close();

header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
echo json_encode($res);
die();
