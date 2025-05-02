<?php
if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] == 0) {
    $target_directory = "uploads/";
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true);
    }

    // สร้างชื่อไฟล์ใหม่กันซ้ำ เช่น 1234567890.jpg
    $new_filename = time() . '.' . strtolower(pathinfo($_FILES["image_file"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_directory . $new_filename;

    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        if ($_FILES["image_file"]["size"] < 2000000) {
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                // อัปโหลดสำเร็จ
            } else {
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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$building_name = $conn->real_escape_string($_POST['building_name']);
$building_description = $conn->real_escape_string($_POST['building_description']);
$latitude = floatval($_POST['latitude']);
$longitude = floatval($_POST['longitude']);

$sql = $conn->prepare("INSERT INTO buildings (building_name, building_description, latitude, longitude, image_url) 
                       VALUES (?, ?, ?, ?, ?)");
$sql->bind_param("sssds", $building_name, $building_description, $latitude, $longitude, $target_file);

if ($sql->execute()) {
    echo "<script>
        alert('บันทึกข้อมูลตึกเรียบร้อยแล้ว!');
        window.location.href = 'building_form.php';
    </script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $sql->error;
}

$conn->close();
?>
