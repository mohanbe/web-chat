<?php
session_start();
if(isset($_SESSION['user']))
header("location:socke.php");
if(isset($_REQUEST['s']))
{
$_SESSION['user']=$_REQUEST['n'];
header("location:socke.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width">
</head>
<body>
<center>
<form method="post" action="">
<fieldset>
<legend>Enter Login Details</legend><br/>
Enter Your Name:<br/>
<input type="text" name="n" pattern="[a-zA-Z ]*" required>
<br/>
<input type="submit" name="s"><input type="reset">
</fieldset>
</form>
</center>
</body>
</html>