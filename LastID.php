<?php
$host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "diypc";
        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
        $sql = "SELECT last_insert_id() from PRODUCT_ORDERS;";
        $result = $conn->query($sql);
        if ($result===TRUE) {
            echo "PC ORDERED!!";
            echo $conn->insert_id;}
        else{
            echo "FAIL";
        }
        $conn->close();
?>