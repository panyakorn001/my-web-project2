<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'university_system');

    if ($conn->connect_error) {
        die('การเชื่อมต่อฐานข้อมูลล้มเหลว: ' . $conn->connect_error);
    }

    $sql = "SELECT * FROM admins WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ล็อกอินแอดมิน</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #333;
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        header {
            background: rgba(21, 101, 192, 0.85);
            padding: 2rem 1rem;
            text-align: center;
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            backdrop-filter: blur(5px);
        }

        .form-section {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        input {
            padding: 0.8rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #1565c0;
            outline: none;
            box-shadow: 0 0 5px rgba(21, 101, 192, 0.4);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        button, .back-button {
            flex: 1;
            padding: 0.9rem;
            font-size: 1rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button {
            background-color: #1565c0;
            color: white;
        }

        button:hover {
            background-color: #0d47a1;
            transform: scale(1.03);
        }

        .back-button {
            background-color: #e53935;
            color: white;
        }

        .back-button:hover {
            background-color: #c62828;
            transform: scale(1.03);
        }

        p.error {
            color: red;
            text-align: center;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background: rgba(21, 101, 192, 0.8);
            color: white;
            font-size: 0.9rem;
            backdrop-filter: blur(5px);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        @media (max-width: 600px) {
            header {
                font-size: 1.5rem;
                padding: 1.5rem 1rem;
            }
            .form-container {
                padding: 1.5rem;
            }
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        ล็อกอินแอดมิน
    </header>

    <section class="form-section">
        <div class="form-container">
            <form action="index.php" method="post">
                <label for="username">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">

                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" required autocomplete="new-password">

                <?php if (isset($error)): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <div class="button-group">
                <button onclick="window.location.href='http://localhost/index.html';">ย้อนกลับ</button>
                    <button type="submit">ล็อกอิน</button>
                </div>
            </form>
        </div>
    </section>

    <footer>
        © 2024 ระบบนำทางตึกมหาวิทยาลัย
    </footer>
</body>
</html>
