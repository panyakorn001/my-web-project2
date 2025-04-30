<?php
// เชื่อมต่อฐานข้อมูล
$host = 'localhost';
$db = 'university_system';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลตึก
$sql = "SELECT * FROM buildings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>เลือกตึกมหาวิทยาลัย</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }

    header {
      background-color: #00695c;
      color: white;
      padding: 1.5rem;
      text-align: center;
    }

    h2 {
      text-align: center;
      margin: 2rem 0 1rem;
      color: #00695c;
    }

    .building-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 1rem 2rem;
    }

    .building-option {
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 10px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .building-option:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .building-option img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .building-option p {
      padding: 0.8rem;
      font-size: 1.1rem;
      font-weight: bold;
      color: #004d40;
      text-align: center;
    }

    footer {
      background-color: #004d40;
      color: white;
      text-align: center;
      padding: 1.2rem;
    }

    footer button {
      padding: 10px 25px;
      font-size: 16px;
      background-color: #26a69a;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    footer button:hover {
      background-color: #00796b;
    }
  </style>
</head>
<body>
  <header>
    <h1>เลือกตึกมหาวิทยาลัย</h1>
  </header>

  <section>
    <h2>เลือกตึกเพื่อดูข้อมูล</h2>
    <div class="building-grid">
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="building-option">
          <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['building_name']) ?>">
          <p><?= htmlspecialchars($row['building_name']) ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <footer>
    <button onclick="window.history.back()">ย้อนกลับ</button>
  </footer>
</body>
</html>

<?php $conn->close(); ?>
