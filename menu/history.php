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

	<div id="wrapper">

		<nav id="nav">
			<ul>
				<li><a href="order.php?action=">ตะกร้าอาหาร</a></li>
				<li><a href="#main" class="active">ประวัติการสั่งซื้อ</a></li>
			</ul>
		</nav>


	<?php
		$stmt = $pdo->prepare("SELECT * FROM orders JOIN menu ON orders.menu_id = menu.menu_id WHERE cus_id = ?");
        $stmt->bindParam(1, $_SESSION["cus_id"]); 
        $stmt->execute();
	?>

	<div id="main">
			<h2>ประวัติการสั่งซื้อ</h2>
			<p class="c6" align="right" >เลขโต๊ะของคุณ <?php echo $_SESSION["table_number"]; ?></p>
			
			<table class="item">
				<thead>
				<tr>
					<th>ชื่อเมนู</th>
					<th>ราคา</th>
					<th>รายละเอียด</th>
					<th>จำนวน</th>
					<th>สถานะ</th>
				</tr>
				</thead>
                <tbody>
					<tr>
					<?php
					$sum = 0;

					while ($row= $stmt->fetch()) {
						echo "<tr>";

						echo "<td>" . $row["menu_name"] . "</td>";
						echo "<td>" . $row["price"] . "</td>";
						echo "<td>" . $row["detail"] . "</td>";
						echo "<td>" . $row["quantity"] . "</td>";

						if($row["process"]=="Done"){
							echo "<td> เสร็จสิ้น </td>";
						}else if($row["process"]=="Cooking"){
							echo "<td class='cooking'> กำลังปรุง </td>";
						}else if($row["process"]=="Served"){
							echo "<td class='served'> รอรับอาหาร </td>";
						}else if($row["process"]=="Cancel"){
							echo "<td class='cancel'> ยกเลิก </td>";
						}
						
						 
						echo "</tr>";

						$sum+= $row["price"] * $row["quantity"];
					}
					?>
					</tr>
					<tr>
						<td colspan="5" align="center">ราคารวม <?=$sum?> บาท</td>
					</tr>

				</tbody>
			</table>
	</div>
	</div>
</body>
</html>