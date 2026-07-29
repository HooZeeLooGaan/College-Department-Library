<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if(strlen($_SESSION['login'])==0)
  { 
header ('location:dex.php');
}
else{?>
<!DOCTYPE html>
<html>
<head>
  <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | STUDENT</title>
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
                <h4 class="header-line">STUDENT DASHBOARD</h4>
                
                            </div>

        </div>
             
             <div class="row">



            
                 <div class="col-md-3 col-sm-3 col-xs-6">
                      <div class="alert alert-info back-widget-set text-center">
                            <i class="fa fa-bars fa-5x"></i>
<?php 
$sid=$_SESSION['stdid'];
$sql1 ="SELECT id from issuedbookdetails where StudentID=:sid";
$query1 = $dbh -> prepare($sql1);
$query1->bindParam(':sid',$sid,PDO::PARAM_STR);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$issuedbooks=$query1->rowCount();
?>

                            <h3><?php echo htmlentities($issuedbooks);?> </h3>
                            Book Borrowed
                        </div>
                    </div>
             
               <div class="col-md-3 col-sm-3 col-xs-6">
                      <div class="alert alert-warning back-widget-set text-center">
                            <i class="fa fa-recycle fa-5x"></i>
<?php 
$rsts=0;
$sql2 ="SELECT id from issuedbookdetails where StudentID=:sid and RetrunStatus=:rsts";
$query2 = $dbh -> prepare($sql2);
$query2->bindParam(':sid',$sid,PDO::PARAM_STR);
$query2->bindParam(':rsts',$rsts,PDO::PARAM_STR);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);
$returnedbooks=$query2->rowCount();
?>

                            <h3><?php echo htmlentities($returnedbooks);?></h3>
                          Books Not Returned Yet
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-3 rscol-xs-6">
                      <div class="alert alert-info back-widget-set text-center">
                            <i class="fa fa-inr fa-5x"></i>

                    <?php 
$sql3 ="SELECT SUM(fine) from issuedbookdetails where StudentID=:sid and finePay=0";
$query3 = $dbh -> prepare($sql3);
$query3->bindParam(':sid',$sid,PDO::PARAM_STR);
$query3->execute();
$results3=$query3->fetchColumn();
$totfine=$results3;
if($totfine=="")
{
  $totfine=0;
}
?>
 <h3><?php echo htmlentities($totfine);?> </h3>
                           Total Fine Paid
                        </div>
                    </div>

        
 <div class="col-md-3 col-sm-3 col-xs-6">
                      <div class="alert alert-success back-widget-set text-center">
                            <i class="fa fa-clock-o fa-5x"></i>
<?php 
$cnt=0;
$sql0 ="SELECT count from students where StudentID=:sid";
$query0 = $dbh -> prepare($sql0);
$query0->bindParam(':sid',$sid,PDO::PARAM_STR);
$query0->execute();
$results0=$query0->fetchColumn();
$cnt=$results0;
?>


                            <h3><?php echo htmlentities($cnt);?></h3>
                      Times accessed
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
<?php } ?>
