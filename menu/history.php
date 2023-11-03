<html>
<head>
	<link rel="stylesheet" href="css/order.css">
	<link rel="stylesheet" href="css/history.css">

	<?php
	include "../connect.php";
	include "./checkSession.php";
	?>
</head>

<body>
	<header>
		<div class="back">
            <a href="category.php"><img src="icon\back.png" width="30rem"></a>
        </div>
		<h1>รวมรายการที่สั่ง</h1>
	</header>

	<div class="topnav">
		<a href="order.php?action=">ตะกร้าอาหาร</a>
		<a class="now" href="#his">ประวัติการสั่งซื้อ</a>
	</div>

	<?php
		$stmt = $pdo->prepare("SELECT * FROM orders JOIN menu ON orders.menu_id = menu.menu_id WHERE cus_id = ?");
        $stmt->bindParam(1, $_SESSION["cus_id"]); 
        $stmt->execute();
	?>

	<div id="his">
		<div>
			<h2>ประวัติการสั่งซื้อ</h2>
			<p class="c6" align="right" >เลขโต๊ะของคุณ <?php echo $_SESSION["table_number"]; ?></p>
			
			<table class="item">
				<thead>
				<tr>
					<th>ชื่อเมนู</th>
					<th>ราคา</th>
					<th>รายละเอียด</th>
					<th>จำนวน</th>
				</tr>
				</thead>
                <tbody>
					<?php
					$sum = 0;

					while ($row= $stmt->fetch()) {
						echo "<tr>";

						echo "<td>" . $row["menu_name"] . "</td>";
						echo "<td>" . $row["price"] . "</td>";
						echo "<td>" . $row["detail"] . "</td>";
						echo "<td>" . $row["quantity"] . "</td>";
						 
						echo "</tr>";

						$sum+= $row["price"] * $row["quantity"];
					}
					?>
				<tr>
					<td colspan="5" align="center">ราคารวม <?=$sum?> บาท</td>
				</tr>

				</tbody>
			</table>
		</div>
	</div>
</body>
</html>