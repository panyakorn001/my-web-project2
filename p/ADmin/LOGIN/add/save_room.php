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

// ✅ อ่าน DATABASE_URL จาก Heroku
$dbUrl = getenv("DATABASE_URL");
$dbparts = parse_url($dbUrl);

$host = $dbparts['host'];
$port = $dbparts['port'];
$user = $dbparts['user'];
$pass = $dbparts['pass'];
$dbname = ltrim($dbparts['path'], '/');

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $building_id = intval($_POST['building_id']);
    $room_name = $_POST['room_name'];
    $room_description = $_POST['room_description'];
    $floor = intval($_POST['floor']);
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);

    $sql = "INSERT INTO rooms (building_id, room_name, room_description, floor, latitude, longitude, image_url)
            VALUES (:building_id, :room_name, :room_description, :floor, :latitude, :longitude, :image_url)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':building_id', $building_id);
    $stmt->bindParam(':room_name', $room_name);
    $stmt->bindParam(':room_description', $room_description);
    $stmt->bindParam(':floor', $floor);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':image_url', $target_file);

    if ($stmt->execute()) {
        echo "<script>
            alert('บันทึกข้อมูลห้องเรียบร้อยแล้ว!');
            window.location.href = 'room_form.php';
        </script>";
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }

} catch (PDOException $e) {
    echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
}
?>
