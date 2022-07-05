<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="Frontend.css">
</head>
<body>
<h1  style='text-align:center;'>CUSTOMER ORDERS 
</h1>
<!-- <form action="Login.html">
    <button type="submit" name="submit" value="DIYPC" style="position: centre; font-size: 150%"><b>LOG OUT!!</b></button>
    </form> -->
  
<?php
$EMAIL = $_POST['email'];
$PASSWORD1 = $_POST["password"];
if(isset($_POST['oid1'])){
    $oid1 = $_POST['oid1'];
}
else{
    
}


$adminlog="ADMIN@gmail.com";
$adminpass="ADMIN";
if ($EMAIL=="ADMIN@gmail.com" && $PASSWORD1=="ADMIN"){
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "diypc";
    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    ?>
    <form action="Login.html">
    <button type="submit" name="submit" value="DIYPC" style="position: centre; font-size: 150%"><b>LOG OUT!!</b></button>
    </form>
    <?php
    if (mysqli_connect_error())
    {
        die('Connect Error ('. mysqli_connect_errno() .') ' . mysqli_connect_error());
    }
    else
    {
        $sql = "SELECT * FROM PRODUCT_ORDERS;";
        $result = $conn->query($sql);
        $sql1="SELECT P_MODEL FROM PROCESSOR,PRODUCT_ORDERS WHERE PROCESSOR.P_ID=PRODUCT_ORDERS.P_ID";
        $result1= $conn->query($sql1);
        $row1=$result1 -> fetch_assoc();

        $sql2="SELECT M_MODEL FROM MOTHERBOARD,PRODUCT_ORDERS WHERE MOTHERBOARD.M_ID=PRODUCT_ORDERS.M_ID";
        $result2= $conn->query($sql2);
        $row2=$result2 -> fetch_assoc();

        $sql3="SELECT R_MODEL FROM RAM,PRODUCT_ORDERS WHERE RAM.R_ID=PRODUCT_ORDERS.R_ID";
        $result3= $conn->query($sql3);
        $row3=$result3 -> fetch_assoc();

        $sql4="SELECT G_MODEL FROM GPU,PRODUCT_ORDERS WHERE GPU.G_ID=PRODUCT_ORDERS.G_ID";
        $result4= $conn->query($sql4);
        $row4=$result4 -> fetch_assoc();

        $sql5="SELECT S_MODEL FROM STORAGE_COMPONENT,PRODUCT_ORDERS WHERE STORAGE_COMPONENT.S_ID=PRODUCT_ORDERS.S_ID";
        $result5= $conn->query($sql5);
        $row5=$result5 -> fetch_assoc();

        if($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
             ?>
                <form name="Admin view" method="POST"> 
            
    <br><b> ORDER NUMBER:</b> (<?php echo $row["ORDER_NO"]?>)   <br><br><b> EMAIL:</b>  <?php echo $row["C_EMAIL"]  ?>

<p> 
    <?php echo "<b>PROCESSOR MODEL:  </b>".$row1["P_MODEL"]?>&emsp;<br><br>
    <?php echo "<b>MOTHERBOARD MODEL:  </b>".$row2["M_MODEL"]?>&emsp;<br><br>
    <?php echo "<b>RAM MODEL:  </b>".$row3["R_MODEL"]?>&emsp;<br><br>
    <?php echo "<b>GPU MODEL:  </b>".$row4["G_MODEL"]?>&emsp;<br><br>
    <?php echo "<b>STORAGE MODEL:  </b>".$row5["S_MODEL"]?>&emsp;<br><br>
    <?php 
    echo "<b>ORDER STATUS:  </b>";
    if($row["ORDER_STATUS"]==0){
        echo "ORDER NOT CONFIRMED";
    }
    else{
        echo "ORDER CONFIRMED";
    }
        ?><br>

    <?php
    if($row["ORDER_STATUS"]==0){ 
            $oid=$row["ORDER_NO"];
            if(isset($_POST['orderstatus'])) {
        
                $sql6="UPDATE `product_orders` SET `ORDER_STATUS` = 1 WHERE `product_orders`.`ORDER_NO` = $oid1;";
                $conn->query($sql6);
                
            }        
        }
    else{
        $oid=$row["ORDER_NO"];
        if(isset($_POST['orderstatus2'])) {
    
            $sql7="UPDATE `product_orders` SET `ORDER_STATUS` = 0 WHERE `product_orders`.`ORDER_NO` = $oid1;";
            $conn->query($sql7);
            
        }

    }
    
        ?>
</p>

<br><br>

<form action="adminlogincheck.php" method="POST" >
    <input type="hidden" name="email" value="ADMIN@gmail.com"/>
    <input type="hidden" name="password" value="ADMIN"/>
    <input type="hidden" name="oid1" value="<?php echo $oid  ?>" />
    <input type="submit" name="orderstatus" class="button" value="CONFIRM ORDER"/>
    <input type="submit" name="orderstatus2" class="button" value="CANCEL ORDER"/>
    </form>
<?php
        }    
      $result->close();
      $conn->close();

    }   
}
}
else
        {
            $FILE3=fopen("InvalidLogin.html","r");
            echo fread($FILE3,filesize("InvalidLogin.html"));
            fclose($FILE3);
        }
?>
</div>
</body>
</html>
