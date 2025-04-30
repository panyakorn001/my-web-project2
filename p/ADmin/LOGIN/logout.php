<?php
// เริ่มต้นเซสชัน
session_start();

// ลบข้อมูลในเซสชันทั้งหมด
session_unset();

// ทำลายเซสชัน
session_destroy();

// เปลี่ยนเส้นทางกลับไปที่หน้าล็อกอิน
header('Location: index.php');
exit;
?>
