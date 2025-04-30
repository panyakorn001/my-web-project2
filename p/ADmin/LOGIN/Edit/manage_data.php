<?php
session_start();

// ตรวจสอบการล็อกอิน
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข้อมูล</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }
        .button-link {
            display: block;
            margin: 12px auto;
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .button-link:hover {
            background-color: #0056b3;
        }
        .back-button {
            margin-top: 25px;
            display: block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #5a6268;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 20px;
            }
            h1 {
                font-size: 20px;
            }
            .button-link,
            .back-button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>จัดการข้อมูล (แก้ไข/ลบ)</h1>
        <a class="button-link" href="manage_buildings.php">จัดการข้อมูลตึก</a>
        <a class="button-link" href="manage_room.php">จัดการข้อมูลห้อง</a>
        <a class="button-link" href="manage_announcement.php">จัดการข่าวประชาสัมพันธ์</a>

        <a class="back-button" href="../dashboard.php">ย้อนกลับ</a> <!-- ปรับลิงก์ตามหน้าหลักของคุณ -->
    </div>
</body>
</html>
