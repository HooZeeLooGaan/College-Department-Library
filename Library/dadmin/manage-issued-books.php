<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if(strlen($_SESSION['dlogin'])==0)
{   
    header('location:index.php');
}
else{ 
    ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | MANAGE ISSUED BOOKS</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
<?php include 'includes/header.php';?>
    <br>
         <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Issued Books</h4>
                </div>
                <div class="row">
<?php if($_SESSION['error']!="")
{?>
                    <div class="col-md-6">
                        <div class="alert alert-danger" >
                            <strong>Error :</strong> 
    <?php echo htmlentities($_SESSION['error']);?>
    <?php echo htmlentities($_SESSION['error']="");?>
                        </div>
                    </div>
<?php } ?>
<?php if($_SESSION['msg']!="")
{?>
                    <div class="col-md-6">
                        <div class="alert alert-success" >
                            <strong>Success :</strong> 
    <?php echo htmlentities($_SESSION['msg']);?>
    <?php echo htmlentities($_SESSION['msg']="");?>
                        </div>
                    </div>
<?php } ?>
<?php if($_SESSION['delmsg']!="")
{?>
                    <div class="col-md-6">
                        <div class="alert alert-success" >
                            <strong>Success :</strong> 
    <?php echo htmlentities($_SESSION['delmsg']);?>
    <?php echo htmlentities($_SESSION['delmsg']="");?>
                        </div>
                    </div>
<?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Issued Books 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Book Name</th>
                                            <th>ISBN </th>
                                            <th>Issued Date</th>
                                            <th>Due Date</th>
                                            <th>Return Date</th>
                                            <th>Fine (in INR)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT students.FullName,books.BookName,books.id,issuedbookdetails.IssuesDate,issuedbookdetails.ExpectedDate,issuedbookdetails.ReturnDate,issuedbookdetails.fine,issuedbookdetails.RetrunStatus,issuedbookdetails.finePay,issuedbookdetails.id as rid from  issuedbookdetails join students on students.StudentId=issuedbookdetails.StudentId join books on books.id=issuedbookdetails.BookId order by issuedbookdetails.id desc";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
    foreach($results as $result)
    {?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->id);?></td>
                                            <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>
                                            <td class="center"><?php echo htmlentities($result->ExpectedDate);?></td>
                                            <td class="center"><?php if($result->ReturnDate=="")
                                            {
                                                echo htmlentities("Not Yet Returned");
                                            } 
                                            else 
                                            {
                                                echo htmlentities($result->ReturnDate);
                                            }?>
                                            </td>
                                            <td class="center"><?php if($result->fine=="")
                                            {
                                                echo htmlentities("-----");
                                            } 
                                            else
                                            {?>

                                                <span id="user-availability-status" style="font-size:12px;">
                                                <?php if($result->finePay==0){
                                                ?> <div class="red-not-paid"><?php echo htmlentities($result->fine);
                                                } else { ?> <div class="green-paid"><?php

                                                echo htmlentities($result->fine); }
                                           
                                            }?></div></div></span>
                                            </td>
                                            <td class="center">
                                                <a href="update-issue-bookdeails.php?rid=<?php echo htmlentities($result->rid);?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> 
                                            </td>
                                        </tr>
    <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php include'includes/footer.php';?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
    <style type="text/css">
        .red-not-paid
        {
            color: red;
        }
        .green-paid
        {
            color: green;
        }
    </style>
</body>
</html>
<?php } ?>
