<!DOCTYPE html>
<html>
<body>
<h1 style='text-align:center;'>Choose PROCESSOR </h1>
<?php
$Brand=$_POST['brand'];
$N=count($Brand);
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
        for($i=0; $i<$N; $i++)
        {
            $sql="SELECT P_ID,P_MODEL,P_CORE,P_TDP,P_PRICE FROM PROCESSOR WHERE P_BRAND=? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $Brand[$i]);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows>0) 
        {
            $stmt->bind_result($P_ID,$P_MODEL,$P_CORE,$P_TDP,$P_PRICE);
        while ($stmt->fetch()) 
        { 
    ?>

<form action="Motherboard.php" name="Processor" method="POST"> 
            
<h3>     MODEL:        <?php echo $P_MODEL ?>  (  <?php echo $P_ID?>  )   </h3>
<p>      PRICE:        <?php echo $P_PRICE ?>      </p>
<p>      CORE:       <?php echo $P_CORE ?>     </p>
<p>      TDP:  <?php echo $P_TDP ?> </p>
<button type="submit" name="submit" value='<?php echo $P_ID?>'>  SELECT   </button><br>

</form>
<?php
        }
}
else 
    {
        echo "0 results";
    }
    $stmt->close();
    
} }
$conn->close();
?>
</body>
</html>