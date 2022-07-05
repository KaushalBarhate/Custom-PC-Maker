<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="Frontend.css">
</head>
<body>
<h1  style='text-align:center;'>CHOOSE PROCESSOR 
<br> COST: ₹ 0
</h1>

<div class='processors'>
    <?php 
    $p=1;
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "diypc";
    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
    if (mysqli_connect_error())
        {
            die('Connect Error ('. mysqli_connect_errno() .') ' . mysqli_connect_error());
        }
        else
        {
    $sql2 = "SELECT P_BRAND,P_ID,P_MODEL,P_CORE,P_TDP,P_PRICE From PROCESSOR";
    $result2 = $conn->query($sql2);
    if($result2->num_rows > 0) 
    {
        while($row2 = $result2->fetch_assoc()) 
        {
    ?>
 <br><br>
<form action="Motherboard.php" name="Processor" method="POST"> 
            
<h3>  (  <?php echo $row2["P_ID"]?>  )  MODEL:  <?php echo $row2["P_MODEL"]  ?></h3>
<img src="processorpics\p<?php echo $p?>.jpg" alt="Image Not Available">
<p> 
    <?php echo "<b>BRAND:  </b>".$row2["P_BRAND"]?>&emsp;
    <?php echo "<b>CORE:  </b>".$row2["P_CORE"]?>&emsp;
    <?php echo "<b>TDP:  </b>".$row2["P_TDP"]."W"?>&emsp;
    <?php echo "<b>PRICE: </b> ₹ ".$row2["P_PRICE"]?> &emsp;
</p>

<button type="submit" name="submit" value='<?php echo $row2["P_ID"]?>'>SELECT</button><br><br>

</form>
       
<?php 
       
       $p++; } 
    } 
    else
    {
        echo "0 results";
    }

  $result2->close();
  $conn->close();
}
?>
</div>
</body>
</html>