<?php
    include '../connect.php';
    if (isset($_GET['cus_id'])) {
        $cus_id = $_GET['cus_id'];

        $sql = "SELECT rate FROM customer WHERE cus_id = :cus_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cus_id',$cus_id);

        if ($stmt->execute()){
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rate = $row['rate'];
                if($rate == NULL){
                }else{
                    header("Location: ../thankYou.php");
                }
            }
        }
    }else{
        header("Location: ../contactStaff.php");
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reviwe</title>
    <link rel="stylesheet" type="text/css" href="./css/review.css">
</head>

<body>
    <form class="review_box" action="./add_review.php" method="post" onsubmit="return validateForm()">
        <h1>รีวิว</h1>
        <p>โปรดให้คะแนน</p>
        <input type="hidden" name='cus_id' value="<?=$cus_id?>" >
        <input type="hidden" name="rate" id="ratingInput" required>
        <div class="rate_box">
            <a href="#" onclick="changeColor(1)"><img src="./img/star.png" alt="star" id="star1"></a>
            <a href="#" onclick="changeColor(2)"><img src="./img/star.png" alt="star" id="star2"></a>
            <a href="#" onclick="changeColor(3)"><img src="./img/star.png" alt="star" id="star3"></a>
            <a href="#" onclick="changeColor(4)"><img src="./img/star.png" alt="star" id="star4"></a>
            <a href="#" onclick="changeColor(5)"><img src="./img/star.png" alt="star" id="star5"></a>
        </div>
        
        <br>
        <p>โปรดให้กรอกคำติชม</p>
        <textarea name="comment" id="" cols="30" rows="10"></textarea>
        <br>
        <input type="submit">
    </form>
</body>
</html>
<script>
function validateForm() {

    var rateValue = document.getElementById('ratingInput').value;
    if (!rateValue) {
        alert('โปรดให้คะแนนก่อนที่จะส่งรีวิว');
        return false; 
    }
    return true;
}
function changeColor(rating) {
    document.getElementById('ratingInput').value = rating;

    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById('star' + i);
        star.style.filter = i <= rating ? 'grayscale(0%)' : 'grayscale(100%)';

    }
}
</script>