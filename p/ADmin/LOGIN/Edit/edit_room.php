<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

require_once 'db_connection.php';

// ตรวจสอบว่ามีการส่ง ID ห้องมา
if (isset($_GET['id'])) {
    $room_id = $_GET['id'];

    // ดึงข้อมูลห้อง
    $query = "SELECT * FROM rooms WHERE id = $room_id";
    $result = mysqli_query($conn, $query);
    $room = mysqli_fetch_assoc($result);
}

// อัปเดตข้อมูลเมื่อ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $room_description = $_POST['room_description'];
    $floor = $_POST['floor'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'images/' . basename($image);
        move_uploaded_file($image_tmp, $image_path);

        $update_query = "UPDATE rooms SET room_name = '$room_name', room_description = '$room_description', floor = '$floor', latitude = '$latitude', longitude = '$longitude', image = '$image_path' WHERE id = $room_id";
    } else {
        $update_query = "UPDATE rooms SET room_name = '$room_name', room_description = '$room_description', floor = '$floor', latitude = '$latitude', longitude = '$longitude' WHERE id = $room_id";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('อัปเดตข้อมูลห้องเรียบร้อยแล้ว!'); window.location.href = 'manage_rooms.php';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลห้อง</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>แก้ไขข้อมูลห้อง</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="room_name">ชื่อห้อง:</label>
                <input type="text" id="room_name" name="room_name" value="<?php echo $room['room_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="room_description">รายละเอียดห้อง:</label>
                <textarea id="room_description" name="room_description" required><?php echo $room['room_description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="floor">ชั้น:</label>
                <input type="number" id="floor" name="floor" value="<?php echo $room['floor']; ?>" required>
            </div>

            <div class="form-group">
                <label for="latitude">ละติจูด:</label>
                <input type="text" id="latitude" name="latitude" value="<?php echo $room['latitude']; ?>" required>
            </div>

            <div class="form-group">
                <label for="longitude">ลองจิจูด:</label>
                <input type="text" id="longitude" name="longitude" value="<?php echo $room['longitude']; ?>" required>
            </div>

            <div class="form-group">
                <label for="image">รูปภาพของห้อง (ถ้ามี):</label>
                <input type="file" id="image" name="image">
            </div>

            <button type="submit">อัปเดตข้อมูล</button>
        </form>
        <div style="margin-top: 20px;">
    <a href="manage_room.php" style="display: inline-block; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">ย้อนกลับ</a>
</div>
    </div>
</body>
</html>
