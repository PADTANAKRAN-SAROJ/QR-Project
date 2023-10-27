<html>
<head>
	<link rel="stylesheet" href="css/history.css">

</head>
<?php
include "./checkSession.php";
?>
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

	<div id="his">

	</div>
</body>
</html>