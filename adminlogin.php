<!DOCTYPE html>
<head>
<title>Login Form Design</title>
<link rel="stylesheet" type="text/css" href="style.css">
    </head>
    

<body>

    <div class="box">

    <img src="user.png" class="user">

        <h1>Login Here</h1>

        <form name="myform"  action="adminlogincheck.php" method="POST" >

            <p>Email</p>
            <input type="email" name="email" placeholder="Enter Email ID " required="">

            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password" required="">
            <input type="hidden" name="oid1" value="0" />

            <input type="submit" name="" value="Login" >
            <br><br>
            <a href="Login.html">Customer Login</a>
        </form>
        
    </div>
