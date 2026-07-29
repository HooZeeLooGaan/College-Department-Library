<?php
session_start();
error_reporting(0);
include'includes/config.php';
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

// code for block student    
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=1;
$sql = "update students set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:reg-students.php');
}



//code for active students
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=0;
$sql = "update students set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:reg-students.php');
}
?>
<!DOCTYPE html>
<html>
<head>
     <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | REGISTERED STUDENTS</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />

<script type="text/javascript">
function forprint()
{
    if(!window.print)
    {
        return
    }
    window.print()
}
</script>
</head>
<body>
<?php include'includes/header.php';?>
    <br>
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Manage Students</h4>
    </div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Reg Students
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Email id </th>
                                            <th>Mobile Number</th>
                                            <th>Fine status</th>
                                            <th>View</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sql = "SELECT * from students order by status, id";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->EmailId);?></td>
                                            <td class="center"><?php echo htmlentities($result->MobileNumber);?></td>
                                             <td class="center"><?php 
                                                $flag=0;
                                                $flag1=0;
                                                $totfin=0;
                                                $duetotfin=0;
                                                $rid=$result->StudentId;
                                                $sql1 = "SELECT fine,RetrunStatus,finePay from issuedbookdetails WHERE StudentID=:rid";
                                                $query1 = $dbh -> prepare($sql1);
                                                $query1-> bindParam(':rid',$rid, PDO::PARAM_STR);
                                                $query1->execute();
                                                $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                if($query1->rowCount() > 0)
                                                {
                                                    foreach($results1 as $result1)
                                                    {   
                                                        $fin=$result1->fine;
                                                        $fs=$result1->finePay;
                                                        $rs=$result1->RetrunStatus;
                                                        if($rs=="0")
                                                        {
                                                            $flag1=1;
                                                            ?><div class="red-not-paid"><?php
                                                            echo htmlentities("Not yet returned");
                                                            break;
                                                        }
                                                        if($fs=="1")
                                                        {
                                                            $totfin=$totfin+$fin;
                                                        }
                                                        else if($fs=="0")
                                                        {
                                                            $flag=1;
                                                            $duetotfin=$duetotfin+$fin;
                                                        }
                                                    }
                                                    if($flag1=="0")
                                                    {
                                                        if($flag=="0")
                                                        {
                                                            ?><div class="green-paid"><?php
                                                            echo htmlentities($totfin);
                                                        }
                                                        else
                                                        {
                                                            ?><div class="red-not-paid"><?php
                                                            echo htmlentities($duetotfin);
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    echo htmlentities("-----");
                                                }?></div>
                                                </td>

                                             <td class="center"><a href="student_details.php?id=<?php echo htmlentities($result->StudentId);?>"<button class="btn btn-primary">View</button></a></td>
                                            <td class="center"><?php if($result->Status==0)
                                            {
                                                echo htmlentities("Active"); 
                                            }
                                            else { 


                                            echo htmlentities("Blocked");
}
                                            ?></td>
                                            <td class="center">
<?php if($result->Status==0)
 {?>
<a href="reg-students.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to block this student?');"" >  <button class="btn btn-danger"> Deactivate</button>
<?php } else {?>

                                            <a href="reg-students.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to active this student?');""><button class="btn btn-primary"> Activate</button> 
                                            <?php } ?>
                                          
                                            </td>
                                        </tr>
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                        </div>
                    </div>
                </div>
            </div>
            
    </div>
  <?php include('includes/footer.php');?>
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
