<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

require_once 'db_connection.php';

if (isset($_GET['id'])) {
    $announcement_id = intval($_GET['id']); // ป้องกัน SQL Injection เล็กน้อยด้วย intval()

    // ลบข้อมูลข่าวประชาสัมพันธ์
    $delete_query = "DELETE FROM announcements WHERE id = $announcement_id";
    if (mysqli_query($conn, $delete_query)) {
        // ถ้าลบสำเร็จ redirect กลับไปที่ manage_announcement.php พร้อมส่งสถานะ success
        header('Location: manage_announcement.php?status=success');
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการลบข่าวประชาสัมพันธ์: " . mysqli_error($conn);
    }
} else {
    echo "ไม่พบ ID ของข่าวที่ต้องการลบ";
}
?>
