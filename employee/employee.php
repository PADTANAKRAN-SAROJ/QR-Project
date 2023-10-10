<?php include "../connect.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>employee</title>
    <script src="./js/employee.js"></script>
    <script src="./js/Switch_menu.js"></script>
    <script src="./js/order_page.js"></script>
</head>
<body>
    <div class="employeePage">
        <div class="topBar">
            <button onclick="showOrder()">Order</button>
            <button onclick="showQRCode()">QR Code</button>
        </div>
        
        <!-- หน้า Order -->
        <div id="orderPage">
            <table>
                <tr>
                    <th>เมนู</th>
                    <th>จำนวน</th>
                    <th>โต๊ะ</th>
                    <th>ส่งงาน</th>
                </tr>

                <?php
                $stmt = $pdo->prepare("SELECT *
                    FROM orders o
                    INNER JOIN menu m ON o.menu_id = m.menu_id
                    INNER JOIN customer c ON o.cus_id = c.cus_id
                    WHERE o.process LIKE '%Serve%';
                ");

                $stmt->execute();
                $rows = $stmt->fetchAll();

                foreach ($rows as $row) {
                ?>

                <tr>
                    <form action="served.php" method="post">
                        <input type="hidden" value="<?=$row ['order_id']?>" name="order_id" >
                        <td><?=$row ["menu_name"]?> (<?=$row ["category"]?>)</td>
                        <td><?=$row ["quantity"]?></td>
                        <td><?=$row ["table_number"]?></td>
                        <td><input type="submit" value="เสร็จสิน"></td>
                    </form>
                </tr>

                <?php } ?>

            </table>
        </div>

        <!-- หน้า QR Code -->
        <div id="qrCodePage" style="display: none;">
            <div class="tableCount">
                <p>จำนวนโต๊ะ: <span id="tableCount">10</span></p>
                <button id="editTableButton" onclick="editTable()">แก้ไข</button>
                <button id="saveTableButton" style="display: none;" onclick="saveTable()">บันทึก</button>
            </div>
            <div class="editQR">
                <button onclick="createQR()">สร้าง QR</button>
                <button onclick="deleteQR()">ลบ QR</button>
                <button onclick="viewQR()">ดู QR</button>
            </div>
            <h3>รายการโต๊ะ:</h3>
            <div class="tableList">
                <!-- สร้างรายการโต๊ะตามจำนวนที่ระบุ -->
                <ul id="tableListContainer"></ul>
            </div>
        </div>

    </div>
</body>
</html>