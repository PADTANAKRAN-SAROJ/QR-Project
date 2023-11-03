<?php
// ตรวจสอบว่ามีการส่งข้อมูลเข้ามาและเป็น POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับข้อมูลจากแบบฟอร์ม
    $summary_option = $_POST["summary_option"];
    $food_category = $_POST["food_category"];
    $revenue_option = $_POST["revenue_option"];
    $selected_date = $_POST["selected_date"];
    $selected_month = $_POST["selected_month"];
    $selected_year = $_POST["selected_year"];

    include "../../connect.php";

    if($summary_option == "menu_summary"){
        // echo "menu_summary : ";
        if($food_category == "all"){
            if($revenue_option == 'daily'){
                if($selected_date!=''){
                    $sql = "SELECT m.category, m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            GROUP BY m.category, m.menu_name
                            ORDER BY m.category";
    
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
    
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->execute();
    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;

                    if (count($result) > 0) {
                        


                        echo "รายการอาหารใน วันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
    
                        echo '<table border="1">
                            <tr>
                                <th>หมวดหมู่</th>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
    
                        foreach ($result as $row) {
                            $current_category = $row["category"];
                            $total_daily_revenue += $row["total_revenue"];
    
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["menu_name"] . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
    
                        echo '</table> <br>';
    
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date: $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับรายการ $food_category ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }

            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";

                    $sql = "SELECT m.category, m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            GROUP BY m.category, m.menu_name
                            ORDER BY m.category";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->execute();

                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
                    if (count($result) > 0) {
                        echo "รายการอาหารใน เดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
    
                        echo '<table border="1">
                            <tr>
                                <th>หมวดหมู่</th>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
    
                        foreach ($result as $row) {
                            $current_category = $row["category"];
                            $total_daily_revenue += $row["total_revenue"];
    
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["menu_name"] . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
    
                        echo '</table> <br>';
    
                        echo "รายได้รวมทั้งหมดในเดือนที่$month ปี พ.ศ $year เป็นเงิน $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับรายการ $food_category ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
            
                    $sql = "SELECT m.category, m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            GROUP BY m.category, m.menu_name
                            ORDER BY m.category";
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $year = $selected_year + 543;

                    if (count($result) > 0) {
                        
            
                        echo "รายการอาหารในปี พ.ศ. $year : <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>หมวดหมู่</th>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["category"];
                            $total_yearly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["menu_name"] . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year เป็นเงิน $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับรายการ $food_category ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }

        }else if ($food_category == "main_dish") {
            $food_category_thai = "จานเดียว";
            if ($revenue_option == 'daily') {
                if ($selected_date != '') {
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
        
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
        
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
        
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;
        
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
        
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
        
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_daily_revenue += $row["total_revenue"];
        
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
        
                        echo '</table> <br>';
        
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date สำหรับประเภท $food_category_thai : $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                } else {
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
            
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND m.category = :food_category_thai
                        GROUP BY m.menu_name
                        ORDER BY m.menu_name";
            
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
            
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_monthly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_monthly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในเดือนที่ $month ปี พ.ศ $year สำหรับประเภท $food_category_thai : $total_monthly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
                
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
                
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $year = $selected_year + 543;
                
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในปี พ.ศ. $year <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
                
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
                
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_yearly_revenue += $row["total_revenue"];
                
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
                
                        echo '</table> <br>';
                
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year สำหรับประเภท $food_category_thai: $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }

        }else if($food_category == "rice"){
            $food_category_thai = "ข้าว";
            if ($revenue_option == 'daily') {
                if ($selected_date != '') {
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
        
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
        
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
        
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;
        
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
        
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
        
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_daily_revenue += $row["total_revenue"];
        
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
        
                        echo '</table> <br>';
        
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date สำหรับประเภท $food_category_thai : $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                } else {
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
            
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND m.category = :food_category_thai
                        GROUP BY m.menu_name
                        ORDER BY m.menu_name";
            
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
            
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_monthly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_monthly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในเดือนที่ $month ปี พ.ศ $year สำหรับประเภท $food_category_thai : $total_monthly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
                
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
                
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $year = $selected_year + 543;
                
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในปี พ.ศ. $year <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
                
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
                
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_yearly_revenue += $row["total_revenue"];
                
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
                
                        echo '</table> <br>';
                
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year สำหรับประเภท $food_category_thai: $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }

        }else if($food_category == "snack"){
            $food_category_thai = "ของกินเล่น";
            if ($revenue_option == 'daily') {
                if ($selected_date != '') {
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
        
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
        
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
        
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;
        
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
        
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
        
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_daily_revenue += $row["total_revenue"];
        
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
        
                        echo '</table> <br>';
        
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date สำหรับประเภท $food_category_thai : $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                } else {
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
            
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND m.category = :food_category_thai
                        GROUP BY m.menu_name
                        ORDER BY m.menu_name";
            
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
            
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_monthly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_monthly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในเดือนที่ $month ปี พ.ศ $year สำหรับประเภท $food_category_thai : $total_monthly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
                
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
                
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $year = $selected_year + 543;
                
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในปี พ.ศ. $year <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
                
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
                
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_yearly_revenue += $row["total_revenue"];
                
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
                
                        echo '</table> <br>';
                
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year สำหรับประเภท $food_category_thai: $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }

        }else if($food_category == "soup_noodle"){
            $food_category_thai = "ต้ม";
            if ($revenue_option == 'daily') {
                if ($selected_date != '') {
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
        
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
        
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
        
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;
        
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
        
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
        
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_daily_revenue += $row["total_revenue"];
        
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
        
                        echo '</table> <br>';
        
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date สำหรับประเภท $food_category_thai : $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                } else {
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
            
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND m.category = :food_category_thai
                        GROUP BY m.menu_name
                        ORDER BY m.menu_name";
            
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
            
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_monthly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_monthly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในเดือนที่ $month ปี พ.ศ $year สำหรับประเภท $food_category_thai : $total_monthly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
                
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
                
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $year = $selected_year + 543;
                
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในปี พ.ศ. $year <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
                
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
                
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_yearly_revenue += $row["total_revenue"];
                
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
                
                        echo '</table> <br>';
                
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year สำหรับประเภท $food_category_thai: $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }

        }else if($food_category == "dessert"){
            $food_category_thai = "ของหวาน";
            if ($revenue_option == 'daily') {
                if ($selected_date != '') {
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
        
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
        
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
        
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;
        
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
        
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
        
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_daily_revenue += $row["total_revenue"];
        
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
        
                        echo '</table> <br>';
        
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date สำหรับประเภท $food_category_thai : $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                } else {
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
            
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND m.category = :food_category_thai
                        GROUP BY m.menu_name
                        ORDER BY m.menu_name";
            
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
            
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_monthly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_monthly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในเดือนที่ $month ปี พ.ศ $year สำหรับประเภท $food_category_thai : $total_monthly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
                
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
                
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $year = $selected_year + 543;
                
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในปี พ.ศ. $year <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
                
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
                
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_yearly_revenue += $row["total_revenue"];
                
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
                
                        echo '</table> <br>';
                
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year สำหรับประเภท $food_category_thai: $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }


        }else if($food_category == "beverage"){
            $food_category_thai = "เครื่องดื่ม";
            if ($revenue_option == 'daily') {
                if ($selected_date != '') {
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
        
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
        
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
        
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;
        
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
        
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
        
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_daily_revenue += $row["total_revenue"];
        
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
        
                        echo '</table> <br>';
        
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date สำหรับประเภท $food_category_thai : $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                } else {
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
            
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND m.category = :food_category_thai
                        GROUP BY m.menu_name
                        ORDER BY m.menu_name";
            
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
            
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_monthly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_monthly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในเดือนที่ $month ปี พ.ศ $year สำหรับประเภท $food_category_thai : $total_monthly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
                
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
                
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $year = $selected_year + 543;
                
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในปี พ.ศ. $year <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
                
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
                
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_yearly_revenue += $row["total_revenue"];
                
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
                
                        echo '</table> <br>';
                
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year สำหรับประเภท $food_category_thai: $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }


        }else if($food_category == "others"){
            $food_category_thai = "อื่นๆ";
            if ($revenue_option == 'daily') {
                if ($selected_date != '') {
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
        
                    $start_time = $selected_date . " 00:00:00";
                    $end_time = $selected_date . " 23:59:59";
        
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
        
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                    $day = date('d', strtotime($selected_date));
                    $month = date('m', strtotime($selected_date));
                    $year = date('Y', strtotime($selected_date)) + 543;
        
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_daily_revenue = 0;
        
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
        
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_daily_revenue += $row["total_revenue"];
        
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
        
                        echo '</table> <br>';
        
                        echo "รายได้รวมทั้งหมดในวันที่ $selected_date สำหรับประเภท $food_category_thai : $total_daily_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในวันที่ $day เดือน $month ปี พ.ศ $year";
                    }
                } else {
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'monthly'){
                if($selected_month!=''){
                    $selected_month = date('Y-m', strtotime($selected_month));
                    $start_time = $selected_month . "-01 00:00:00";
                    $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
            
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND m.category = :food_category_thai
                        GROUP BY m.menu_name
                        ORDER BY m.menu_name";
            
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
            
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                    $month = date('m', strtotime($selected_month));
                    $year = date('Y', strtotime($selected_month)) + 543;
            
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year <br>";
                        
                        $current_category = null;
                        $total_monthly_revenue = 0;
            
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
            
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_monthly_revenue += $row["total_revenue"];
            
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
            
                        echo '</table> <br>';
            
                        echo "รายได้รวมทั้งหมดในเดือนที่ $month ปี พ.ศ $year สำหรับประเภท $food_category_thai : $total_monthly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในเดือนที่ $month ปี พ.ศ $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }else if($revenue_option == 'yearly'){
                if($selected_year!=''){
                    $start_time = $selected_year . "-01-01 00:00:00";
                    $end_time = $selected_year . "-12-31 23:59:59";
                
                    $sql = "SELECT m.menu_name, SUM(o.quantity) AS total_quantity, SUM(o.quantity * m.price) AS total_revenue
                            FROM orders o
                            INNER JOIN menu m ON o.menu_id = m.menu_id
                            WHERE o.order_timestamp >= :start_time
                            AND o.order_timestamp <= :end_time
                            AND m.category = :food_category_thai
                            GROUP BY m.menu_name
                            ORDER BY m.menu_name";
                
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":start_time", $start_time);
                    $stmt->bindParam(":end_time", $end_time);
                    $stmt->bindParam(":food_category_thai", $food_category_thai);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $year = $selected_year + 543;
                
                    if (count($result) > 0) {
                        echo "รายการอาหารในประเภท $food_category_thai ในปี พ.ศ. $year <br>";
                        
                        $current_category = null;
                        $total_yearly_revenue = 0;
                
                        echo '<table border="1">
                            <tr>
                                <th>รายการอาหาร</th>
                                <th>จำนวน</th>
                                <th>รายได้</th>
                            </tr>';
                
                        foreach ($result as $row) {
                            $current_category = $row["menu_name"];
                            $total_yearly_revenue += $row["total_revenue"];
                
                            echo '<tr>
                                <td>' . $current_category . '</td>
                                <td>' . $row["total_quantity"] . '</td>
                                <td>' . $row["total_revenue"] . '</td>
                            </tr>';
                        }
                
                        echo '</table> <br>';
                
                        echo "รายได้รวมทั้งหมดในปี พ.ศ. $year สำหรับประเภท $food_category_thai: $total_yearly_revenue";
                    } else {
                        echo "ไม่พบข้อมูลสำหรับประเภท $food_category_thai ในปี พ.ศ. $year";
                    }
                }else{
                    echo "กรุณากรอกข้อมูลให้ครบถ้วน";
                }
            }

        }

    }else if($summary_option == "revenue_summary") {
        echo "revenue_summary : ";
        if($revenue_option == 'daily'){
            if($selected_date!=''){
                echo "daily :" . $selected_date ;
            }else{
                echo "กรุณากรอกข้อมูลให้ครบถ้วน";
            }
        }else if($revenue_option == 'monthly'){
            if($selected_month!=''){
                echo "monthly" . $selected_month;
            }else{
                echo "กรุณากรอกข้อมูลให้ครบถ้วน";
            }
        }else if($revenue_option == 'yearly'){
            if($selected_year!=''){
                echo "yearly" . $selected_year;
            }else{
                echo "กรุณากรอกข้อมูลให้ครบถ้วน";
            }
        }

    }else{
        echo "ไม่พบข้อมูล";
    }

} else {
    // หากไม่ใช่ POST request ให้ส่งข้อความแจ้งเตือน
    echo "ไม่พบข้อมูลที่ส่งเข้ามาหรือเป็นประเภทผิด";
}
?>