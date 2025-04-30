function initMap() {
    const buildingLocation = { lat: 14.123456, lng: 101.123456 }; // แก้ไขเป็นพิกัดของตึกจริง
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: buildingLocation
    });

    const marker = new google.maps.Marker({
        position: buildingLocation,
        map: map,
        title: 'อาคารวิศวกรรมศาสตร์'
    });
}

function navigateToBuilding() {
    window.location.href = 'navigate.html';
}
