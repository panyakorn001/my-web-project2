<?php
// ตรวจสอบว่าไฟล์ถูกอัปโหลดมาหรือไม่
if (isset($_FILES["image_url"]) && $_FILES["image_url"]["error"] == 0) {
    // กำหนดตำแหน่งที่ต้องการเก็บไฟล์
    $target_directory = "uploads/"; // โฟลเดอร์ที่เก็บไฟล์
    $target_file = $target_directory . basename($_FILES["image_url"]["name"]);
    
    // ตรวจสอบประเภทไฟล์ (ถ้าต้องการจำกัดเฉพาะไฟล์บางประเภท)
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // ตรวจสอบว่าไฟล์สามารถอัปโหลดได้หรือไม่
    if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
        echo "ไฟล์ " . basename($_FILES["image_url"]["name"]) . " อัปโหลดสำเร็จ!";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์!";
        $target_file = ''; // ถ้าไม่สามารถอัปโหลดได้ ให้กำหนดให้เป็นค่าว่าง
    }
} else {
    $target_file = ''; // ถ้าไม่อัปโหลดไฟล์ ให้กำหนดให้เป็นค่าว่าง
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "university_system"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // รับข้อมูลจากฟอร์ม
    $building_name = $_POST['building_name'];
    $building_description = $_POST['building_description'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $image_url = $target_file; // ใช้ path ของไฟล์ที่อัปโหลด

    // สร้างคำสั่ง SQL
    $sql = "INSERT INTO buildings (building_name, building_description, latitude, longitude, image_url)
            VALUES (:building_name, :building_description, :latitude, :longitude, :image_url)";

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':building_name', $building_name);
    $stmt->bindParam(':building_description', $building_description);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':image_url', $image_url);

    // เรียกใช้งานคำสั่ง SQL
    if ($stmt->execute()) {
        echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location.href = 'building_form.php';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }

} catch (PDOException $e) {
    echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
}
$sql = "INSERT INTO buildings (building_name, building_description, latitude, longitude, image_url)
        VALUES ('$building_name', '$building_description', '$latitude', '$longitude', '$image_url')";
$conn = null;
?>
