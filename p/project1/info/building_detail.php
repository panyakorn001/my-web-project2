<?php
$host = 'localhost';
$db = 'university_system';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

$building_id = intval($_GET['id']);
$sql = $conn->prepare("SELECT * FROM buildings WHERE building_id = ?");
$sql->bind_param("i", $building_id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 0) {
    echo "ไม่พบข้อมูลตึกที่ต้องการ";
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($row['building_name']) ?></title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }

    .container {
      max-width: 800px;
      margin: 2rem auto;
      background-color: white;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    img {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 1rem;
    }

    h1 {
      color: #00695c;
      margin-bottom: 1rem;
    }

    p {
      font-size: 1.1rem;
      line-height: 1.6;
    }

    button {
      margin-top: 1.5rem;
      padding: 10px 25px;
      font-size: 16px;
      background-color: #26a69a;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #00796b;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="image_viewer.php?file=<?= urlencode($row['image_url']) ?>" alt="<?= htmlspecialchars($row['building_name']) ?>">
    <h1><?= htmlspecialchars($row['building_name']) ?></h1>
    <p><?= nl2br(htmlspecialchars($row['building_description'])) ?></p>
    <button onclick="window.history.back()">ย้อนกลับ</button>
  </div>
</body>
</html>

<?php $conn->close(); ?>
