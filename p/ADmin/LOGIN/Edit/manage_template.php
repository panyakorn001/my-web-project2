<?php
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

include('../db_connection.php');

// รับพารามิเตอร์หมวดหมู่
$type = $_GET['type'] ?? 'buildings';
$allowed_types = ['buildings', 'rooms', 'news'];

if (!in_array($type, $allowed_types)) {
    header('Location: manage_data.php');
    exit;
}

$table_name = $type;
$title = $type === 'buildings' ? 'จัดการข้อมูลตึก' : ($type === 'rooms' ? 'จัดการข้อมูลห้อง' : 'จัดการข้อมูลข่าวประชาสัมพันธ์');

// ดึงข้อมูลจากตารางที่เลือก
$query = "SELECT * FROM $table_name";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("เกิดข้อผิดพลาดในการดึงข้อมูล: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <?php
                    $columns = mysqli_fetch_fields($result);
                    foreach ($columns as $column) {
                        echo '<th>' . htmlspecialchars($column->name) . '</th>';
                    }
                    ?>
                    <th>ตัวเลือก</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <?php foreach ($row as $value) : ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        <?php endforeach; ?>
                        <td>
                            <a href="edit.php?type=<?php echo $type; ?>&id=<?php echo $row['id']; ?>">แก้ไข</a> | 
                            <a href="delete.php?type=<?php echo $type; ?>&id=<?php echo $row['id']; ?>" onclick="return confirm('ยืนยันการลบข้อมูล?');">ลบ</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">ไม่มีข้อมูลในหมวดหมู่ที่เลือก</p>
    <?php endif; ?>
</body>
</html>
