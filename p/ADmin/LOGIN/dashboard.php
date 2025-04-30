<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลักแอดมิน</title>
    <style>
        :root {
            --primary: #4a90e2;
            --primary-dark: #357ab8;
            --bg-light: #f4f4f9;
            --text: #333;
            --white: #fff;
            --gray: #6c757d;
            --danger: #dc3545;
            --radius: 10px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--text);
        }

        header {
            background-color: var(--primary);
            color: var(--white);
            padding: 20px;
            text-align: center;
            box-shadow: var(--shadow);
        }

        nav {
            background-color: var(--white);
            padding: 15px 0;
            text-align: center;
            box-shadow: var(--shadow);
        }

        nav a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 15px;
            background-color: var(--primary);
            color: var(--white);
            text-decoration: none;
            border-radius: var(--radius);
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        nav a:hover {
            background-color: var(--primary-dark);
        }

        nav a.logout {
            background-color: var(--danger);
        }

        nav a.logout:hover {
            background-color: #c82333;
        }

        main {
            padding: 40px 20px;
            text-align: center;
        }

        main h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        main p {
            font-size: 16px;
            color: var(--gray);
        }

        footer {
            text-align: center;
            padding: 15px;
            background-color: var(--white);
            box-shadow: var(--shadow);
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            nav a {
                display: block;
                margin: 10px auto;
                width: 80%;
            }

            main h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>ยินดีต้อนรับ, <?php echo htmlspecialchars($username); ?>!</h1>
    </header>

    <nav>
        <a href="add/building_form.php">🏢 กรอกข้อมูลตึก</a>
        <a href="add/room_form.php">🚪 กรอกข้อมูลห้อง</a>
        <a href="add/news_form.php">📢 ข้อมูลประชาสัมพันธ์</a>
        <a href="Edit/manage_data.php">🛠 จัดการข้อมูล</a>
        <a href="logout.php" class="logout">🚪 ออกจากระบบ</a>
    </nav>

    <main>
        <h2>หน้าหลักสำหรับผู้ดูแลระบบ</h2>
        <p>เลือกเมนูด้านบนเพื่อจัดการข้อมูลของคุณ</p>
    </main>

    <footer>
        <p>© 2024 ระบบนำทางตึกมหาวิทยาลัย</p>
    </footer>
</body>
</html>
