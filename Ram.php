<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="Frontend.css">
</head>
    <?php
        $motherboard = $_POST["submit"]; 

        $file=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","a");
        fwrite($file,$motherboard);
        fwrite($file,',');
        fclose($file);

        $file1=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","r");
        $content=fgets($file1);
        $carray=explode(",",$content);
        list($emailid,$processorid,$motherboardid)=$carray;
        
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "diypc";
        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

        $sql3="Select SUM(P_PRICE+M_PRICE) FROM processor,motherboard where PROCESSOR.P_ID=$processorid AND MOTHERBOARD.M_ID=$motherboardid;";
        $result3 = $conn->query($sql3);
        $row3=$result3 -> fetch_assoc();
        
       
        if (mysqli_connect_error())
        {
            die('Connect Error ('. mysqli_connect_errno() .') ' . mysqli_connect_error());
        }
        else
        {
            $sql = "SELECT R_ID,R_MODEL,R_BRAND,R_SPEED,R_SIZE,R_CHANNEL,R_TYPE,R_PRICE 
            From ram where R_ID in (select R_ID from motherboard_ram_compatibility where M_ID=?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $motherboard);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows>0) 
            {
                $stmt->bind_result($R_ID,$R_MODEL,$R_BRAND,$R_SPEED,$R_SIZE,$R_CHANNEL,$R_TYPE,$R_PRICE);
                  
    ?>
  
        
<body>

<h1 style='text-align:center;'> CHOOSE RAM 
<br>
COST: ₹ <?php echo $row3["SUM(P_PRICE+M_PRICE)"]?>
</h1>
    <?php 
    $p=1;
        while($stmt->fetch()) 
        { 
    ?>

<form action="GPU.php" name="RAM" method="POST"> 
            
<h3>  (  <?php echo $R_ID?>  )  MODEL:  <?php echo $R_MODEL  ?></h3>
<img src="rampics\r<?php echo $p?>.jpg" alt="Image Not Available">
<p> 
    <?php echo "<b>BRAND: </b>  ".$R_BRAND?>&emsp;
    <?php echo "<b>SPEED:</b>  ".$R_SPEED?>&emsp;
    <?php echo "<b>SIZE:</b> ".$R_SIZE?>&emsp;
    <?php echo "<b>CHANNEL:</b> ".$R_CHANNEL?>&emsp;
    <?php echo "<b>TYPE: </b>".$R_TYPE?>&emsp;
    <?php echo "<b>PRICE: </b>  ₹ ".$R_PRICE?> 
</p>
<button type="submit" name="submit" value='<?php echo $R_ID?>'>SELECT </button><br><br>

</form>
<?php 
        echo $p;
        $p++; } 
    } 
    else
    {
        echo "0 results";
    }
    $stmt->close();
    $conn->close();
}
        
?>

</body>
</html>