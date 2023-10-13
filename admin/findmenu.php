<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    header {
        background-color: pink;
        padding: 10px;
        margin: -10px;
        margin-bottom: 15px;
        display: flex; /* เพื่อให้ <h1> และ <a> อยู่ในหนึ่งแถว */
        justify-content: space-between;
        align-items: center;
    }

    h1 {
        flex: 1;
        text-align: center;
    }

    table.t8{
        width: 80%;
    }
    table{
        margin: auto;
        text-align: center;
        margin-top: 50px;
        box-shadow: 0 10px 10px 10px rgba(0, 0, 0,0.05);
        border-collapse: collapse;
        border-radius: 1rem;
    }

    th, td {
        padding: 1rem;
    }

    td.fat{
        padding: 7rem 0rem;
        text-align: center;
    }

    tr, th{
        border-bottom: 1px solid #D9D9D9; 
    }

    tr:last-child{
        border: none
    }

    th:first-child{
        padding: 1rem 0rem;
    }

    td.left {
        text-align: left;
        padding-left: 2rem;
    }
    td.right {
        text-align: right;
        padding-right: 2rem;
    }
    td.center{
        text-align: center;
        
    }   
    .back {
        text-align: left;
    }

       /* สไตล์สำหรับ overlay */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1;
    }
        /* สไตล์สำหรับเนื้อหาป๊อปอัพ */
    .popup {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
    .popup h2 {
        text-align: center;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        text-decoration: none;
        color: #000;
    }

    .content {
        text-align: center;
    }

    #popup-image {
        width: 300px;
        height: 300px;
        border-radius: 10px;
    }
    </style>

    <script>
        function showPopup(imageUrl) {
            // Set the image source of the popup window
            document.getElementById("popup-image").src = imageUrl;

            // Show the popup window
            document.getElementById("popup").style.display = "block";
        }


        function hidePopup() {
            // Hide the popup window
            document.getElementById("popup").style.display = "none";
        }
    </script>
</head>
<body>

    <header>
        <div class="back">
            <a href="admin.php"><img src="..\menu\icon\back.png" width="30rem"></a>
        </div>
		<h1>เมนูอาหารที่ค้นหา</h1>
	</header>

    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_GET['menu_name'])){
        $menu_name = '%' . $_GET['menu_name'] . '%';
        $stmt = $pdo->prepare("SELECT * FROM menu WHERE menu_name LIKE :menu_name");
        $stmt->bindParam(':menu_name', $menu_name, PDO::PARAM_STR);
        $stmt->execute();
    ?>
        <table class="t8">
            <thead>
                <tr>
                <th>ชื่อรายการ</th>
                <th>รูปภาพ</th>
                <th>ประเภท</th>
                <th>ราคา</th>
                </tr>
            </thead>
            <tbody>
        <?php    
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . $row['menu_name'] . '</td>';
                echo '<td><button onclick="showPopup(\'http://localhost/qr/menu/food/' . $row['menu_name'] . '.jpg\')">ดูรูป</button></td>';
                echo '<td>' . $row['category'] . '</td>';
                echo '<td>' . $row['price'] . '</td>';
                echo '</tr>';
            }
        ?>    
            </tbody>
        </table>
    <?php } ?>
    
    <div id="popup" class="overlay">
        <div class="popup center">
            <h2>รูปภาพ</h2>
            <a class="close" href="#" onclick="hidePopup()">&times;</a>
            <div class="content">
                <img id="popup-image" src="">
            </div>
        </div>
    </div>


</body>
</html>