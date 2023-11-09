<?php
include "../checkRole.php";
include "../../connect.php";

    $stmt = $pdo->prepare("SELECT review, rate FROM customer");
    $stmt->execute();

    $review = [];
    while ($row = $stmt->fetch()) {
        $review[] = $row;
    }

    file_put_contents('review.json', json_encode($review));
?>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/topbar.css">
    <link rel="stylesheet" type="text/css" href="../css/review.css">

</head>

<body>
    <div class="topbar">
        <a href="../index.php"><img src="../../menu/icon/back.png" width="30rem"></a>
        <h1 class="center-title">สรุปข้อมูล</h1>
    </div>
    <div class="navbar">
        <ul>
            <li><a href="index.php">จัดการร้านอาหาร</a></li>
            <li><a href="review.php" class="active">รีวิวลูกค้า</a></li>
        </ul>
    </div>

    <table>
        <thead>
            <tr>
                <th>Review</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($reviews as $review) {
                echo "<tr>";
                echo "<td>{$review['review']}</td>";
                echo "<td>{$review['rate']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>