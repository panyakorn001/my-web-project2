<?php
if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] == 0) {
    $target_directory = "uploads/";
    $target_file = $target_directory . basename($_FILES["image_file"]["name"]);
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png'];

    if (!in_array($image_file_type, $allowed_types)) {
        echo "ไฟล์ที่อัปโหลดไม่ถูกต้อง! โปรดอัปโหลดไฟล์ประเภท .jpg, .jpeg, หรือ .png เท่านั้น.";
        exit;
    }

    if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์! โค้ดผิดพลาด: " . $_FILES["image_file"]["error"];
        $target_file = '';
    }
} else {
    $target_file = '';
    echo "ไม่พบไฟล์ที่อัปโหลด หรือเกิดข้อผิดพลาดในการอัปโหลด";
}

// เชื่อมต่อ PostgreSQL จาก DATABASE_URL
$dbUrl = getenv("DATABASE_URL");
$dbparts = parse_url($dbUrl);

$host = $dbparts['host'];
$port = $dbparts['port'];
$user = $dbparts['user'];
$pass = $dbparts['pass'];
$dbname = ltrim($dbparts['path'], '/');

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $image_path = $target_file;

    $sql = "INSERT INTO announcements (title, description, date, image_path)
            VALUES (:title, :description, :date, :image_path)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':image_path', $image_path);

    if ($stmt->execute()) {
        echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location.href = 'news_form.php';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }

} catch (PDOException $e) {
    echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
}
?>
