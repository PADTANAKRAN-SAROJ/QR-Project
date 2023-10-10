

// ฟังก์ชันสร้างรายการโต๊ะ
function createTableList(tableCount) {
    const tableListContainer = document.getElementById('tableListContainer');
    tableListContainer.innerHTML = ''; // เคลียร์รายการโต๊ะที่มีอยู่

    for (let i = 1; i <= tableCount; i++) {
        const tableItem = document.createElement('li');
        tableItem.innerText = `โต๊ะ ${i}`;
        tableListContainer.appendChild(tableItem);
    }
}

// ฟังก์ชันแก้ไขจำนวนโต๊ะ
function editTable() {
    const tableCountElement = document.getElementById('tableCount');
    const editTableButton = document.getElementById('editTableButton');
    const saveTableButton = document.getElementById('saveTableButton');

    // แสดง input field และปุ่มบันทึก
    tableCountElement.innerHTML = `<input type="number" id="tableCountInput" value="${tableCountElement.innerText}">`;
    editTableButton.style.display = 'none';
    saveTableButton.style.display = 'inline';
}

// ฟังก์ชันสำหรับเช็คว่ามีค่าจำนวนโต๊ะที่เก็บไว้ใน localStorage หรือไม่
function hasTableCountInStorage() {
    return localStorage.getItem('tableCount') !== null;
}

// ฟังก์ชันเพื่อรับค่าจำนวนโต๊ะจาก localStorage
function getTableCountFromStorage() {
    return parseInt(localStorage.getItem('tableCount'), 10);
}

// ฟังก์ชันเพื่อเซฟค่าจำนวนโต๊ะลงใน localStorage
function saveTableCountToStorage(tableCount) {
    localStorage.setItem('tableCount', tableCount);
}

// เริ่มต้นโดยสร้างรายการโต๊ะแสดงเมื่อหน้าโหลด
window.onload = function () {
    const tableCountElement = document.getElementById('tableCount');
    if (hasTableCountInStorage()) {
        const storedTableCount = getTableCountFromStorage();
        tableCountElement.innerText = storedTableCount;
        createTableList(storedTableCount);
    } else {
        // ถ้าไม่มีค่าจำนวนโต๊ะใน localStorage ให้ใช้ค่าเริ่มต้น
        createTableList(10);
        saveTableCountToStorage(10);
    }
}

// ฟังก์ชันแก้ไขจำนวนโต๊ะ
function editTable() {
    const tableCountElement = document.getElementById('tableCount');
    const editTableButton = document.getElementById('editTableButton');
    const saveTableButton = document.getElementById('saveTableButton');

    // แสดง input field และปุ่มบันทึก
    tableCountElement.innerHTML = `<input type="number" id="tableCountInput" value="${tableCountElement.innerText}">`;
    editTableButton.style.display = 'none';
    saveTableButton.style.display = 'inline';
}

// ฟังก์ชันบันทึกจำนวนโต๊ะ
function saveTable() {
    const tableCountInput = document.getElementById('tableCountInput');
    const tableCountElement = document.getElementById('tableCount');
    const editTableButton = document.getElementById('editTableButton');
    const saveTableButton = document.getElementById('saveTableButton');

    // บันทึกค่าใหม่และแสดงค่า
    tableCountElement.innerText = tableCountInput.value;

    // ซ่อน input field และแสดงปุ่มแก้ไข
    tableCountInput.remove();
    editTableButton.style.display = 'inline';
    saveTableButton.style.display = 'none';

    // บันทึกค่าจำนวนโต๊ะใหม่ลงใน localStorage
    saveTableCountToStorage(tableCountInput.value);
    // รีเซตหน้าจอโดยไม่ใช้แคช
    location.reload(true);
}



//----------------------------------------------------------- แก้ไข qr 
function createQR() {
    // ทำสิ่งที่คุณต้องการเมื่อคลิกปุ่ม "สร้าง QR"
    alert('สร้าง QR สำเร็จ');
}
function deleteQR() {
    // ทำสิ่งที่คุณต้องการเมื่อคลิกปุ่ม "ลบ QR"
    alert('ลบ QR สำเร็จ');
}
function viewQR() {
    // ทำสิ่งที่คุณต้องการเมื่อคลิกปุ่ม "ดู QR"
    alert('ดู QR');
}

