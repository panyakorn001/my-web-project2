<?php
// รับชื่อไฟล์จาก parameter
$filename = $_GET['file'] ?? '';

// ป้องกัน path traversal
$filename = basename($filename);

// สร้าง path เต็มไปยังโฟลเดอร์ภาพจริง
$imagePath = realpath(__DIR__ . "/../../ADmin/LOGIN/add/uploads/" . $filename);

// ตรวจสอบว่าไฟล์มีอยู่จริงและอยู่ในโฟลเดอร์เป้าหมาย
$uploadsDir = realpath(__DIR__ . "/../../ADmin/LOGIN/add/uploads/");
if ($imagePath && strpos($imagePath, $uploadsDir) === 0 && file_exists($imagePath)) {
    $mime = mime_content_type($imagePath);
    header("Content-Type: $mime");
    readfile($imagePath);
    exit;
} else {
    http_response_code(404);
    echo "ไม่พบรูปภาพ";
}
?>
