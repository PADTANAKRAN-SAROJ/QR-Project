<!DOCTYPE html>
<html>
<head>
    <title>สรุปข้อมูล</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/topbar.css">
    <link rel="stylesheet" type="text/css" href="../css/summary.css">
    <link rel="stylesheet" type="text/css" href="../css/menu_summary.css">
    <link rel="stylesheet" type="text/css" href="../css/menu_summary.css">
</head>
<body>
    <div class="topbar">
                <a href="../index.php" class="back-link">ย้อนกลับ</a>
                <h1 class="center-title">สรุปข้อมูล</h1>
    </div>

    <form id="summaryForm">
        <!-- ... ส่วนอื่น ๆ ... -->
        <input type="hidden" name="summary_option" id="selected_summary_option" value="">
        <input type="hidden" name="food_category" id="selected_food_category" value="">
        <input type="hidden" name="revenue_option" id="selected_revenue_option" value="">
        <input type="hidden" name="selected_date" id="selected_date_value" value="">
        <input type="hidden" name="selected_month" id="selected_month_value" value="">
        <input type="hidden" name="selected_year" id="selected_year_value" value="">


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
                <option value="soup_noodle">ต้ม</option>
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
                <input type="number" name="selected_year" id="selected_year" placeholder="ปี" min="2000" max="2099" step="1" value="2023" style="display: none;">
            </div>
        </div>

        <input type="submit"></input>
    </form>

    <div id="summaryResult">
        
    </div>

    <script>
    $(document).ready(function () {
        // เมื่อเลือก summary_option
        $("#summary_option").on("change", function () {
            var selectedOption = $(this).val();
            $("#selected_summary_option").val(selectedOption); // อัปเดตค่า summary_option

            if (selectedOption === "menu_summary") {
                $("#foodCategorySelect").show();
                // $("#revenueOptions").hide(); // ซ่อน select ของ revenue_option
            } else if (selectedOption === "revenue_summary") {
                $("#revenueOptions").show();
                $("#foodCategorySelect").hide(); // ซ่อน select ของ food_category
            }
        });

        // เมื่อเลือก revenue_option ให้แสดงช่องกรอกที่เกี่ยวข้องและซ่อนอื่น ๆ
        $("#revenue_option").on("change", function () {
            var selectedOption = $(this).val();
            $("#selected_revenue_option").val(selectedOption); // อัปเดตค่า revenue_option

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

        // เมื่อกดปุ่ม "ดูสรุป" ให้สร้าง FormData และส่งข้อมูล
        $("#summaryForm").on("submit", function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            // สามารถเพิ่มข้อมูลเพิ่มเติมที่ไม่ได้เป็นฟิลด์ในฟอร์ม โดยใช้ formData.append()

            $.ajax({
                type: "POST",
                url: "summary_ajax.php", // ต้องสร้างไฟล์ summary_ajax.php สำหรับการดึงข้อมูล
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#summaryResult").html(response);
                }
            });
        });
    });
    </script>
</body>
</html>
