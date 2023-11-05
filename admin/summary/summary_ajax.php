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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                        AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                        AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                        AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                        AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                        AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                        AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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
                        AND o.process = 'Done' 
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
                            AND o.process = 'Done' 
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

    }else if ($summary_option == "revenue_summary") {
        if ($revenue_option == 'daily') {
            if ($selected_date != '') {
                $start_time = $selected_date . " 00:00:00";
                $end_time = $selected_date . " 23:59:59";
                
                $sql = "SELECT m.category, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND o.process = 'Done' 
                        GROUP BY m.category";
    
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":start_time", $start_time);
                $stmt->bindParam(":end_time", $end_time);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // รวมรายได้ของแต่ละหมวดหมู่
                $categoryRevenue = array();
                foreach ($result as $row) {
                    $categoryRevenue[] = array(
                        'category' => $row["category"],
                        'revenue' => $row["total_revenue"]
                    );
                }

                $totalDailyRevenue = array_sum(array_column($categoryRevenue, 'revenue'));
                echo " <h3> รายได้รวม : $totalDailyRevenue บาท </h3>";
                // ส่งข้อมูลรายได้ไปยัง JavaScript ในรูปแบบ JSON
                echo '<script>';
                echo 'var categoryData = ' . json_encode($categoryRevenue) . ';';
                echo '</script>';
                echo "
                    <canvas id='revenueChart' width='400' height='100%' ></canvas>
                    
                    <script>
                    var ctx = document.getElementById('revenueChart').getContext('2d');

                    // ตรวจสอบค่าของ categoryData ใน Console
                    console.log(categoryData);

                    // สร้างอาร์เรย์ของสีสำหรับแต่ละประเภท
                    var categoryColors = {
                        'จานเดียว': 'rgba(75, 192, 192)',
                        'เส้น': 'rgba(255, 99, 132)',
                        'กับข้าว': 'rgba(20, 255, 86)',
                        'ของกินเล่น': 'rgba(255, 206, 86)',
                        'ต้ม': 'rgba(54, 162, 235)',
                        'ของหวาน': 'rgba(153, 102, 255)',
                        'เครื่องดื่ม': 'rgba(255, 159, 64)',
                        'อื่นๆ': 'rgba(200, 200, 200)'
                    };

                    // ตรวจสอบค่าของ categoryData ใน Console
                    console.log(categoryData);

                    // สร้างกราฟแท่งด้วย Chart.js
                    if (categoryData) {
                        var categoryLabels = categoryData.map(item => item.category);
                        var categoryRevenues = categoryData.map(item => item.revenue);

                        // สร้างอาร์เรย์สีสำหรับแต่ละหมวดหมู่
                        var categoryBackgroundColors = categoryLabels.map(label => categoryColors[label]);

                        var data = {
                            labels: categoryLabels,
                            datasets: [{
                                label: 'รายได้',
                                data: categoryRevenues,
                                backgroundColor: categoryBackgroundColors, // ใช้สีตามหมวดหมู่
                                borderWidth: 1
                            }]
                        };

                        var options = {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        };

                        var revenueChart = new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            options: options
                        });
                    }
                </script>
                ";
            } else {
                echo "กรุณากรอกข้อมูลให้ครบถ้วน";
            }
        }else if ($revenue_option == 'monthly') {
            if ($selected_month != '') {
                $selected_month = date('Y-m', strtotime($selected_month));
                $start_time = $selected_month . "-01 00:00:00";
                $end_time = date('Y-m-t', strtotime($selected_month)) . " 23:59:59";
        
                $sql = "SELECT DATE(o.order_timestamp) AS order_date, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND o.process = 'Done' 
                        GROUP BY order_date";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":start_time", $start_time);
                $stmt->bindParam(":end_time", $end_time);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                if (count($result) > 0) {
                    $total_monthly_revenue = 0;
                    foreach ($result as $row) {
                        $total_monthly_revenue += $row["total_revenue"];
                    }
        
                    echo '</table> <br>';
                    echo "รายได้รวมในเดือน $selected_month: $total_monthly_revenue";
        
                    // ส่งข้อมูลรายได้ไปยัง JavaScript ในรูปแบบ JSON เพื่อใช้ในการสร้างกราฟ
                    echo '<script>';
                    echo 'var monthlyData = ' . json_encode($result) . ';';
                    echo '</script>';
        
                    // สร้างกราฟแท่งด้วย Chart.js
                    echo "
                        <canvas id='monthlyChart' width='400px' height='100%'></canvas>
                        
                        <script>
                        var ctx = document.getElementById('monthlyChart').getContext('2d');
        
                        // สร้างอาร์เรย์ของวันที่และรายได้
                        var orderDates = monthlyData.map(item => {
                            var date = new Date(item.order_date);
                            var dayOfWeek = date.toLocaleDateString('th-TH', { weekday: 'long' });
                            return dayOfWeek + ' ' + date.getDate();
                        });
                        var orderRevenues = monthlyData.map(item => item.total_revenue);                        
                        
                        // สร้างอาร์เรย์ของสีตามวันของสัปดาห์
                        // สร้างอาร์เรย์ของสีตามวันของสัปดาห์และชื่อวันภาษาไทย
                        var dayColors = {
                            'วันอาทิตย์': 'red', 
                            'วันจันทร์': 'yellow', 
                            'วันอังคาร': 'pink', 
                            'วันพุธ': 'green', 
                            'วันพฤหัสบดี': 'orange', 
                            'วันศุกร์': 'blue', 
                            'วันเสาร์': 'purple'
                        };
                        
        
                        // กำหนดสีตามวันของสัปดาห์
                        var backgroundColors = orderDates.map(day => dayColors[day.split(' ')[0]]);
        
                        var data = {
                            labels: orderDates,
                            datasets: [{
                                label: 'รายได้',
                                data: orderRevenues,
                                backgroundColor: backgroundColors,
                                borderWidth: 1
                            }]
                        };
        
                        var options = {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        };
        
                        var monthlyChart = new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            options: options
                        });
                        </script>
                    ";
                } else {
                    echo "ไม่พบข้อมูลสำหรับรายการในเดือน $selected_month";
                }
            } else {
                echo "กรุณากรอกข้อมูลให้ครบถ้วน";
            }    
        }else if ($revenue_option == 'yearly') {
            if ($selected_year != '') {
                $start_time = $selected_year . "-01-01 00:00:00";
                $end_time = $selected_year . "-12-31 23:59:59";
        
                $sql = "SELECT DATE_FORMAT(o.order_timestamp, '%Y-%m') AS order_month, SUM(o.quantity * m.price) AS total_revenue
                        FROM orders o
                        INNER JOIN menu m ON o.menu_id = m.menu_id
                        WHERE o.order_timestamp >= :start_time
                        AND o.order_timestamp <= :end_time
                        AND o.process = 'Done' 
                        GROUP BY order_month";
        
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":start_time", $start_time);
                $stmt->bindParam(":end_time", $end_time);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                if (count($result) > 0) {   
                    $total_yearly_revenue = 0;
                    foreach ($result as $row) {
                        $total_yearly_revenue += $row["total_revenue"];

                    }
        
                    echo '</table> <br>';
                    echo "รายได้รวมทั้งหมดในปี $selected_year: $total_yearly_revenue";
        
                    // ส่งข้อมูลรายได้ไปยัง JavaScript ในรูปแบบ JSON เพื่อใช้ในการสร้างกราฟ
                    echo '<script>';
                    echo 'var yearlyData = ' . json_encode($result) . ';';
                    echo '</script>';
        
                    // สร้างกราฟแท่งด้วย Chart.js
                    echo "
                        <canvas id='yearlyChart' width='400' height='200'></canvas>
                        
                        <script>
                        var ctx = document.getElementById('yearlyChart').getContext('2d');

                        // สร้างอาร์เรย์ของเดือนและรายได้
                        var orderMonths = yearlyData.map(item => {
                            var parts = item.order_month.split('-');
                            return parseInt(parts[1]); // ใช้ parseInt เพื่อแปลงให้เป็นตัวเลข
                        });
                        var orderRevenues = yearlyData.map(item => item.total_revenue);

                        // สร้างอาร์เรย์ของสีตามเดือน
                        var monthColors = [
                            'rgba(255, 99, 132)',
                            'rgba(75, 192, 192)',
                            'rgba(54, 162, 235)',
                            'rgba(153, 102, 255)',
                            'rgba(255, 159, 64)',
                            'rgba(20, 255, 86)',
                            'rgba(255, 206, 86)',
                            'rgba(255, 99, 132)',
                            'rgba(75, 192, 192)',
                            'rgba(54, 162, 235)',
                            'rgba(153, 102, 255)',
                            'rgba(255, 159, 64)'
                        ];
        
                        // สร้างอาร์เรย์ของชื่อเดือนและรายได้
                        var monthNames = [
                            'มกราคม',
                            'กุมภาพันธ์',
                            'มีนาคม',
                            'เมษายน',
                            'พฤษภาคม',
                            'มิถุนายน',
                            'กรกฎาคม',
                            'สิงหาคม',
                            'กันยายน',
                            'ตุลาคม',
                            'พฤศจิกายน',
                            'ธันวาคม'
                        ];

                        var orderMonths = yearlyData.map(item => {
                            var parts = item.order_month.split('-');
                            var monthIndex = parseInt(parts[1]) - 1; // ลบ 1 เนื่องจากเดือนใน JavaScript เริ่มที่ 0
                            return monthNames[monthIndex];
                        });
                        var orderRevenues = yearlyData.map(item => item.total_revenue);

        
                        var data = {
                            labels: orderMonths,
                            datasets: [{
                                label: 'รายได้',
                                data: orderRevenues,
                                backgroundColor: backgroundColors,
                                borderWidth: 1
                            }]
                        };
        
                        var options = {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        };
        
                        var yearlyChart = new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            options: options
                        });
                        </script>
                    ";
                } else {
                    echo "ไม่พบข้อมูลสำหรับรายการในปี $selected_year";
                }
            } else {
                echo "กรุณากรอกข้อมูลให้ครบถ้วน";
            }
        }
    }else {
    // หากไม่ใช่ POST request ให้ส่งข้อความแจ้งเตือน
    echo "ไม่พบข้อมูลที่ส่งเข้ามาหรือเป็นประเภทผิด";
}
}
?>
<head>
    <!-- เรียกใช้ไลบรารี Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>