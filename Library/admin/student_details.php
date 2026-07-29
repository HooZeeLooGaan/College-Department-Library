<?php
session_start();
error_reporting(0);
include'includes/config.php';
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else{?>
<html>
<head>
    <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | STUDENT PROFILE</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
<?php session_start(); 
	error_reporting(0);
	include'includes/header.php';?>
    <br>
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">STUDENT DETAILS</h4>
                 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>  
                            </div>

        </div>
<?php 
	
		if(isset($_GET['id']))
{
    $var=$_GET['id'];
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT StudentId, FullName FROM students WHERE StudentId='$var' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    ?>
    
    	<?php
    while($row = $result->fetch_assoc()) {
        echo "<h4><b><u>Student-Id</u> &nbsp&nbsp&nbsp&nbsp:</b> " . $row["StudentId"]. "<br>". " <b><u> Name</u> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:  </b>" . $row["FullName"].  "<br></h4>";
    }?>
    <?php
} 

?>
<br>
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
	<div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                          Book Details
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>BookID</th>
                                            <th>Book Name</th>
                                            <th>Issued Date</th>
                                            <th>Return Date</th>
                                            <th>Fine</th>
                                        </tr>
                                    </thead>
                           <?php
                           
$cnt=1;                                   
$sql1 = "SELECT B.BookName, I.BookId,I.IssuesDate,I.ReturnDate,I.fine,I.finePay from Books B, issuedbookdetails I WHERE B.id=I.BookId and I.StudentId='$var' ";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    // output data of each row
    while($row = $result1->fetch_assoc()) {
    	?>
        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($row["BookId"]);?></td>
                                            <td class="center"><?php echo htmlentities($row["BookName"]);?></td>
                                            <td class="center"><?php echo htmlentities($row["IssuesDate"]);?></td>
                                            <td class="center"><?php if($row["ReturnDate"]==NULL)
                                                        
                                                            echo "<p style = color:red>Not yet returned</p>" ;
                                                        
                                                        else
                                                            
                                                                echo htmlentities($row["ReturnDate"]);?>
                                                            </td>
                                            <td class="center"><?php $fin=$row["finePay"]; 
                                            if($fin=="0")
                                            {?>  <div class="red-not-paid"><?php
                                                echo htmlentities($row["fine"]);
                                                 } else { ?> <div class="green-paid"><?php

                                                echo htmlentities($row["fine"]); 
                                           
                                            }?></div></div></td><?php
                                            $cnt=$cnt+1;
    }
} else {
    
}

$conn->close();

	?>
      </table><a href="forgot-password.php?id=<?php echo htmlentities($var);?>"<button class="btn btn-primary">Change password</button></a>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
 
    <?php include'includes/footer.php';}?>
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


