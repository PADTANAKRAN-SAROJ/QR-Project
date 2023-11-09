<?php
include "../checkRole.php";
include "../../connect.php";

    $stmt = $pdo->prepare("SELECT entry_timestamp, review, rate FROM customer");
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

    <table class="t8">
        <thead>
            <tr>
                <th>time</th>
                <th>Review</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($review as $row) {
                if ($row['review'] !== null && $row['rate'] !== null) {
                    echo "<tr>";
                    echo "<td>{$row['entry_timestamp']}</td>";
                    echo "<td class='left'>{$row['review']}</td>";
                    echo "<td>{$row['rate']}</td>";
                    echo "</tr>";
                }
            }            
            ?>
        </tbody>
    </table>

</body>
</html>