<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

include('../db_connection.php');

// รับพารามิเตอร์
$type = $_GET['type'];
$id = intval($_GET['id']);

switch ($type) {
    case 'buildings':
        $table_name = 'buildings';
        $redirect_url = 'manage_template.php?type=buildings';
        break;
    case 'rooms':
        $table_name = 'rooms';
        $redirect_url = 'manage_template.php?type=rooms';
        break;
    case 'news':
        $table_name = 'news';
        $redirect_url = 'manage_template.php?type=news';
        break;
    default:
        header('Location: manage_data.php');
        exit;
}

// ลบข้อมูล
$delete_query = "DELETE FROM $table_name WHERE id = $id";
mysqli_query($conn, $delete_query);

header("Location: $redirect_url");
exit;
?>
