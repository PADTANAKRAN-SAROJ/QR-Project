<!DOCTYPE html>
<html>
<head>
    <title>สรุปข้อมูล</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<form id="summaryForm">
    <label for="summary_option">เลือกประเภทการดูสรุป:</label>
    <select name="summary_option" id="summary_option">
        <option value="menu_summary">1. สรุปเมนูอาหาร</option>
        <option value="revenue_summary">2. สรุปรายได้</option>
    </select>

    <div id="foodCategorySelect">
        <label for="food_category">เลือกประเภทของอาหาร:</label>
        <select name="food_category" id="food_category">
            <option value="all">ทุกประเภท</option>
            <option value="main_dish">จานเดียว</option>
            <option value="rice">ข้าว</option>
            <option value="snack">ของกินเล่น</option>
            <option value="soup_noodle">ต้ม เส้น</option>
            <option value="dessert">ของหวาน</option>
            <option value="beverage">เครื่องดื่ม</option>
            <option value="others">อื่น ๆ</option>
        </select>
    </div>

    <div id="revenueOptions">
        <label for="revenue_option">เลือกประเภทรายได้:</label>
        <select name="revenue_option" id="revenue_option">
            <option value="daily">รายวัน</option>
            <option value="monthly">รายเดือน</option>
            <option value="yearly">รายปี</option>
        </select>

        <!-- เลือกวัน เดือน ปี หากเลือกรายได้รายวันหรือรายเดือน -->
        <div id="dateSelection">
            <label for="selected_date">เลือกวันที่:</label>
            <input type="date" name="selected_date" id="selected_date">
            <input type="month" name="selected_month" id="selected_month" style="display: none;">
            <input type="number" name="selected_year" id="selected_year" placeholder="ปี" min="1900" max="2099" step="1" value="2023" style="display: none;" >
        </div>
    </div>

    <!-- เพิ่มส่วนอื่น ๆ เกี่ยวกับการเลือกรายได้ รายวัน/รายเดือน/รายปี ที่คุณต้องการ -->

    <button type="submit">ดูสรุป</button>
</form>

<div id="summaryResult">
    <!-- ที่นี่จะแสดงผลลัพธ์ของการสรุป -->
</div>

<script>
    $(document).ready(function () {
        $("#summary_option").on("change", function () {
            var selectedOption = $(this).val();
            if (selectedOption === "menu_summary") {
                $("#foodCategorySelect").show();
            } else {
                $("#foodCategorySelect").hide();
            }
        });

        // เมื่อเลือก revenue_option ให้แสดงช่องกรอกที่เกี่ยวข้องและซ่อนอื่น ๆ
        $("#revenue_option").on("change", function () {
            var selectedOption = $(this).val();

            if (selectedOption === "daily") {
                $("#selected_date").show();
                $("#selected_month").hide();
                $("#selected_year").hide();
            } else if (selectedOption === "monthly") {
                $("#selected_date").hide();
                $("#selected_month").show();
                $("#selected_year").hide();
            } else if (selectedOption === "yearly") {
                $("#selected_date").hide();
                $("#selected_month").hide();
                $("#selected_year").show();
            } else {
                // ถ้าไม่เลือกอะไรเลยให้ซ่อนทั้งหมด
                $("#selected_date").hide();
                $("#selected_month").hide();
                $("#selected_year").hide();
            }
        });

        $("#summaryForm").on("submit", function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            
            $.ajax({
                type: "POST",
                url: "summary_ajax.php", // ต้องสร้างไฟล์ summary_ajax.php สำหรับการดึงข้อมูล
                data: formData,
                success: function (response) {
                    $("#summaryResult").html(response);
                }
            });
        });

    });
</script>
</body>
</html>
