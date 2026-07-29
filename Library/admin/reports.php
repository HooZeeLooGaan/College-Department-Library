<?php
session_start();
error_reporting(0);
include'includes/config.php';
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
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
function openReport(evt, reportName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(reportName).style.display = "block";
    evt.currentTarget.className += " active";
}
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
                <h4 class="header-line">Reports</h4>
    </div>


        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"> 
                          Reports
                        </div>
                        
<div class="tab">
  <button class="tablinks" onclick="openReport(event, 'Student Transaction')">Today's Issual</button>
  <button class="tablinks" onclick="openReport(event, 'Student Return')">Today's Returns</button>
  <button class="tablinks" onclick="openReport(event, 'Pending Students')">Pending Students</button>
  <button class="tablinks" onclick="openReport(event, 'Fine')">Fines to be collected</button>
  <button class="tablinks" onclick="openReport(event, 'Geek')">Geeks on the net</button>
  <button class="tablinks" onclick="openReport(event, 'Pop Books')">Popular Books</button>
  <button class="tablinks" onclick="openReport(event, 'Pop Studs')">Popular Students</button>
</div>
                    <div id="Student Transaction" class="tabcontent">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>ISBN</th>
                                            <th>Book Name</th>
                                            <th>Issue Time</th>
                                            <th>Due Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$stdat= date("Y-m-d 00:00:00");
$sql = "SELECT students.StudentId,students.FullName,issuedbookdetails.BookId,books.BookName,issuedbookdetails.IssuesDate,issuedbookdetails.ExpectedDate from issuedbookdetails join students on students.StudentId=issuedbookdetails.StudentID join books on books.id=issuedbookdetails.BookId WHERE issuedbookdetails.RetrunStatus=0 order by issuedbookdetails.id";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
if($result->IssuesDate>=$stdat)
{               ?>                               
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookId);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>  
                                            <td class="center"><?php echo htmlentities($result->ExpectedDate);?></td>  
                                            
                                        </tr>
 <?php $cnt=$cnt+1;}}
if($cnt>1)
{
?>
<tr>
<td colspan='6'>Total issual:</td>
<td><b><?php echo $cnt-1; ?></b></td>
</tr>
<?php
}
 else
 {
    ?><tr class="odd gradeX"><td colspan="7"><?php echo "No records found";?></td></tr><?php
 } }?>                                      
                                    </tbody>
                                </table>
                                <?php if($cnt>1){
                                    ?>
                               
                                <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                                
                                <?php
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    <div id="Student Return" class="tabcontent">
                        <div class="panel-body">
                             
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>ISBN</th>
                                            <th>Book Name</th>
                                            <th>Issue Time</th>
                                            <th>Return Time</th>
                                            <th>Fine</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$fin=0;
$stdat= date("Y-m-d 00:00:00");
$sql = "SELECT students.StudentId,students.FullName,issuedbookdetails.BookId,books.BookName,issuedbookdetails.IssuesDate,issuedbookdetails.fine,issuedbookdetails.ReturnDate from issuedbookdetails join students on students.StudentId=issuedbookdetails.StudentID join books on books.id=issuedbookdetails.BookId WHERE issuedbookdetails.RetrunStatus=1 order by issuedbookdetails.id";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
if($result->ReturnDate>=$stdat)
{               ?>                               
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookId);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>
                                            <td class="center"><?php echo htmlentities($result->ReturnDate);?></td>             
                                            <td class="center"><?php echo htmlentities($result->fine);$fin=$fin+$result->fine;?></td>
                                        </tr>
 <?php $cnt=$cnt+1;}}
if($cnt>1)
{
?>
<tr>
<td colspan='3'>Total issual:</td>
<td><b><?php echo $cnt-1; ?></b></td>
<td colspan='3'>Total Fines:</td>
<td><b><?php echo $fin; ?></b></td>
</tr>
<?php
}
 else
 {
    ?><tr class="odd gradeX"><td colspan="7"><?php echo "No records found";?></td></tr><?php
 } }?>                                      
                                    </tbody>
                                </table>
                                <?php if($cnt>1){
                                    ?>
                                <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                               
                                <?php
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                     <div id="Pending Students" class="tabcontent">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>ISBN</th>
                                            <th>Book Name</th>
                                            <th>Issue Time</th>
                                            <th>Due Date</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sql = "SELECT students.StudentId,students.FullName,issuedbookdetails.BookId,books.BookName,issuedbookdetails.IssuesDate,issuedbookdetails.ExpectedDate from issuedbookdetails join students on students.StudentId=issuedbookdetails.StudentID join books on books.id=issuedbookdetails.BookId WHERE issuedbookdetails.RetrunStatus=0 order by issuedbookdetails.id";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   
if($result->ExpectedDate<=$stdat)
{            ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookId);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->IssuesDate);?></td>  
                                            <td class="center"><?php echo htmlentities($result->ExpectedDate);?></td>  
                                            
                                        </tr>
 <?php $cnt=$cnt+1;}}
if($cnt>1)
{
?>
<tr>
<td colspan='5'>Pending ones:</td>
<td><b><?php echo $cnt-1; ?></b></td>
</tr>
<?php
}
 else
 {
    ?><tr class="odd gradeX"><td colspan="7"><?php echo "No records found";?></td></tr><?php
 } }?>                                     
                                    </tbody>
                                </table>
                                <?php if($cnt>1){
                                    ?>
                                <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                               
                                <?php
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    <div id="Fine" class="tabcontent">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Fine</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
<?php 
$sql = "SELECT students.StudentId,students.FullName,SUM(issuedbookdetails.fine) as fin from issuedbookdetails join students on students.StudentId=issuedbookdetails.StudentID WHERE issuedbookdetails.RetrunStatus=1 and issuedbookdetails.finePay=0 group by issuedbookdetails.StudentID order by issuedbookdetails.fine desc";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
$totfin=0;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   
if($result->ExpectedDate<=$stdat)
{            ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->fin);?></td>
                                                                                      
                                        </tr>
 <?php $cnt=$cnt+1; $totfin=$totfin+$result->fin;}}
if($cnt>1)
{
?>
<tr>
<td colspan='3'>Total Fines:</td>
<td><b><?php echo $totfin;?></b></td>
</tr>
<?php
}
 else
 {
    ?><tr class="odd gradeX"><td colspan="4"><?php echo "No records found";?></td></tr><?php
 } }?>                                     
                                    </tbody>
                                </table>
                                <?php if($cnt>1){
                                    ?>
                                <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                                
                                <?php
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    <div id="Geek" class="tabcontent">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Id</th>
                                            <th>Student Name</th>
                                            <th>Count</th>
                                            <th>Last Access</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql = "SELECT students.LastAccess,students.FullName,students.StudentId,students.count from students order by students.count desc limit 25";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
    if($result->count>0)
    {
           ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->count);?></td>
                                            <td class="center"><?php echo htmlentities($result->LastAccess);?></td>
                                            
                                        </tr>
 <?php $cnt=$cnt+1;}}}
 if($cnt==1)
 {
    ?><tr class="odd gradeX"><td colspan="7"><?php echo "No records found";?></td></tr><?php
 } ?>                                     
                                    </tbody>
                                </table>
                                <?php if($cnt>1){
                                    ?>
                                <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                                <?php
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    <div id="Pop Books" class="tabcontent">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>ISBN</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Times Borrowed</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql = "SELECT issuedbookdetails.BookId,books.BookName,issuedbookdetails.IssuesDate,category.CategoryName,authors.AuthorName,count(issuedbookdetails.BookId) as c from issuedbookdetails join books on books.id=issuedbookdetails.BookId join category on category.id=books.CatId join authors on authors.id=books.AuthorId group by issuedbookdetails.BookId order by c desc limit 25";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
           ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookId);?></td>
                                            <td class="center"><?php echo htmlentities($result->CategoryName);?></td>
                                            <td class="center"><?php echo htmlentities($result->AuthorName);?></td>   
                                            <td class="center"><?php echo htmlentities($result->c);?></td>  
                                            
                                        </tr>
<?php $cnt=$cnt+1;}}
 if($cnt==1)
 {
    ?><tr class="odd gradeX"><td colspan="7"><?php echo "No records found";?></td></tr><?php
 } ?>                                      
                                    </tbody>
                                </table>
                                <?php if($cnt>1){
                                    ?>
                                <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                                <?php
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                     <div id="Pop Studs" class="tabcontent">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Id</th>
                                            <th>Student Name</th>
                                            <th>Preferred Titles</th>
                                            <th>Fines paid</th>
                                            <th>Times Borrowed</th>                                            
                                            <th>Books to be returned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$sql = "SELECT issuedbookdetails.StudentID,students.FullName,SUM(issuedbookdetails.fine) as sm,count(issuedbookdetails.BookId) as c from issuedbookdetails join books on books.id=issuedbookdetails.BookId join category on category.id=books.CatId join students on issuedbookdetails.StudentID=students.StudentId where category.id=books.CatId group by issuedbookdetails.StudentID order by c desc limit 25";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
           ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($cnt);?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentID);?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
<?php
$stid=$result->StudentID;
$sql1 = "SELECT category.CategoryName FROM category join books on books.CatId=category.id join issuedbookdetails on issuedbookdetails.BookId=books.id where issuedbookdetails.StudentID=:stid GROUP by category.id ORDER by COUNT(category.id) desc limit 1";
$query1 = $dbh -> prepare($sql1);
$query1-> bindParam(':stid', $stid, PDO::PARAM_STR);
$query1->execute();
$results1=$query1 -> fetchColumn();
$FavTit=$results1; ?>
                                            <td class="center"><?php echo htmlentities($FavTit);?></td> 
                                            <?php if ($result->sm=='')
                                            {
                                                ?>
                                                <td class="center"><?php echo htmlentities(0);?></td> <?php  
                                            }
                                            else
                                            {?>
                                                <td class="center"><?php echo htmlentities($result->sm);?></td> 
                                            <?php 
                                            }
                                            ?> 
                                            <td class="center"><?php echo htmlentities($result->c);?></td>  
<?php
$sql1 = "SELECT count(StudentID) from issuedbookdetails where StudentID=:stid and RetrunStatus='0' limit 1";
$query1 = $dbh -> prepare($sql1);
$query1-> bindParam(':stid', $stid, PDO::PARAM_STR);
$query1->execute();
$results1=$query1 -> fetchColumn();
?>
                                             <td class="center"><?php echo htmlentities($results1);?></td>
<?php $cnt=$cnt+1;}}
 if($cnt==1)
 {
    ?><tr class="odd gradeX"><td colspan="7"><?php echo "No records found";?></td></tr><?php
 } ?>
    
    </tr>                           
                                    </tbody>
                                </table>
                                <?php if($cnt>1){
                                    ?>
                                <button class="btn btn-primary" onClick="forprint();" style="float:right;">Print</button>
                                <?php
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    </div>
  <?php include('includes/footer.php');?>
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
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 14px;
}

.tab button:hover {
    background-color: #ddd;
}

.tab button.active {
    background-color: #ccc;
}

.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
i#g{
    padding-bottom: 5%;
    padding-left: 5%;
}
    </style>
</body>
</html>
<?php } ?>
