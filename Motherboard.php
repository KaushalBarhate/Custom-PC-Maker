<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="Frontend.css">
</head>
        <?php
        $processor = $_POST["submit"]; 

        $file=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","a");
        fwrite($file,$processor);
        fwrite($file,",");
        fclose($file);

        $file1=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","r");
        $content=fgets($file1);
        $carray=explode(",",$content);
        list($emailid,$processorid)=$carray;
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "diypc";
        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
        
        $sql3="Select P_PRICE FROM processor where PROCESSOR.P_ID=$processorid";
        $result3 = $conn->query($sql3);
        $row3=$result3 -> fetch_assoc();
        

        if (mysqli_connect_error())
    {
        die('Connect Error ('. mysqli_connect_errno() .') ' . mysqli_connect_error());
    }

    else
    {
        $sql = "SELECT M_MODEL,M_BRAND,M_SOCKET,M_FORMFACTOR,M_CHIPSET,M_RAMSLOT,M_MAXRAM,M_PRICE,M_ID 
        From MOTHERBOARD where M_ID in 
        (select M_ID from processor_motherboard_compatibility where P_ID=?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $processor);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows>0) 
        {
            $stmt->bind_result($M_MODEL,$M_BRAND,$M_SOCKET,$M_FORMFACTOR,$M_CHIPSET,$M_RAMSLOT,$M_MAXRAM,$M_PRICE,$M_ID);
        
    ?>
<body>
<h1 style='text-align:center;'>CHOOSE MOTHERBOARD
<br>
COST: ₹<?php echo $row3["P_PRICE"] ?> 
</h1>
    <?php 
    $p=1;
        while ($stmt->fetch()) 
        { 
    ?>

<form action="Ram.php" name="Processor" method="POST"> 
            
<h3>   (  <?php echo $M_ID?>  )  MODEL:        <?php echo $M_MODEL ?>   </h3>
<img src="motherboardpics\m<?php echo $p?>.jpg" alt="Image Not Available">
<p>     
        <?php echo "<b>BRAND: </b>  ".$M_BRAND ?>&emsp;      
        <?php echo "<b>SOCKET:  </b>".$M_SOCKET ?>  &emsp;  
        <?php echo "<b>FORM FACTOR:  </b>".$M_FORMFACTOR ?> &emsp;
        <?php echo "<b>CHIPSET:  </b>".$M_CHIPSET?> &emsp;  
        <?php echo "<b>RAM SLOTS: </b>". $M_RAMSLOT ?> &emsp;<br><br>  
        <?php echo "<b>MAX RAM:   </b> ". $M_MAXRAM ?> &emsp;  
        <?php echo "<b>PRICE:  </b> ₹ ".$M_PRICE ?>&emsp;      
</p>
<button type="submit" name="submit" value='<?php echo $M_ID?>'>  SELECT   </button><br>

</form>

<?php 
        $p++;} 
    } 
    else 
    {
        ?>
        <form action='Processor.php'>
        <h2> OOPS !!</h2> <p>No Compatible Motherboard Available</p>
            <button type='submit' name='submit' value='Exit'>  GO BACK  </button>
    </form>
        <?php
    }
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>