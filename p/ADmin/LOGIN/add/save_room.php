<?php
if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] == 0) {
    $target_directory = "uploads/";
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }
    $target_file = $target_directory . basename($_FILES["image_file"]["name"]);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        if ($_FILES["image_file"]["size"] < 2000000) {
            if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                $target_file = '';
            }
        } else {
            $target_file = '';
        }
    } else {
        $target_file = '';
    }
} else {
    $target_file = '';
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$building_id = intval($_POST['building_id']);
$room_name = $conn->real_escape_string($_POST['room_name']);
$room_description = $conn->real_escape_string($_POST['room_description']);
$floor = intval($_POST['floor']);
$latitude = floatval($_POST['latitude']);
$longitude = floatval($_POST['longitude']);

$sql = $conn->prepare("INSERT INTO rooms (building_id, room_name, room_description, floor, latitude, longitude, image_url) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("sssddds", $building_id, $room_name, $room_description, $floor, $latitude, $longitude, $target_file);

if ($sql->execute()) {
    // ใช้ JavaScript แสดงป๊อปอัปแล้ว redirect
    echo "<script>
        alert('บันทึกข้อมูลห้องเรียบร้อยแล้ว!');
        window.location.href = 'room_form.php';
    </script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $sql->error;
}

$conn->close();
?>
