<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

include('../db_connection.php');

// รับพารามิเตอร์
$type = $_GET['type'];
$id = intval($_GET['id']);

switch ($type) {
    case 'buildings':
        $table_name = 'buildings';
        $redirect_url = 'manage_template.php?type=buildings';
        break;
    case 'rooms':
        $table_name = 'rooms';
        $redirect_url = 'manage_template.php?type=rooms';
        break;
    case 'news':
        $table_name = 'news';
        $redirect_url = 'manage_template.php?type=news';
        break;
    default:
        header('Location: manage_data.php');
        exit;
}

// ดึงข้อมูลที่ต้องการแก้ไข
$query = "SELECT * FROM $table_name WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $columns = array_keys($data);
    $updates = [];
    foreach ($columns as $column) {
        if ($column !== 'id') {
            $value = mysqli_real_escape_string($conn, $_POST[$column]);
            $updates[] = "$column = '$value'";
        }
    }
    $update_query = "UPDATE $table_name SET " . implode(', ', $updates) . " WHERE id = $id";
    mysqli_query($conn, $update_query);
    header("Location: $redirect_url");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูล</title>
</head>
<body>
    <h1>แก้ไขข้อมูล</h1>
    <form method="post">
        <?php foreach ($data as $column => $value) : ?>
            <?php if ($column !== 'id') : ?>
                <label><?php echo htmlspecialchars($column); ?>:</label>
                <input type="text" name="<?php echo htmlspecialchars($column); ?>" value="<?php echo htmlspecialchars($value); ?>" required><br>
            <?php endif; ?>
        <?php endforeach; ?>
        <button type="submit">บันทึก</button>
    </form>
</body>
</html>
