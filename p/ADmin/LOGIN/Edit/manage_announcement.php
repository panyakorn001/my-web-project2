<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

require_once 'db_connection.php';

// ดึงข้อมูลข่าวประชาสัมพันธ์ทั้งหมด
$query = "SELECT * FROM announcements ORDER BY date DESC";
$result = mysqli_query($conn, $query);

$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข่าวประชาสัมพันธ์</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        h1 {
            text-align: center;
            background-color: #0d6efd;
            color: white;
            padding: 1.5rem 0;
            margin: 0;
        }

        table {
            width: 95%;
            max-width: 1000px;
            margin: 2rem auto;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #e9f0f8;
        }

        img {
            width: 100px;
            height: auto;
        }

        a.button {
            padding: 8px 14px;
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.2s;
        }

        a.button:hover {
            background-color: #0b5ed7;
        }

        a.button.delete {
            background-color: #dc3545;
        }

        a.button.delete:hover {
            background-color: #b02a37;
        }

        .back-button {
            width: 95%;
            max-width: 1000px;
            margin: 0 auto 20px;
            text-align: left;
        }

        .back-button a {
            background-color: #6c757d;
        }
    </style>
    <script>
        window.onload = function () {
            <?php if ($status == 'success') { ?>
                alert("ลบข้อมูลข่าวประชาสัมพันธ์สำเร็จ");
            <?php } ?>
        }
    </script>
</head>
<body>
    <h1>จัดการข่าวประชาสัมพันธ์</h1>


    <table>
        <thead>
            <tr>
                <th>หัวข้อข่าว</th>
                <th>รายละเอียด</th>
                <th>วันที่</th>
                <th>รูปภาพ</th>
                <th>การกระทำ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td>
                        <?php if (!empty($row['image_path'])) { ?>
                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="รูปภาพข่าว">
                        <?php } else { echo 'ไม่มีรูปภาพ'; } ?>
                    </td>
                    <td>
                        <a class="button" href="edit_announcement.php?id=<?php echo $row['id']; ?>">แก้ไข</a>
                        <a class="button delete" href="delete_announcement.php?id=<?php echo $row['id']; ?>" onclick="return confirm('คุณต้องการลบข่าวนี้ใช่หรือไม่?')">ลบ</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="back-button">
        <a href="manage_data.php" class="button">ย้อนกลับ</a>
    </div>
</body>
</html>
