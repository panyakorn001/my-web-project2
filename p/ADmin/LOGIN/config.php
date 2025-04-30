<?php
$host = 'localhost'; // ชื่อเซิร์ฟเวอร์ MySQL
$dbname = 'university_system'; // ใส่ชื่อฐานข้อมูลของคุณ เช่น university_navigation
$username = 'root'; // ชื่อผู้ใช้ MySQL (ค่าเริ่มต้นคือ root)
$password = ''; // รหัสผ่าน MySQL (ค่าเริ่มต้นคือค่าว่าง)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("เกิดข้อผิดพลาด: " . $e->getMessage());
}
?>
