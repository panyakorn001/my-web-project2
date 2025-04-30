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

    // ดึงข้อมูลตึกจากฐานข้อมูล
    $query = "SELECT * FROM buildings WHERE id = $building_id";
    $result = mysqli_query($conn, $query);
    $building = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $building_name = $_POST['building_name'];
    $building_description = $_POST['building_description'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $image = $_FILES['image']['name'];

    // ถ้ามีการอัปโหลดรูปภาพ
    if ($image) {
        // อัปโหลดไฟล์
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'images/' . basename($image); // กำหนดที่เก็บไฟล์
        move_uploaded_file($image_tmp, $image_path);

        // อัปเดตข้อมูลตึกพร้อมกับรูปภาพ
        $update_query = "UPDATE buildings SET building_name = '$building_name', building_description = '$building_description', latitude = '$latitude', longitude = '$longitude', image = '$image_path' WHERE id = $building_id";
    } else {
        // ถ้าไม่มีการอัปโหลดรูปภาพ ให้ทำการอัปเดตเฉพาะข้อมูลที่ไม่เกี่ยวข้องกับรูปภาพ
        $update_query = "UPDATE buildings SET building_name = '$building_name', building_description = '$building_description', latitude = '$latitude', longitude = '$longitude' WHERE id = $building_id";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('อัปเดตเสร็จสิ้นแล้ว!'); window.location.href = 'manage_buildings.php';</script>";
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลตึก</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            width: 90%;
            margin: 40px auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 22px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            font-size: 15px;
            color: #555;
            margin-bottom: 6px;
        }
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-button {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        .back-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button a:hover {
            background-color: #5a6268;
        }

        /* Responsive */
        @media (max-width: 480px) {
            h1 {
                font-size: 20px;
            }
            button[type="submit"],
            .back-button a {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>แก้ไขข้อมูลตึก</h1>
        <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="building_name">ชื่อตึก:</label>
        <input type="text" id="building_name" name="building_name" value="<?php echo $building['building_name']; ?>" required>
    </div>

    <div class="form-group">
        <label for="building_description">รายละเอียดตึก:</label>
        <textarea id="building_description" name="building_description" required><?php echo $building['building_description']; ?></textarea>
    </div>

    <div class="form-group">
        <label for="latitude">ละติจูด:</label>
        <input type="text" id="latitude" name="latitude" value="<?php echo $building['latitude']; ?>" required>
    </div>

    <div class="form-group">
        <label for="longitude">ลองจิจูด:</label>
        <input type="text" id="longitude" name="longitude" value="<?php echo $building['longitude']; ?>" required>
    </div>

    <div class="form-group">
        <label for="image">รูปภาพของตึก (ถ้ามี):</label>
        <input type="file" id="image" name="image">
    </div>

    <button type="submit">อัปเดตข้อมูล</button>
</form>
<div style="margin-top: 20px;">
    <a href="manage_buildings.php" style="display: inline-block; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">ย้อนกลับ</a>
</div>
    </div>
</body>
</html>
