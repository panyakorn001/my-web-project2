<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

require_once 'db_connection.php';

if (isset($_GET['id'])) {
    $room_id = $_GET['id'];

    // ลบข้อมูลห้อง
    $delete_room_query = "DELETE FROM rooms WHERE id = $room_id";
    if (mysqli_query($conn, $delete_room_query)) {
        // ถ้าลบสำเร็จ redirect ไปที่ manage_rooms.php พร้อม status=success
        header('Location: manage_room.php?status=success');
        exit;
    } else {
        echo "Error deleting room: " . mysqli_error($conn);
    }
}
?>
