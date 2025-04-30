<?php
session_start(); // เริ่มต้น session เพื่อแสดงข้อความแจ้งเตือน
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข่าวประชาสัมพันธ์</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 1rem;
        }
        header {
            background-color: #0077cc;
            color: white;
            padding: 1.5rem 1rem;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 2rem;
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
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        form label {
            display: block;
            margin-top: 1.2rem;
            font-weight: bold;
        }
        form input,
        form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        form textarea {
            resize: vertical;
            min-height: 100px;
        }
        form input:focus,
        form textarea:focus {
            border-color: #0077cc;
            outline: none;
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
            }
            button {
                width: 100%;
            }
        }
        .message {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 8px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <header>
        <h1>เพิ่มข่าวประชาสัมพันธ์</h1>
    </header>

    <section class="form-section">
        <?php
        // แสดงข้อความแจ้งเตือน (Success/Error)
        if (isset($_SESSION['success'])) {
            echo "<div class='message success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='message error'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']);
        }
        ?>

        <form action="save_announcement.php" method="post" enctype="multipart/form-data">
            <label for="title">หัวข้อข่าว:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">รายละเอียดข่าว:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="date">วันที่:</label>
            <input type="date" id="date" name="date" required>

            <label for="image_file">เลือกรูปภาพข่าว:</label>
            <input type="file" id="image_file" name="image_file" accept="image/jpeg, image/png, image/jpg">

            <button type="submit">บันทึกข่าว</button>
        </form>

        <a href="../dashboard.php" class="back-button">ย้อนกลับไปหน้าแรก</a>
    </section>

    <footer>
        <p>© 2024 ระบบนำทางตึกมหาวิทยาลัย</p>
    </footer>
</body>
</html>
