<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="Frontend.css">
</head>
<body>
<?php
$storage=$_POST["submit"];
$file=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","a");
fwrite($file,$storage);
fclose($file);
$host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "diypc"; 
        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
        
        $sql3="Select SUM(P_PRICE+M_PRICE+R_PRICE+S_PRICE+G_PRICE) FROM processor,motherboard,ram,storage_component,gpu,product_orders where PROCESSOR.P_ID=PRODUCT_ORDERS.P_ID AND MOTHERBOARD.M_ID=PRODUCT_ORDERS.M_ID AND RAM.R_ID=PRODUCT_ORDERS.R_ID AND GPU.G_ID=PRODUCT_ORDERS.G_ID AND STORAGE_COMPONENT.S_ID=PRODUCT_ORDERS.S_ID;";
        $result3 = $conn->query($sql3);
        $row3=$result3 -> fetch_assoc();
        $sql = "load data infile 'OrderData.txt' into table PRODUCT_ORDERS fields terminated by ',' lines terminated by '\n'";
        $result = $conn->query($sql); 
        $sql1="Select SUM(P_PRICE+M_PRICE+R_PRICE+S_PRICE+G_PRICE) FROM processor,motherboard,ram,storage_component,gpu,product_orders where PROCESSOR.P_ID=PRODUCT_ORDERS.P_ID AND MOTHERBOARD.M_ID=PRODUCT_ORDERS.M_ID AND RAM.R_ID=PRODUCT_ORDERS.R_ID AND GPU.G_ID=PRODUCT_ORDERS.G_ID AND STORAGE_COMPONENT.S_ID=PRODUCT_ORDERS.S_ID;";
        $result1 = $conn->query($sql1);
        $row2=$result1 -> fetch_assoc();
        $totalamount= $row2["SUM(P_PRICE+M_PRICE+R_PRICE+S_PRICE+G_PRICE)"]-$row3["SUM(P_PRICE+M_PRICE+R_PRICE+S_PRICE+G_PRICE)"];
        
        $sql4="UPDATE `product_orders` SET `TOTAL_AMOUNT` = "."'$totalamount'"." WHERE `product_orders`.`TOTAL_AMOUNT` = 0";
        $conn->query($sql4);
        ?>
    

        <form action='Login.html'>
        <?php
        if ($result===TRUE) {
            ?>
             <h2> PC ORDERED !! </h2>
             
             <h2> TOTAL COST OF PC: ₹<?php echo  $totalamount ?>
             <br>
            <button type='submit' name='submit' value='Exit'>  EXIT  </button>
        <?php }
        else {
            ?>
            <h2> OOPS !!<br> Order Failed <br> Login and Try Again </h2>
            <button type='submit' name='submit' value='Exit'>  TRY AGAIN  </button>
        <?php }
        $conn->close();

?>
</form>
</body>
</html>