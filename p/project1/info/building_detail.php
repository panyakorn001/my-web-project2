<?php
// เชื่อมต่อฐานข้อมูล
$conn = new mysqli("localhost", "root", "", "university_system");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// รับ ID ตึกจาก URL
$buildingId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM buildings WHERE id = $buildingId";
$result = $conn->query($sql);
$building = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>รายละเอียดตึก</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #333;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #00695c;
      color: white;
      padding: 1.5rem;
      text-align: center;
    }

    .container {
      max-width: 900px;
      margin: 2rem auto;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      padding: 2rem;
    }

    img {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 10px;
    }

    h2 {
      color: #004d40;
      margin-top: 1.5rem;
    }

    p {
      font-size: 1.1rem;
      line-height: 1.6;
    }

    .map {
      margin-top: 2rem;
      height: 400px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .back-btn {
      margin-top: 1.5rem;
      display: inline-block;
      padding: 10px 20px;
      background-color: #26a69a;
      color: white;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-size: 16px;
    }

    .back-btn:hover {
      background-color: #00796b;
    }
  </style>
</head>
<body>
  <header>
    <h1>รายละเอียดตึก</h1>
  </header>

  <div class="container">
    <?php if ($building): ?>
      <img src="<?= htmlspecialchars($building['image_url']) ?>" alt="<?= htmlspecialchars($building['building_name']) ?>">
      <h2><?= htmlspecialchars($building['building_name']) ?></h2>
      <p><?= nl2br(htmlspecialchars($building['building_description'])) ?></p>

      <!-- แผนที่ -->
      <div class="map" id="map"></div>

      <a class="back-btn" href="index.php">ย้อนกลับ</a>

      <script>
        function initMap() {
          var location = { lat: <?= $building['latitude'] ?>, lng: <?= $building['longitude'] ?> };
          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            center: location,
            mapTypeId: 'roadmap',
          });

          new google.maps.Marker({
            position: location,
            map: map,
            title: "<?= htmlspecialchars($building['building_name']) ?>"
          });
        }
      </script>
      <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
      </script>

    <?php else: ?>
      <p>ไม่พบข้อมูลตึก</p>
      <a class="back-btn" href="index.php">กลับหน้าแรก</a>
    <?php endif; ?>
  </div>
</body>
</html>
