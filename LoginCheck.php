<?php
$EMAIL = $_POST['email'];
$PASSWORD1 = $_POST["password"];
if (!empty($EMAIL)  || !empty($PASSWORD1))
{

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
        $SELECT = "SELECT C_EMAIL,C_PASSWORD From customer Where C_EMAIL = ? And C_PASSWORD = ? ";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param('ss', $EMAIL,$PASSWORD1);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($e,$p);
        $rnum = $stmt->num_rows;
        if ($rnum==1) 
        {
            $FILE=fopen("indexsample.html","r");
            echo fread($FILE,filesize("indexsample.html"));
            $file=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","w");
            fwrite($file,$EMAIL);
            fwrite($file,",");
            fclose($file);
        }
        else
        {
            $FILE=fopen("InvalidLogin.html","r");
            echo fread($FILE,filesize("InvalidLogin.html"));
            fclose($FILE);
        }
        $stmt->close();
        $conn->close();
    }
} 
else 
{
    echo "All field are required";
    die();
}
?>
