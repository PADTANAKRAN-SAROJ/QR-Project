//สลับหน้าต่างเมนู
//แสดง qrcode
function showQRCode() {
    document.getElementById("qrCodePage").style.display = "block";
    document.getElementById("orderPage").style.display = "none";
}
//แสดงออเดอร์
function showOrder() {
    document.getElementById("qrCodePage").style.display = "none";
    document.getElementById("orderPage").style.display = "block";
}