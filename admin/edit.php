<?php
    include "./checkRole.php";
    include "../connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT</title>

    <link rel="stylesheet" href="addmenu.css">

</head>
<body>
    <?php
        $stmt = $pdo->prepare("SELECT * FROM menu WHERE menu_id = ?");
        $stmt->bindParam(1, $_GET["menu_id"]); 
        $stmt->execute();  
        $row = $stmt->fetch();
        
        $s = $pdo->prepare("SELECT DISTINCT category FROM menu");
        $s->execute();
        $categories = $s->fetchAll();
    ?>

    <header>
        <div class="icon">
            <a href="admin.php"><img src="../menu/icon/back.png" width="30rem"></a>
        </div>
        <h1>แก้ไขข้อมูลรายการ</h1>
    </header>

    <div class="center">
        <h2>- กรุณากรอกรายละเอียด -</h2>
        <form action="update.php" method="post" enctype="multipart/form-data">

            <p>
                ชื่ออาหาร :
                <input type="text" name="menu_name" value="<?=$row["menu_name"]?>">
                <span>* โปรดกรอกชื่อเมนูเป็น ภาษาไทย เท่านั้น *</span>
            </p>
            
            <p>
                ราคา :
                <input type="text" name="price" value="<?=$row["price"]?>">
                <span>* โปรดกรอกชื่อเมนูเป็น ตัวเลข เท่านั้น *</span>
            </p>

            <p>
                ประเภทอาหาร:
                <select class="select-add" name="category" id="category">
                    <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                    <?php foreach($categories as $category) { ?>
                        <option value="<?=$category['category'];?>"><?=$category['category'];?></option>
                    <?php } ?>
                </select>
            </p>

            <img src='../menu/food/<?=$row["menu_id"]?>.jpg' width='200' height='200'> 
            <p>
                แก้ไขรูปภาพ:  
                <input type="file" name="profile">    
            </p>
            
            <input type="hidden" name="menu_id" value="<?=$row["menu_id"]?>">

            <input class="confirmButton" type="submit" value="แก้ไขข้อมูล">
        </form>
    </div>

</body>
</html>

<script>
        document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.querySelector('input[name="menu_name"]');
        const priceInput = document.querySelector('input[name="price"]');
        const namePattern = /^[\u0E01-\u0E5B\s]+$/; // Regular expression ชื่อเมนูภาษาไทย
        const pricePattern = /^\d+(\.\d+)?$/; // Regular expression เป็นตัวเลข & ทศนิยม

        nameInput.addEventListener('blur', function() {
            if (!namePattern.test(nameInput.value)) {
                alert("โปรดกรอกชื่อเมนูเป็นภาษาไทย (ก-ฮ และสระ) เท่านั้น");
                nameInput.value = ''; // ล้างข้อมูลที่กรอก
            }
        });

        priceInput.addEventListener('blur', function() {
            if (!pricePattern.test(priceInput.value)) {
                alert("โปรดกรอกราคาเป็นตัวเลขเท่านั้น");
                priceInput.value = ''; // ล้างข้อมูลที่กรอก
            }
        });
    });

</script>