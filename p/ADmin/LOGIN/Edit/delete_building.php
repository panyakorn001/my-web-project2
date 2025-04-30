<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

require_once 'db_connection.php';

if (isset($_GET['id'])) {
    $building_id = $_GET['id'];

    // ลบข้อมูลใน rooms ที่อ้างอิงถึงตึกนี้ก่อน
    $delete_rooms_query = "DELETE FROM rooms WHERE building_id = $building_id";
    mysqli_query($conn, $delete_rooms_query);

    // ลบข้อมูลตึก
    $delete_building_query = "DELETE FROM buildings WHERE id = $building_id";
    if (mysqli_query($conn, $delete_building_query)) {
        // ถ้าลบสำเร็จ redirect ไปที่ manage_buildings.php พร้อม status=success
        header('Location: manage_buildings.php?status=success');
        exit;
    } else {
        echo "Error deleting building: " . mysqli_error($conn);
    }
}
?>
