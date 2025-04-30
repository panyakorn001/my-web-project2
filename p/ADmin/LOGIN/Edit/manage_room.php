<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

require_once 'db_connection.php';

// ดึงข้อมูลห้องทั้งหมด พร้อมชื่ออาคารที่สัมพันธ์กัน
$query = "
    SELECT rooms.*, buildings.building_name 
    FROM rooms 
    JOIN buildings ON rooms.building_id = buildings.id
";
$result = mysqli_query($conn, $query);

$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการข้อมูลห้อง</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        td:last-child {
            display: flex;
            justify-content: center;
            gap: 10px;
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

        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 1rem;
                background-color: white;
                border-radius: 10px;
                padding: 1rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            }

            td {
                text-align: left;
                padding: 0.5rem 1rem;
                border: none;
                position: relative;
            }

            td:before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 0.3rem;
            }

            td:last-child {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    <script>
        window.onload = function () {
            <?php if ($status == 'success') { ?>
                alert("ลบข้อมูลห้องสำเร็จ");
            <?php } ?>
        }
    </script>
</head>
<body>
    <h1>จัดการข้อมูลห้อง</h1>
    <table>
        <thead>
            <tr>
                <th>ชื่อห้อง</th>
                <th>รายละเอียดห้อง</th>
                <th>ชั้น</th>
                <th>ตึก</th>
                <th>การกระทำ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td data-label="ชื่อห้อง"><?php echo htmlspecialchars($row['room_name']); ?></td>
                    <td data-label="รายละเอียดห้อง"><?php echo htmlspecialchars($row['room_description']); ?></td>
                    <td data-label="ชั้น"><?php echo htmlspecialchars($row['floor']); ?></td>
                    <td data-label="ตึก"><?php echo htmlspecialchars($row['building_name']); ?></td>
                    <td data-label="การกระทำ">
                        <a class="button" href="edit_room.php?id=<?php echo $row['id']; ?>">แก้ไข</a>
                        <a class="button delete" href="delete_room.php?id=<?php echo $row['id']; ?>" onclick="return confirm('คุณต้องการลบข้อมูลห้องนี้ใช่หรือไม่?')">ลบ</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="width: 95%; max-width: 1000px; margin: 20px auto 0;">
        <a href="manage_data.php" class="button" style="background-color: #6c757d;">ย้อนกลับ</a>
    </div>
</body>
</html>
