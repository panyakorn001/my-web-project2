<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลตึก</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f0f4f8;
            color: #333;
            line-height: 1.6;
            padding: 1rem;
        }

        header {
            background-color: #0d47a1;
            color: white;
            padding: 1rem;
            text-align: center;
            margin-bottom: 2rem;
            border-radius: 8px;
        }

        nav a {
            color: white;
            margin: 0 1rem;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .form-section {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-container label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
        }

        .form-container input,
        .form-container textarea {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.25rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-container input:focus,
        .form-container textarea:focus {
            border-color: #0d47a1;
            outline: none;
        }

        button {
            margin-top: 1.5rem;
            background-color: #0d47a1;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1565c0;
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
            color: #777;
        }

        @media (max-width: 600px) {
            .form-section {
                padding: 1rem;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>เพิ่มข้อมูลตึก</h1>
    </header>

    <section class="form-section">
        <form action="save_building.php" method="post" enctype="multipart/form-data" class="form-container">
            <label for="building_name">ชื่อของตึก:</label>
            <input type="text" id="building_name" name="building_name" required>
            
            <label for="building_description">รายละเอียดของตึก:</label>
            <textarea id="building_description" name="building_description" required></textarea>
            
            <label for="latitude">ละติจูด:</label>
            <input type="number" step="any" id="latitude" name="latitude" required>
            
            <label for="longitude">ลองจิจูด:</label>
            <input type="number" step="any" id="longitude" name="longitude" required>
            
            <label for="image_file">อัปโหลดรูปภาพของตึก:</label>
            <input type="file" id="image_file" name="image_file" accept="image/*">
            
            <button type="submit">บันทึกข้อมูล</button>
        </form>

        <a href="../dashboard.php" class="back-button">ย้อนกลับไปหน้าแรก</a>
    </section>

    <footer>
        <p>© 2025 ระบบนำทางตึกมหาวิทยาลัย</p>
    </footer>
</body>
</html>
