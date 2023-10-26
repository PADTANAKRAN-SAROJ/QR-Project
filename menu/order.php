<html>
<head>
	<link rel="stylesheet" href="css/order.css">

	<script>
		// ใช้สำหรับปรับปรุงจำนวนสินค้า
		function update(menu_id) {
			var qty = document.getElementById(menu_id).value;
			// ส่งรหัสสินค้า และจำนวนไปปรับปรุงใน session
			document.location = "order.php?action=update&menu_id=" + menu_id + "&qty=" + qty; 
		}
	</script>

</head>

<?php
    session_start(); // เริ่มเซสชันตอนแรก

    include "../connect.php";

    // ตรวจสอบว่าเซสชันมีค่า Cus ID, Table Number, และ Entry Time หรือไม่
    if (isset($_SESSION['cus_id']) && isset($_SESSION['table_number']) && isset($_SESSION['entry_timestamp'])) {
        // มี session อยู่
        $cusId = $_SESSION['cus_id'];
        $tableNumber = $_SESSION['table_number'];
        $entry_timestamp = $_SESSION['entry_timestamp'];

        // ตรวจสอบค่าในฐานข้อมูล (เช่นแต่ไม่แสดงผลลัพธ์ที่เหลือเพื่อรักษาความกระชับ)
        $sql = "SELECT * FROM customer WHERE cus_id = :cus_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cus_id', $cusId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $databaseTableNumber = $row['table_number'];
                $databaseEntryTime = $row['entry_timestamp'];

                if ($row['state'] == 'Done') {
                    echo "ขอบคุณที่อุดหนุน!";
                } else {
                    // เปรียบเทียบเฉพาะวันและเวลา (ไม่เจาะจงไปถึงวินาที)
                    if ($tableNumber == $databaseTableNumber && date('Y-m-d H:i', strtotime($entry_timestamp)) == date('Y-m-d H:i', strtotime($databaseEntryTime))) {
                        // ตรงข้อมูลและมี session ให้ทำตามที่คุณต้องการ
                        // ตรวจสอบ session ตรงตามความต้องการ
                        echo "Session ตรงตามที่คุณต้องการ";
                    } else {
                        echo "ข้อมูลไม่ตรงกัน";
                    }
                }
            } else {
                echo "ไม่พบข้อมูลในฐานข้อมูล";
            }
        } else {
            echo "เกิดข้อผิดพลาดในการคิวรีข้อมูล";
        }
    } else {
        echo "ไม่มีเซสชันที่ต้องการ";
    }
?>


<body>

	<header>
		<div class="back">
            <a href="category.php"><img src="icon\back.png" width="30rem"></a>
        </div>
		<h1>รวมรายการที่สั่ง</h1>
	</header>

	<div class="topnav">
		<a class="now" href="#list">ตะกร้าอาหาร</a>
		<a href="history.php">ประวัติการสั่งซื้อ</a>
	</div>

	<div id="list">

		<?php
 
		// เพิ่มสินค้า
		if ($_GET["action"]=="add") {

			$menu_id = $_GET['menu_id'];

			$cart_item = array(
				'menu_id' => $menu_id,
				'menu_name' => $_GET['menu_name'],
				'price' => $_GET['price'],
				'qty' => $_POST['qty']
			);

			// ถ้ายังไม่มีสินค้าใดๆในรถเข็น
			if(empty($_SESSION['cart']))
				$_SESSION['cart'] = array();

			// ถ้ามีสินค้านั้นอยู่แล้วให้บวกเพิ่ม
			if(array_key_exists($menu_id, $_SESSION['cart']))
				$_SESSION['cart'][$menu_id]['qty'] += $_POST['qty'];

			// หากยังไม่เคยเลือกสินค้นนั้นจะ
			else
				$_SESSION['cart'][$menu_id] = $cart_item;

		// ปรับปรุงจำนวนสินค้า
		} else if ($_GET["action"]=="update") {
			$menu_id = $_GET["menu_id"];     
			$qty = $_GET["qty"];
			$_SESSION['cart'][$menu_id]['qty'] = $qty;

		// ลบสินค้า
		} else if ($_GET["action"]=="delete") {
			
			$menu_id = $_GET['menu_id'];
			unset($_SESSION['cart'][$menu_id]);
		}

		?>

		<div class="cart-container">
			<h2>ตะกร้าอาหาร</h2>
			<form action="addorder.php" method="post" enctype="multipart/form-data">
			<table class="item">
				<tr>
					<th>ชื่อเมนู</th>
					<th>ราคา</th>
					<th>รายละเอียด</th>
					<th>จำนวน</th>
				</tr>
			
			<?php 
			$sum = 0;

			if(!empty($_SESSION["cart"])){
				foreach ($_SESSION["cart"] as $item) {
					$sum += $item["price"] * $item["qty"];
				?>
				<tr>
					<td>
						<?php
						if (isset($item["menu_name"])) {
							echo $item["menu_name"]; 
						} else {
							echo "ไม่พบชื่อสินค้า";
						}
						?>
					</td>
					<td class="center"><?=$item["price"]?></td>
					<td>
						<input class="a10" type="text" placeholder="รายละเอียด" name="detail" value=""/>
					</td>
					<td class="center">            
						<input type="number" id="<?=$item["menu_id"]?>" value="<?=$item["qty"]?>" min="1" max="9">
						<a href="#" onclick="update(<?=$item["menu_id"]?>)">แก้ไข</a>
						<a href="?action=delete&menu_id=<?=$item["menu_id"]?>">ลบ</a>
					</td>
				</tr>
				<?php
				}
			}
			?>
				<tr>
					<td colspan="4" align="center">ราคารวม <?=$sum?> บาท</td>
				</tr>
				
			</table>

			<div class="c6" align="right" >
				<a href="addorder.php">
				<input class="orderConfirmButton" type="submit" name="Submit" value="ยืนยันคำสั่งซื้อ" /></input>
				</a>
			</div>

			</form>
		</div>
	</div>
</body>
</html>