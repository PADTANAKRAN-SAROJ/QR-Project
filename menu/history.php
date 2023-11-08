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
		<div class="icon">
            <a href="category.php"><img src="icon\back.png" width="30rem"></a>
        </div>
		<h1>ประวัติการสั่งซื้อ</h1>
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
				<p class="c6 c6_posit" align="right" >เลขโต๊ะของคุณ <?php echo $_SESSION["table_number"]; ?></p>
				
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

							echo "<td class='left'>" . $row["menu_name"] . "</td>";
							echo "<td>" . $row["price"] . "</td>";
							echo "<td class='left'>" . $row["detail"] . "</td>";
							echo "<td>" . $row["quantity"] . "</td>";

							if($row["process"]=="Done"){
								echo "<td id='pro' class='done'> เสร็จสิ้น </td>";
							}else if($row["process"]=="Cooking"){
								echo "<td id='pro' class='cooking'> กำลังปรุง </td>";
							}else if($row["process"]=="Served"){
								echo "<td id='pro' class='served'> รอรับอาหาร </td>";
							}else if($row["process"]=="Cancel"){
								echo "<td id='pro' class='cancel'> ยกเลิก </td>";
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