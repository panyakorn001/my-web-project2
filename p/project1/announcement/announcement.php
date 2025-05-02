<?php
// เชื่อมต่อฐานข้อมูล
$host = "localhost";
$username = "root";
$password = "";
$database = "university_system";

$conn = new mysqli($host, $username, $password, $database);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลข่าว
$sql = "SELECT * FROM announcements ORDER BY date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ข่าวประชาสัมพันธ์</title>
  <style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    color: #333;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  header {
    background-color: #004080;
    color: white;
    padding: 1.5rem 1rem;
    text-align: center;
  }

  nav {
    margin-top: 10px;
  }

  nav a {
    color: white;
    text-decoration: none;
    padding: 0.5rem 1rem;
    display: inline-block;
    background-color: #0066cc;
    border-radius: 6px;
    transition: background 0.3s ease;
  }

  nav a:hover {
    background-color: #003d80;
  }

  .announcement {
    padding: 2rem;
    max-width: 900px;
    margin: 2rem auto;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  }

  .announcement h2 {
    margin-bottom: 1.5rem;
    color: #004080;
    text-align: center;
  }

  article {
    background-color: #e6f0ff;
    border-left: 5px solid #004080;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
  }

  article h3 {
    color: #003366;
    margin-bottom: 0.5rem;
  }

  article p {
    margin-bottom: 0.5rem;
  }

  article img {
    width: 100%;
    max-width: 600px;
    height: auto;
    margin-top: 10px;
    border-radius: 6px;
    display: block;
  }

  footer {
    background-color: #004080;
    color: white;
    text-align: center;
    padding: 1rem;
    margin-top: auto;
  }

  @media (max-width: 768px) {
    .announcement {
      padding: 1rem;
      margin: 1rem;
    }

    article img {
      max-width: 100%;
    }

    nav a {
      font-size: 0.9rem;
      padding: 0.4rem 0.8rem;
    }

    article h3 {
      font-size: 1.1rem;
    }
  }
</style>

</head>
<body>
  <header>
    <h1>ข่าวประชาสัมพันธ์</h1>
    <nav>
      <a href="../index.html">หน้าหลัก</a>
    </nav>
  </header>

  <section class="announcement">
    <h2>รายการข่าวประชาสัมพันธ์</h2>

    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <article>
          <h3><?= htmlspecialchars($row["title"]) ?></h3>
          <p><strong>วันที่:</strong> <?= date("d M Y", strtotime($row["date"])) ?></p>
          <p><strong>รายละเอียด:</strong> <?= nl2br(htmlspecialchars($row["description"])) ?></p>
          <?php if (!empty($row["image_path"])): ?>
            <img src="image_viewer.php?file=<?= urlencode($row["image_path"]) ?>" alt="รูปภาพประกอบ" />
          <?php endif; ?>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p>ไม่มีข่าวประชาสัมพันธ์ในขณะนี้</p>
    <?php endif; ?>
  </section>

  <footer>
    <p>© 2025 ระบบนำทางตึกมหาวิทยาลัย</p>
  </footer>
</body>
</html>

<?php $conn->close(); ?>
