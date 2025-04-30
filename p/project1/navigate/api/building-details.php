<?php
header('Content-Type: application/json');
$code = $_GET['code'] ?? '';

$buildings = [
    'B' => [
        'name' => 'ตึก 35',
        'rooms' => [
            ['room' => '35101', 'description' => 'ห้องเรียนวิชาคอมพิวเตอร์เบื้องต้น'],
            ['room' => '35102', 'description' => 'ห้องปฏิบัติการเทคโนโลยีสารสนเทศ']
        ]
    ],
    'C' => [
        'name' => 'ตึก 34',
        'rooms' => [
            ['room' => '34101', 'description' => 'ห้องเรียนวิชาคณิตศาสตร์'],
            ['room' => '34102', 'description' => 'ห้องเรียนภาษาอังกฤษ']
        ]
    ],
    'D' => [
        'name' => 'ออกแบบอุตสาหกรรม',
        'rooms' => [
            ['room' => 'D101', 'description' => 'ห้องวาดเส้นพื้นฐาน'],
            ['room' => 'D102', 'description' => 'ห้องออกแบบผลิตภัณฑ์']
        ]
    ]
];

echo json_encode($buildings[$code] ?? ['name' => 'ไม่พบข้อมูล', 'rooms' => []]);
