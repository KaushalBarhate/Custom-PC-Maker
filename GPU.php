<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Frontend.css">
</head>
    <?php
        $ram=$_POST["submit"];
        $file=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","a");
        fwrite($file,$ram);
        fwrite($file,',');
        fclose($file);

        $file1=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","r");
        $content=fgets($file1);
        $carray=explode(",",$content);
        list($emailid,$processorid,$motherboardid,$ramid)=$carray;

        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "diypc";
        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

        $sql3="Select SUM(P_PRICE+M_PRICE+R_PRICE) FROM processor,motherboard,ram where PROCESSOR.P_ID=$processorid AND MOTHERBOARD.M_ID=$motherboardid AND RAM.R_ID=$ramid;";
        $result3 = $conn->query($sql3);
        $row3=$result3 -> fetch_assoc();
       
        if (mysqli_connect_error())
        {
            die('Connect Error ('. mysqli_connect_errno() .') ' . mysqli_connect_error());
        }
        else
        {
            $sql = "SELECT G_ID,G_BRAND,G_MODEL,G_MEMORY,G_TDP,G_PRICE From GPU";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {        
    ?>
  
        
<body>
<h1 style='text-align:center;'>CHOOSE GPU 
<br>
COST: ₹ <?php echo $row3["SUM(P_PRICE+M_PRICE+R_PRICE)"]?>
</h1>
    <?php 
    $p=1;
        while($row = $result->fetch_assoc()) 
        {
            
    ?>

<form action="storage_component.php" name="Processor" method="POST"> 
<?php if($row['G_MODEL']==NULL)
            {
?>
   <button type="submit" name="submit" value='<?php echo $row["G_ID"]?>'>SKIP </button>

<?php }
else {
    ?>
<h3>  (  <?php echo $row["G_ID"]?>  )  MODEL:  <?php echo $row["G_MODEL"]  ?></h3>
<img src="gpupics\g<?php echo $p?>.jpg" alt="Image Not Available">
<p> 
    <?php echo "<b>BRAND:  </b>".$row["G_BRAND"]?>&emsp;
    <?php echo "<b>MEMORY:  </b>".$row["G_MEMORY"]?>&emsp;
    <?php echo "<b>TDP:  </b>".$row["G_TDP"]?>&emsp;
    <?php echo "<b>PRICE: </b> ₹ ".$row["G_PRICE"]?> 
</p>
<button type="submit" name="submit" value='<?php echo $row["G_ID"]?>'>SELECT </button>

</form>
<?php       }
        $p++; } 
    } 
    else
    {
        echo "0 results";
    }
  $result->close();
  $conn->close();
}
?>

</body>
</html>

