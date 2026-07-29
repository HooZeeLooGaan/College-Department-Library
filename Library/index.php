<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['login']!='')
{
    $_SESSION['login']='';
}
if(isset($_POST['login']))
{
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  
    {
        echo "<script>alert('Incorrect verification code');</script>" ;
    } 
    else 
    {
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
                    echo "<script>alert('Your Account Has been blocked. Please contact library admin');</script>";
                }
            }
            $sql1 ="UPDATE students set count = count+1 WHERE EmailId=:email";
            $query1= $dbh -> prepare($sql1);
            $query1-> bindParam(':email', $email, PDO::PARAM_STR);
            $query1-> execute();
            $sql1 ="UPDATE students set LastAccess=now() WHERE EmailId=:email";
            $query1= $dbh -> prepare($sql1);
            $query1-> bindParam(':email', $email, PDO::PARAM_STR);
            $query1-> execute();
        } 
        else
        {
            echo "<script>alert('Invalid Details');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title> GLOBAL ACADEMY OF TECHNOLOGY | STUDENT LOGIN </title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body onresize="responsives()">
<?php include('includes/title.php');?>

<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">STUDENT LOGIN</h4>
</div>
</div>
 
<span id="sp2" style="float:left; display:inline; width:60%;">
    <div class="transbox">
        <p> 
            ----------------------------------------------------<br>
            Global Academy Of Technology<br>
            Department Of CSE<br>
            <br>
            VISION<br>
            Become a premier institution imparting quality education in engineering and management to meet the changing needs of society.<br>
            <br>MISSION<br>

            1. Create environment conducive for continuous learning through quality teaching and learning processes supported by modern infrastructure.<br>

            2. Promote Research and Innovation through collaboration with industries.<br>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Inculcate ethical values and environmental consciousness through holistic education programs.<br>
            ----------------------------------------------------<br>

            </p> </div></span>
    <span id="sp2" style=" display:inline; float:left;">  
<div class="box">
<div class="row" >
<div class="col-md-12 col-sm-6 col-xs-12 col-md-offset-2"  >
<div class="panel panel-info">
<div class="panel-heading">

 LOGIN FORM
</div>
<div class="panel-body">
<form role="form" method="post">

<div class="form-group">
<label>Enter Login ID</label>
<input class="form-control" type="text" name="emailid" autocomplete="off" required />
</div>
<div class="form-group">
<label>Password</label>
<input class="form-control" type="password" name="password" autocomplete="off" required />
</div>

 <div class="form-group">
<label>Verification code : </label>
<input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
</div>  

 <button type="submit" name="login" class="btn btn-info">LOGIN </button>&nbsp|
 <a href="user-forgot-password.php">Forgot Password?</a>
</form>
 </div>
</div>
</span>
</div>
</div>  
</div>
</div>

<style type="text/css">
body
{
  background-color: #00e6e6;
  background-image: url(assets/img/gat.jpg); 
  opacity: 1.0;
  background-repeat: no-repeat;
  background-size: 100%;
  background-attachment: fixed;
  background-blend-mode: darken; 

}
.transbox
{
    background: white;
    opacity : 0.5;
    width : 80%;
    float: left;
    margin-left: 0;
    margin-right: 50%;
    padding: 100;
}

.transbox p
{
     margin: 5%;
    font-weight: bold;
    color: #000000;
    text-align: center;
}

</style>
 <?php include('includes/footer.php');?> 
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>








