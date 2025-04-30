<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
require_once 'db_connection.php';

if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];
    $query = "SELECT * FROM announcements WHERE id = $announcement_id";
    $result = mysqli_query($conn, $query);
    $announcement = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $image = $_FILES['image']['name'];

    if ($image) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'images/' . basename($image);
        move_uploaded_file($image_tmp, $image_path);

        $update_query = "
            UPDATE announcements 
            SET title = '$title', description = '$description', date = '$date', image_path = '$image_path' 
            WHERE id = $announcement_id
        ";
    } else {
        $update_query = "
            UPDATE announcements 
            SET title = '$title', description = '$description', date = '$date' 
            WHERE id = $announcement_id
        ";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('อัปเดตข่าวเรียบร้อยแล้ว!'); window.location.href = 'manage_announcement.php';</script>";
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
    <title>แก้ไขข่าวประชาสัมพันธ์</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; }
        .container { width: 50%; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; }
        input[type="text"], input[type="date"], textarea, input[type="file"] {
            width: 100%; padding: 10px; margin-top: 6px; border-radius: 5px; border: 1px solid #ccc;
        }
        button {
            padding: 12px; background-color: #007bff; color: white; border: none;
            width: 100%; border-radius: 5px; cursor: pointer; font-size: 16px;
        }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>แก้ไขข่าวประชาสัมพันธ์</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">หัวข้อข่าว:</label>
                <input type="text" id="title" name="title" value="<?php echo $announcement['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">รายละเอียด:</label>
                <textarea id="description" name="description" required><?php echo $announcement['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="date">วันที่:</label>
                <input type="date" id="date" name="date" value="<?php echo $announcement['date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="image">รูปภาพ (ถ้ามี):</label>
                <input type="file" id="image" name="image">
            </div>
            <button type="submit">อัปเดตข้อมูล</button>
        </form>
        <div style="margin-top: 20px;">
    <a href="manage_announcement.php" style="display: inline-block; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">ย้อนกลับ</a>
</div>
    </div>
    
</body>
</html>
