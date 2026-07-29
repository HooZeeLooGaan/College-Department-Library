<?php
session_start();
include'includes/config.php';
error_reporting(0);
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
if(isset($_POST['change']))
  {
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$username=$_SESSION['alogin'];
  $sql ="SELECT Password FROM admin where UserName=:username and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update admin set Password=:newpassword where UserName=:username";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':username', $username, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password succesfully changed";
}
else {
$error="Your current password is wrong";  
}
}


?>
<!DOCTYPE html>
<html>
<head>
    <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | CHANGE ADMIN PASSWORD</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
  <style>
    .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.panell-body{
    padding: 1vh 3vw;
    width: 30vw;
    background-color: #ffffff;
    width:25vw;
}
.panell-heading{
    padding: 10px 15px;
  border-bottom: 1px solid transparent;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
  width:25vw;
  background-color: #f5f5f5;

}
img {
    border-radius: 50%;
}
h3{
    padding-bottom: 5%;
    font-weight: bold;
    
}
.nam{
    border-bottom: 1px solid black;
}
p{
    display: inline;
}
.switch {
    position: relative;
    display: block;
    vertical-align: top;
    width: 100px;
    height: 30px;
    padding: 3px;
    margin: 0 10px 10px 0;
    background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px);
    background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px);
    border-radius: 18px;
    box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
    cursor: pointer;
    box-sizing:content-box;
}
.switch-input {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    box-sizing:content-box;
}
.switch-label {
    position: relative;
    display: block;
    height: inherit;
    font-size: 10px;
    text-transform: uppercase;
    background: #eceeef;
    border-radius: inherit;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
    box-sizing:content-box;
}
.switch-label:before, .switch-label:after {
    position: absolute;
    top: 50%;
    margin-top: -.5em;
    line-height: 1;
    -webkit-transition: inherit;
    -moz-transition: inherit;
    -o-transition: inherit;
    transition: inherit;
    box-sizing:content-box;
}
.switch-label:before {
    content: attr(data-off);
    right: 11px;
    color: #aaaaaa;
    text-shadow: 0 1px rgba(255, 255, 255, 0.5);
}
.switch-label:after {
    content: attr(data-on);
    left: 11px;
    color: #FFFFFF;
    text-shadow: 0 1px rgba(0, 0, 0, 0.2);
    opacity: 0;
}
.switch-input:checked ~ .switch-label {
    background: #3bb9ff;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
}
.switch-input:checked ~ .switch-label:before {
    opacity: 0;
}
.switch-input:checked ~ .switch-label:after {
    opacity: 1;
}
.switch-handle {
    position: absolute;
    top: 4px;
    left: 4px;
    width: 28px;
    height: 28px;
    background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0);
    background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0);
    border-radius: 100%;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
}
.switch-handle:before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -6px 0 0 -6px;
    width: 12px;
    height: 12px;
    background: linear-gradient(to bottom, #eeeeee, #FFFFFF);
    background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF);
    border-radius: 6px;
    box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
}
.switch-input:checked ~ .switch-handle {
    left: 74px;
    box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
}
 
/* Transition
========================== */
.switch-label, .switch-handle {
    transition: All 0.3s ease;
    -webkit-transition: All 0.3s ease;
    -moz-transition: All 0.3s ease;
    -o-transition: All 0.3s ease;
}

    </style>
</head>
<script type="text/javascript">
$(document).ready(function(){
    $("switch-input").keyup(function(){
        var i = $("switch-input").val();
        $.post("update-security.php",{i});
    });
});
function saccess(i) {
$("#loaderIcon").show();
jQuery.ajax({
url: "update-security.php",
data:'i=' + i,
type: "POST",
success:function(data){
$("#loaderIcon").hide();
if(i==1)
{
    alert("Student Security Settings updated");
}
else
{
    alert("Admin Security Settings updated");
}
},
error:function (){}
});
}
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
 $(".switch-input").click(function () {  
            var rdata = $(this).attr("data-id"); // reading the id of the checkbox through data-id   
            console.log(rdata);  
            //alert(rdata);  
            $.ajax({  
                type: "Post",  
                contentType: "application/json; charset=utf-8",  
                url: "GridUpdate.aspx/UpdateIsData",  
                data: '{eid: ' + rdata + '}',  
                dataType: "json",  
                success: function (response) {  
                    if (response != 0) {  
                        alert("Data Update Successfully!!!!");  
                        location.reload();  
                    }  
                },  
                error: function (response) {  
                    if (response != 1) {  
                        alert("Error!!!!");  
                    }  
                }  
            });  
        });  
</script>

<body>
<?php include 'includes/header.php' ;?>
<br>

<div class="container">
<div class="row pad-botm">
<div class="col-md-12">
<h4 class="header-line">Admin Security</h4>
</div>
</div>
 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
<span id="sp2" style="float:left; display:inline; width:60%;">
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1" >
<div class="panel panel-info">
<div class="panel-heading">
Change Admin Password
</div>
<div class="panel-body">
<form role="form" method="post" onSubmit="return valid();" name="chngpwd">

<div class="form-group">
<label>Current Password</label>
<input class="form-control" type="password" name="password" autocomplete="off" required  />
</div>

<div class="form-group">
<label>Enter Password</label>
<input class="form-control" type="password" name="newpassword" autocomplete="off" required  />
</div>

<div class="form-group">
<label>Confirm Password </label>
<input class="form-control"  type="password" name="confirmpassword" autocomplete="off" required  />
</div>

 <button type="submit" name="change" class="btn btn-info">Change</button> 
</form>
 </div>
</div>
</div>
</div>
</span>
<?php $sql = "SELECT FullName from admin where UserName='admin' limit 1";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchColumn();
$nams=$results?>
<span id="sp2" style=" display:inline; float:left;">  
        <div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1" >
<div class="panell panell-info">
<div class="panell-heading">
Admin
</div>

<div class="panell-body"><center>
<img src="assets/img/gat.jpg" alt="photo.jpg" alt="admin" width="100" height="100"/>
<h3>Admin</h3>
<label class="nam">Admin Name  :  <?php echo htmlentities($nams);?></label>
</center>
<?php $sql = "SELECT status from admin where UserName='dadmin' limit 1";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchColumn();
$dadstat=$results;
$sql1 = "SELECT status from students";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$studstat=1;
foreach ($results1 as $result1) 
{
    if($result1->status==0)
    {
        $studstat=0;
    }
}
?>
<p>Disable Students</p> 
<label class="switch">
    <?php if($studstat=="0")
    {?>
    <input class="switch-input" name="stud-block" type="checkbox" onClick="saccess(1)"/>
    <span class="switch-label" data-on="On" data-off="Off"></span> 
    <span class="switch-handle"></span> <?php }
    else{?>
    <input class="switch-input" name="stud-block" type="checkbox" onClick="saccess(1)" checked/>
    <span class="switch-label" data-on="On" data-off="Off"></span> 
    <span class="switch-handle">
    <?php }?>
</label>
<p>Disable Deputy Admin</p> 
<label class="switch">
    <?php if($dadstat=="0")
    {?>
    <input class="switch-input" name="admin-block" type="checkbox" onClick="saccess(2)"/>
    <span class="switch-label" data-on="On" data-off="Off"></span> 
    <span class="switch-handle"></span> <?php }
    else{?>
    <input class="switch-input" name="admin-block" type="checkbox" onClick="saccess(2)" checked/>
    <span class="switch-label" data-on="On" data-off="Off"></span> 
    <span class="switch-handle">  <?php }?> 
</label>
</div>
</div>
</div>
</div>
    </span>  
    </div>
    
   
 <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
