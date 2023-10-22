<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="addmenu.css">
</head>
<body>
    <?php
        $pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM menu WHERE menu_id = ?");
        $stmt->bindParam(1, $_GET["menu_id"]); 
        $stmt->execute();  
        $row = $stmt->fetch();
        
        $s = $pdo->prepare("SELECT DISTINCT category FROM menu");
        $s->execute();
        $categories = $s->fetchAll();
    ?>

    <header>
        <div class="back">
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
            </p>
            
            <p>
                ราคา :
                <input type="text" name="price" value="<?=$row["price"]?>">
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

            <img src='../menu/food/<?=$row["menu_name"]?>.jpg' width='200' height='200'> 
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