<?php
header('Content-Type: application/json');
$pdo = new PDO('mysql:host=localhost;dbname=university_system;charset=utf8', 'root', '');
$sql = "SELECT * FROM closed_roads";
$stmt = $pdo->query($sql);
$roads = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($roads);
?>
