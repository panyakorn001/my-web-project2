<?php
if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] == 0) {
    // กำหนดตำแหน่งที่ต้องการเก็บไฟล์
    $target_directory = "uploads/"; // โฟลเดอร์ที่เก็บไฟล์
    if (!is_dir($target_directory)) {
        mkdir($target_directory, 0777, true); // สร้างโฟลเดอร์ถ้าไม่มี
    }
    $target_file = $target_directory . basename($_FILES["image_file"]["name"]);
    
    // ตรวจสอบประเภทไฟล์ (ถ้าต้องการจำกัดเฉพาะไฟล์บางประเภท)
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ตรวจสอบว่าไฟล์สามารถอัปโหลดได้หรือไม่
    if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        // ตรวจสอบขนาดไฟล์ (กำหนดขนาดไฟล์สูงสุดที่ 2MB)
        if ($_FILES["image_file"]["size"] < 2000000) { 
            // ตรวจสอบว่ามีการอัพโหลดไฟล์
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                echo "ไฟล์ " . basename($_FILES["image_file"]["name"]) . " อัปโหลดสำเร็จ!";
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์!";
                $target_file = ''; // ถ้าไม่สามารถอัปโหลดได้ ให้กำหนดให้เป็นค่าว่าง
            }
        } else {
            echo "ไฟล์ที่อัปโหลดมีขนาดใหญ่เกินไป! กรุณาเลือกไฟล์ที่มีขนาดไม่เกิน 2MB.";
            $target_file = ''; // ถ้าไฟล์ใหญ่เกินไปให้กำหนดเป็นค่าว่าง
        }
    } else {
        echo "กรุณาอัปโหลดไฟล์ภาพเท่านั้น!";
        $target_file = ''; // ถ้าไม่ใช่ไฟล์ภาพให้กำหนดเป็นค่าว่าง
    }
} else {
    $target_file = ''; // ถ้าไม่อัปโหลดไฟล์ ให้กำหนดให้เป็นค่าว่าง
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root"; // เปลี่ยนเป็นชื่อผู้ใช้ของคุณ
$password = ""; // เปลี่ยนเป็นรหัสผ่านของคุณ
$dbname = "university_system"; // เปลี่ยนเป็นชื่อฐานข้อมูลของคุณ

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์มและป้องกัน SQL Injection
$building_id = intval($_POST['building_id']); // ใช้ building_id แทน building_name
$room_name = $conn->real_escape_string($_POST['room_name']);
$room_description = $conn->real_escape_string($_POST['room_description']);
$floor = intval($_POST['floor']);
$latitude = floatval($_POST['latitude']);
$longitude = floatval($_POST['longitude']);

// สร้างคำสั่ง SQL สำหรับเพิ่มข้อมูล
$sql = $conn->prepare("INSERT INTO rooms (building_id, room_name, room_description, floor, latitude, longitude, image_url) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("sssddds", $building_id, $room_name, $room_description, $floor, $latitude, $longitude, $target_file);

// ตรวจสอบว่าเพิ่มข้อมูลสำเร็จหรือไม่
if ($sql->execute()) {
    echo "ข้อมูลห้องถูกบันทึกเรียบร้อยแล้ว!";
} else {
    echo "เกิดข้อผิดพลาด: " . $sql->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
