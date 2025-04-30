function initNavigationMap() {
    // พิกัดของตึกมหาวิทยาลัย
    const buildingLocation = { lat: 14.123456, lng: 101.123456 }; // แก้ไขเป็นพิกัดจริง

    // สร้างแผนที่
    const map = new google.maps.Map(document.getElementById('navigationMap'), {
        zoom: 14,
        center: buildingLocation
    });

    // กำหนดตัวเลือกในการแสดงเส้นทาง
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        map: map
    });

    // หาตำแหน่งปัจจุบันของผู้ใช้งาน
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const currentLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // คำนวณเส้นทางจากตำแหน่งปัจจุบันไปยังตึกมหาวิทยาลัย
                const request = {
                    origin: currentLocation,
                    destination: buildingLocation,
                    travelMode: 'DRIVING' // เปลี่ยนเป็น 'WALKING' หรือ 'BICYCLING' ตามความต้องการ
                };

                directionsService.route(request, (result, status) => {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(result);
                    } else {
                        alert('ไม่สามารถคำนวณเส้นทางได้: ' + status);
                    }
                });
            },
            () => {
                alert('ไม่สามารถหาตำแหน่งปัจจุบันได้');
            }
        );
    } else {
        alert('เบราว์เซอร์ของคุณไม่รองรับการหาตำแหน่งปัจจุบัน');
    }
}
