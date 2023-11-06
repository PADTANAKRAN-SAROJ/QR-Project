<html>
<head>
	<link rel="stylesheet" href="css/order.css">
	<?php
		include "../connect.php";
		include "./checkSession.php";
	?>

	<script>
		// ใช้สำหรับปรับปรุงจำนวนสินค้า
		function update(menu_id) {
			var qty = document.getElementById("quantity_" + menu_id).value;
			// ส่งรหัสสินค้า และจำนวนไปปรับปรุงใน session
			document.location = "order.php?action=update&menu_id=" + menu_id + "&qty=" + qty;
		}

		function comment(menu_id) {
			var text = document.getElementById(menu_id).value;
			// ส่งรหัสสินค้าและรายละเอียดไปยังหน้า "order.php" เพื่อเก็บใน session
			document.location = "order.php?action=comment&menu_id=" + menu_id + "&text=" + text;
		}

	</script>

</head>

<body>

	<header>
		<div class="back">
            <a href="category.php"><img src="icon\back.png" width="30rem"></a>
        </div>
		<h1>รวมรายการที่สั่ง</h1>
	</header>

	<div id="wrapper">
		<nav id="nav">
			<ul>
				<li><a href="#main" class="active">ตะกร้าอาหาร</a></li>
				<li><a href="history.php">ประวัติการสั่งซื้อ</a></li>
			</ul>
		</nav>

	<div id="main">
		<?php
		// เพิ่มสินค้า
		if ($_GET["action"]=="add") {

			$menu_id = $_GET['menu_id'];

			$cart_item = array(
				'menu_id' => $menu_id,
				'menu_name' => $_GET['menu_name'],
				'price' => $_GET['price'],
				'qty' => $_POST['qty'],
				'detail' => ""
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
		else if ($_GET["action"] == "comment") {
			$menu_id = $_GET["menu_id"];
			$text = $_GET["text"];
			$_SESSION['cart'][$menu_id]['detail'] = $text;
		}
			
		?>

		<div>
			<h2>ตะกร้าอาหาร</h2>
			<p class="c6" align="right" >เลขโต๊ะของคุณ <?php echo $_SESSION["table_number"]; ?></p>
			<form action="addorder.php" method="post" enctype="multipart/form-data">
			<table class="item">
				<tr>
					<th></th>
					<th align="left">ชื่อเมนู</th>
					<th>ราคา</th>
					<th>รายละเอียด</th>
					<th>จำนวน</th>
				</tr>
			
			<?php 
			$sum = 0;

			if(!empty($_SESSION["cart"])){
				foreach ($_SESSION["cart"] as $item) {
					if (is_numeric($item["price"])) {
						$sum += $item["price"] * $item["qty"];
					}
				?>
				<tr>
					<td>
					<img src='food/<?=$item["menu_id"]?>.jpg'>
					</td>
					<td align="left">
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
						<input class="a10" type="text" id="<?=$item["menu_id"]?>" onblur='comment(<?=$item["menu_id"]?>)' placeholder="รายละเอียด" value="<?=$item["detail"]?>"/>
					</td>
					<td class="center">            
						<select id="quantity_<?=$item["menu_id"]?>" onchange="update(<?=$item['menu_id']?>)">
							<?php
							for ($i = 1; $i <= 9; $i++) {
								$selected = ($i == $item["qty"]) ? 'selected' : '';
								echo "<option value='$i' $selected>$i</option>";
							}
							?>
						</select>
						<a href="?action=delete&menu_id=<?=$item["menu_id"]?>"><button type="button" class='deleteButton'>ลบ</button></a>
					</td>
				</tr>
				<?php
				}
			}
			?>
				<tr>
					<td colspan="5" align="center">ราคารวม <?=$sum?> บาท</td>
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
	</div>
</body>
</html>