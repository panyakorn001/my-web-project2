<?php
// ตรวจสอบการเชื่อมต่อกับ Heroku หรือ Railway
$dsn = getenv('DATABASE_URL'); // รับค่าจาก env หรือ config ของ Heroku/Railway
if ($dsn) {
    $parsed_url = parse_url($dsn);

    // แยกข้อมูลจาก URL
    $host = $parsed_url['host'];
    $user = $parsed_url['user'];
    $pass = $parsed_url['pass'];
    $db = ltrim($parsed_url['path'], '/');
    $port = $parsed_url['port'];

    // สร้างการเชื่อมต่อ
    $conn = new mysqli($host, $user, $pass, $db, $port);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }
} else {
    // การเชื่อมต่อในกรณีที่ไม่ใช่ Heroku หรือ Railway
    $conn = new mysqli('localhost', 'root', '', 'university_system');
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ข้อมูลตึกมหาวิทยาลัย</title>
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

    .building-option .description {
      padding: 0 0.8rem 0.8rem;
      font-size: 0.95rem;
      color: #555;
      font-weight: normal;
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
    <h1>ข้อมูลตึกมหาวิทยาลัย</h1>
  </header>

  <section>
    <h2>แสดงข้อมูลของตึกทั้งหมด</h2>
    <div class="building-grid">
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="building-option">
          <img src="image_viewer.php?file=<?= urlencode($row['image_url']) ?>" alt="<?= htmlspecialchars($row['building_name']) ?>">
          <p><?= htmlspecialchars($row['building_name']) ?></p>
          <p class="description"><?= nl2br(htmlspecialchars($row['building_description'])) ?></p>
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
