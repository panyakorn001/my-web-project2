<?php
if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] == 0) {
    $target_directory = "uploads/";
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    $new_filename = time() . '.' . strtolower(pathinfo($_FILES["image_file"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_directory . $new_filename;

    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        if ($_FILES["image_file"]["size"] < 2000000) {
            if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                echo "<script>alert('เกิดข้อผิดพลาดในการย้ายไฟล์!');</script>";
                $target_file = NULL;
            }
        } else {
            echo "<script>alert('ไฟล์ใหญ่เกิน 2MB!');</script>";
            $target_file = NULL;
        }
    } else {
        echo "<script>alert('อนุญาตเฉพาะไฟล์ jpg, jpeg, png, gif เท่านั้น!');</script>";
        $target_file = NULL;
    }
} else {
    $target_file = NULL;
}

// เชื่อม PostgreSQL จาก DATABASE_URL
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

    $building_name = $_POST['building_name'];
    $building_description = $_POST['building_description'];
    $latitude = floatval($_POST['latitude']);
    $longitude = floatval($_POST['longitude']);

    $sql = "INSERT INTO buildings (building_name, building_description, latitude, longitude, image_url) 
            VALUES (:building_name, :building_description, :latitude, :longitude, :image_url)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':building_name', $building_name);
    $stmt->bindParam(':building_description', $building_description);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':image_url', $target_file);

    if ($stmt->execute()) {
        echo "<script>
            alert('บันทึกข้อมูลตึกเรียบร้อยแล้ว!');
            window.location.href = 'building_form.php';
        </script>";
    } else {
        echo "เกิดข้อผิดพลาด";
    }

} catch (PDOException $e) {
    echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
}
?>
