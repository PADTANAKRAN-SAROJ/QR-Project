<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>

    <link rel="stylesheet" href="findmenu.css">

    <script>
        function confirmDelete(menu_name) {
            var ans = confirm("ต้องการลบรายการอาหาร " + menu_name);
            if (ans) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>
<body>

    <?php
    $menu_name = $_GET["menu_name"];
    //echo $menu_name . "<br>";
    //ตรวจสอบสิทธิ์
    include "./checkRole.php";
    include "../connect.php";

    $sql = "SELECT * FROM menu WHERE menu_name LIKE :menu_name";
    $nameParam = '%' . $menu_name . '%';  // Add '%' to the bound parameter
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':menu_name', $nameParam, PDO::PARAM_STR);  // Use $nameParam
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
     
    <table class="t8">
        <thead>
            <tr>
                <th>ชื่อรายการ</th>
                <th>รูปภาพ</th>
                <th>ประเภท</th>
                <th>ราคา</th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
        <?php foreach ($result as $row): ?>
            
            <tr>
                <td>
                    <?php echo $row["menu_name"] ?>
                </td>
                <td>
                    <button onclick="showPopup('../menu/food/<?php echo $row['menu_id']; ?>.jpg')"><img src="icon/pic.png" width="20rem\"></button>
                </td>
                <td>
                    <?php echo $row["category"] ?>
                </td>
                <td>
                    <?php echo $row["price"] ?>
                </td>
                <td>
                    <a href='edit.php?menu_id=<?php echo $row["menu_id"] ?>'><button class='editButton'>แก้ไข</button></a>
                    <a href='delete.php?menu_id=<?php echo $row["menu_id"] ?>' onclick="return confirmDelete('<?php echo $row['menu_name'] ?>')"><button class='deleteButton'>ลบ</button></a></td>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>