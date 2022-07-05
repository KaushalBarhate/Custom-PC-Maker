<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Frontend.css">
</head>
  <body>
<?php

$email  = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];




if (!empty($email) || !empty($password1) || !empty($password2) )
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "diypc";

if($password1==$password2)
{

// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{

  $SELECT = "SELECT C_EMAIL From CUSTOMER Where C_EMAIL = ?";
  $INSERT = "INSERT Into customer (C_EMAIL ,C_PASSWORD, C_CONFIRMPASSWORD )values(?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking if the email to be registerd exists already or not
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sss",$email,$password1,$password2);
      $stmt->execute();
      ?>
<form action='Login.html'>
       
      <h2>Login Created Successfully !! </h2>
      <button type='submit' name='submit' value='login'>  LOGIN  </button>
     </form>
      <?php
     } else { ?>
     <form action='Register.html'>
       <h1>OOPS !! </h1>
      <h2>This Email ID is Registered already. Cannot Register </h2>
      <button type='submit' name='submit' value='Goback'>  GO BACK  </button>
     </form>
     <?php }
     $stmt->close();
     $conn->close();
    } 
  }
    else
    { ?>
    <form action='Register.html'>
       <h1>OOPS !! </h1>
      <h2>Password and Confirm Password don't match </h2>
      <button type='submit' name='submit' value='Goback'>  GO BACK  </button>
     </form>
   <?php }
} else {
 echo "All field are required";
 die();
}
?>
</body>
</html>