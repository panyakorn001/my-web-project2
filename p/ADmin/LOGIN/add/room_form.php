<?php
// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "university_system");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลตึกจากฐานข้อมูล
$sql = "SELECT id, building_name FROM buildings";
$result = $conn->query($sql);

$buildings = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลห้อง</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            background-color: #f4f6f8;
            color: #333;
        }

        header {
            background-color: #1565c0;
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-radius: 0 0 12px 12px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-top: 0.5rem;
            display: inline-block;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .form-section {
            max-width: 700px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-section h2 {
            margin-bottom: 1rem;
            color: #1565c0;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        textarea {
            resize: vertical;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #1565c0;
            outline: none;
        }

        button {
            background-color: #1565c0;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        button {
            margin-top: 2rem;
            background-color: #0077cc;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #005fa3;
        }
        .back-button {
            margin-top: 1rem;
            display: inline-block;
            background-color: #ff7043;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #ff5722;
        }
        footer {
            text-align: center;
            margin-top: 3rem;
            color: #888;
        }
        @media (max-width: 600px) {
            .form-section {
                padding: 1rem;
                margin: 1rem;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>ระบบนำทางไปยังตึกมหาวิทยาลัย</h1>
        
    </header>

    <section class="form-section">
        <h2>กรอกข้อมูลห้องใหม่</h2>
        <form action="save_room.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="building_id">เลือกตึก:</label>
                <select id="building_id" name="building_id" required>
                    <option value="">-- กรุณาเลือกตึก --</option>
                    <?php foreach ($buildings as $building): ?>
                        <option value="<?= $building['id'] ?>"><?= htmlspecialchars($building['building_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="room_name">ชื่อของห้อง:</label>
                <input type="text" id="room_name" name="room_name" required>
            </div>

            <div class="form-group">
                <label for="room_description">รายละเอียดของห้อง:</label>
                <textarea id="room_description" name="room_description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="floor">ชั้น:</label>
                <input type="number" id="floor" name="floor" required>
            </div>

            <div class="form-group">
                <label for="latitude">ละติจูด:</label>
                <input type="number" step="any" id="latitude" name="latitude" required>
            </div>

            <div class="form-group">
                <label for="longitude">ลองจิจูด:</label>
                <input type="number" step="any" id="longitude" name="longitude" required>
            </div>

            <div class="form-group">
                <label for="image_file">เลือกไฟล์รูปภาพห้อง:</label>
                <input type="file" id="image_file" name="image_file" accept="image/*" required>
            </div>

        <button type="submit">บันทึกข้อมูล</button>
        <a href="../dashboard.php" class="back-button">ย้อนกลับไปหน้าแรก</a>
        </form>
        
    </section>

    <footer>
        <p>© 2024 ระบบนำทางตึกมหาวิทยาลัย</p>
    </footer>
</body>
</html>
