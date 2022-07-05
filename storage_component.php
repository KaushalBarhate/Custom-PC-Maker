<?php
    $GPU=$_POST["submit"];
	$file=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","a");
	fwrite($file,$GPU);
	fwrite($file,',');
	fclose($file);

	$file1=fopen("C:\\xampp\mysql\data\diypc\OrderData.txt","r");
    $content=fgets($file1);
    $carray=explode(",",$content);
    list($emailid,$processorid,$motherboardid,$ramid,$gpuid)=$carray;

	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "diypc";
	$connect = mysqli_connect($host,$username,$password,$database);
	$query1="select * from storage_component";
	$result=mysqli_query($connect,$query1);
	$query2="show columns from storage_component";
	$columns=mysqli_query($connect,$query2);

	$query3="Select SUM(P_PRICE+M_PRICE+R_PRICE+G_PRICE) FROM processor,motherboard,ram,gpu where PROCESSOR.P_ID=$processorid AND MOTHERBOARD.M_ID=$motherboardid AND RAM.R_ID=$ramid AND GPU.G_ID=$gpuid;";
	$result3=mysqli_query($connect,$query3);
	$row3=$result3 -> fetch_assoc();
?>

<!DOCTYPE html>
<html>
	<h1 style='text-align:center;'>SELECT STORAGE COMPONENT
	<br>
	COST: ₹ <?php echo $row3["SUM(P_PRICE+M_PRICE+R_PRICE+G_PRICE)"]?>
	<br>
	</h1>
<body>
		
<style>

	body{
		/*background-image: url("bg1.jpg") no-repeat center center fixed;
		background-color: rgba(255,255,255,0.7);
        background-blend-mode: lighten;*/
		margin-top: 20px;
        padding: 0px;
        background: url("bg1.jpg")no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        font-family: sans-serif;
        background-color: rgba(255,255,255,0.9);

	}
	
	h1
	{
		color:white;
        background-color:rgba(106,90,205,0.6);
        padding:20px;
        margin-top:0px;
        margin-bottom:1%;
        margin-left:20px;
        margin-right:20px;
        border-style:solid;
        border-color:slateblue;
	}


	.b_design {
		background-color: #000000;
		color: white;
		text-align: center;
		display: block;
		font-size: 18px;
		margin: 10px 150px;
		cursor: pointer;
		font-family: serif;
    }
	
	table, th, td {
		border: 1px solid black;
		margin-left: 10%;
}
  td {
  text-align: center;
}	
</style>
<table>
<colgroup>
<col style="background-color:rgba(255, 255, 255, 0.7);width:33.33%">
<col style="background-color:rgba(255, 255, 255, 0.7);width:33.33%">
<col style="background-color:rgba(255, 255, 255, 0.7);width:33.33%">
<!--<col style="background-color:#dd7aa6;width:25%">#867979,#ffa278, #a27aa6, #d9e5d6  -->
</colgroup>
	<?php
		$i=0;
		$j=1;
		while($rows=mysqli_fetch_assoc($result))
		{
			if($i==0)
			{
	?>
				<tr>
	<?php
			}
	?>
	<form action="Product_Order.php" name="Storage component" method="POST">
	<td>
		<h3> (  <?php echo $rows['S_ID']?>  )    MODEL:  <?php echo $rows['S_MODEL'] ?>     </h3>
		<p>      Brand:        <?php echo $rows['S_BRAND'] ?>   </p>
		<p>      PRICE:        <?php echo $rows['S_PRICE'] ?>   </p>
		<p>      Storage type: <?php echo $rows['S_TYPE']  ?>   </p>
		<p>      Storage size: <?php echo $rows['S_SIZE']  ?>   </p>
		<?php
            		$var = '"storagepics\s'.$j.'.jpg"';
            		echo "<img src= $var width= '300px' height='250px'> ";
            		$j++;
		?>
	  <button type="submit" class="b_design" name="submit" value="<?php echo $rows['S_ID']?>">  SELECT   </button><br>
          </form>
		   </td>
	<?php	
			$i=$i+1;
			if($i==3)
			{
				$i=0;
	?>
				</tr>
	<?php			
			}
		}
	?>
</table>
			
</body>
	
</html>