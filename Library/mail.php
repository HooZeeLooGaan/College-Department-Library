<?php
session_start();
error_reporting(0);
include'includes/config.php';
$email=$_REQUEST['email'];
$mobile=$_REQUEST['mobile'];
$sql ="SELECT FullName FROM students WHERE EmailId=:email and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchColumn();
$na=$results;
if($query -> rowCount() == 0){
    $_SESSION['error']="Something went wrong. Please check the details entered";
    header('location:user-forgot-password.php');
    die();
}

$pass=rand(100000,999999);
$newpassword=md5($pass);
$con="UPDATE students set Password=:newpassword where EmailId=:email and MobileNumber=:mobile";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
require 'PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer();
  
  //Enable SMTP debugging.
  $mail->SMTPDebug = 1;
  //Set PHPMailer to use SMTP.
  $mail->isSMTP();
  //Set SMTP host name
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
  //Set this to true if SMTP host requires authentication to send email
  $mail->SMTPAuth = TRUE;
  //Provide username and password
  $mail->Username = "dhanesh1ga15cs049@gmail.com";
  $mail->Password = "Gatian*123";
  //If SMTP requires TLS encryption then set it
  $mail->SMTPSecure = "false";
  $mail->Port = 587;
  //Set TCP port to connect to
  
  $mail->From = "dhanesh1ga15cs049@gmail.com";
  $mail->FromName = "Library Admin";
  
  $mail->addAddress($email);
  
  $mail->isHTML(true);
 
  $mail->Subject = "Request for new password";
  $mail->Body = "Hey $na,<br>This is your new password :<b>$pass</b><br><i>You can feel free to change password to whatever you want by accessing your account with this temporary password";
  $mail->AltBody = "This is the plain text version of the email content";
  if(!$mail->send())
  {
   echo "Mailer Error: " . $mail->ErrorInfo;
  }
  else
  {
   $_SESSION['msg']="Password changed successfully";
    header('location:user-forgot-password.php');
  }