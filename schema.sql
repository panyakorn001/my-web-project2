-- ตารางสำหรับผู้ดูแลระบบ (admins)
CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- เพิ่มผู้ใช้งานในตาราง admins
INSERT INTO admins (username, password) VALUES 
('admin', '1234'), 
('user1', 'abcd');

-- ตารางสำหรับตึก (buildings)
CREATE TABLE buildings (
    id SERIAL PRIMARY KEY,
    building_name VARCHAR(255) NOT NULL,
    building_description TEXT NOT NULL,
    latitude DOUBLE PRECISION NOT NULL,
    longitude DOUBLE PRECISION NOT NULL,
    image_url VARCHAR(255)
);

-- ตารางสำหรับห้อง (rooms)
CREATE TABLE rooms (
    id SERIAL PRIMARY KEY,
    building_id INTEGER NOT NULL,
    room_name VARCHAR(255) NOT NULL,
    room_description TEXT NOT NULL,
    floor INTEGER NOT NULL,
    latitude DOUBLE PRECISION NOT NULL,
    longitude DOUBLE PRECISION NOT NULL,
    image_url VARCHAR(255),
    CONSTRAINT fk_building FOREIGN KEY (building_id) REFERENCES buildings(id)
);

-- ตารางสำหรับประกาศข่าวสาร
CREATE TABLE announcements (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    image_path VARCHAR(255) NOT NULL
);

-- ตารางสำหรับถนนที่ปิด
CREATE TABLE closed_roads (
    id SERIAL PRIMARY KEY,
    from_lat DOUBLE PRECISION,
    from_lng DOUBLE PRECISION,
    to_lat DOUBLE PRECISION,
    to_lng DOUBLE PRECISION,
    reason VARCHAR(255)
);

-- เพิ่มข้อมูลถนนที่ปิด
INSERT INTO closed_roads (from_lat, from_lng, to_lat, to_lng, reason) 
VALUES (14.9851860, 102.1208025, 14.986307, 102.120505, 'ถนนปิดซ่อมแซม');
