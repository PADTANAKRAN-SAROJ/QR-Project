<html>
<head>
	<link rel="stylesheet" href="order.css">

	<script>
		// ใช้สำหรับปรับปรุงจำนวนสินค้า
		function update(menu_id) {
			var qty = document.getElementById(menu_id).value;
			// ส่งรหัสสินค้า และจำนวนไปปรับปรุงใน session
			document.location = "order.php?action=update&menu_id=" + menu_id + "&qty=" + qty; 
		}
	</script>

</head>

<body>

	<header>
		<a class="back" href="category.php">< กลับไปหน้าหลัก</a>
		<h1>รวมรายการที่สั่ง</h1>
	</header>

	<div class="topnav">
		<a class="now" href="#list">ตะกร้าอาหาร</a>
		<a href="history.php">ประวัติการสั่งซื้อ</a>
	</div>

	<div id="list">
		<h2>ตะกร้าสินค้า</h2>

		<?php
		session_start();

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

		//$menu_name = $_GET['menu_name'];
		?>

		<div class="cart-container">
			<form>
			<table class="item">
			<th>ชื่อเมนู</th><th>ราคา</th><th>จำนวน</th>
				<?php 
				$sum = 0;
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
					<td class="center">            
						<input type="number" id="<?=$item["menu_id"]?>" value="<?=$item["qty"]?>" min="1" max="9">
						<a href="#" onclick="update(<?=$item["menu_id"]?>)">แก้ไข</a>
						<a href="?action=delete&menu_id=<?=$item["menu_id"]?>">ลบ</a>
					</td>
				</tr>

				<?php } ?>
				<div>
					<tr><td colspan="3" align="center">ราคารวม <?=$sum?> บาท</td></tr>
				</div>
				
			</table>
			</form>
		</div>
	</div>

</body>
</html>