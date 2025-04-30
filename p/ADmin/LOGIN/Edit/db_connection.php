<?php
// การตั้งค่าการเชื่อมต่อกับฐานข้อมูลใน Laragon
$servername = "localhost";    // ชื่อโฮสต์ (ปกติคือ localhost ใน Laragon)
$username = "root";           // ชื่อผู้ใช้งานฐานข้อมูล (ค่าเริ่มต้นใน Laragon คือ root)
$password = "";               // รหัสผ่าน (ค่าเริ่มต้นใน Laragon ไม่มีรหัสผ่าน)
$dbname = "university_system"; // ชื่อฐานข้อมูลที่คุณสร้าง

// การสร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
