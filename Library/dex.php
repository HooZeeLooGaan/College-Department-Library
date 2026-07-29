<?php
session_start();
error_reporting(0);
include 'includes/config.php' ;
if($_SESSION['login']!=''){
$_SESSION['login']='';
}
if(isset($_POST['login']))
{
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
        echo "<script>alert('Incorrect verification code');</script>" ;
    } 
        else {
$email=$_POST['emailid'];
$password=md5($_POST['password']);
 $sql2 = "SELECT Status FROM students WHERE EmailId=:email and Password=:password limit 1";
$query2 = $dbh -> prepare($sql2);
$query2-> bindParam(':email', $email, PDO::PARAM_STR);
$query2-> bindParam(':password', $password, PDO::PARAM_STR);
$query2->execute();
$results2=$query2->fetchColumn();
$dadstat=$results2;
$sql ="SELECT EmailId,Password,StudentId FROM students WHERE EmailId=:email and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{
    foreach ($results as $result) 
    {
        $_SESSION['stdid']=$result->StudentId;
        if($dadstat==0)
        {
            $_SESSION['login']=$_POST['emailid'];
            echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
        } 
        else 
        {
            echo "<script>alert('Your Account Has been blocked .Please contact admin');</script>";
        }
    }
} 
else{
echo "<script>alert('Invalid Details');</script>";
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | </title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    

</head>
<body>
    
<?php include 'includes/header.php' ;?>

<br>
<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">STUDENT LOGIN</h4>
</div>
</div>
             
          
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<div class="panel-heading">
 LOGIN FORM
</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>Enter Email id</label>
<input class="form-control" type="text" name="emailid" required autocomplete="off" />
</div>
<div class="form-group">
<label>Password</label>
<input class="form-control" type="password" name="password" required autocomplete="off"  />
</div>

 <div class="form-group">
<label>Verification code : </label>
<input type="text" class="form-control1"  name="vercode" maxlength="5" autocomplete="off" required  style="height:25px;" />&nbsp;<img src="captcha.php">
</div> 

 <button type="submit" name="login" class="btn btn-info">LOGIN </button> 
</form>
 </div>
</div>
</div>
</div>       
             
 
    </div>
    
   
 <?php include 'includes/footer.php' ;?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>
