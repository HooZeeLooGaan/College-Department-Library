<?php
session_start();
error_reporting(0);
include'includes/config.php';
if(strlen($_SESSION['dlogin'])==0)
{   
    header('location:index.php');
}
else{ 
    if(isset($_POST['return']))
    {
        $rid=intval($_GET['rid']); 
        $fine=$_POST['fine'];
        echo $rstatus;
        $sql3="SELECT RetrunStatus,finePay from issuedbookdetails WHERE id=:rid";
        $query3 = $dbh -> prepare($sql3);
        $query3->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query3->execute();
        $results3=$query3->fetchAll(PDO::FETCH_OBJ);
        if($query3->rowCount() > 0)
        {
            foreach($results3 as $result)
            {
                $rstatus=$result->RetrunStatus;
                $pstatus=$result->finePay;
            }        
        }       
        if($rstatus=="0")
        {
            $rstatus=1;
            $sql = "UPDATE issuedbookdetails set RetrunStatus=:rstatus where id=:rid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':rid',$rid,PDO::PARAM_STR);
            $query->bindParam(':rstatus',$rstatus,PDO::PARAM_STR);
            $query->execute();
            $sql2 ="UPDATE books set No_of_copies = No_of_copies+1 where id in (SELECT BookId from issuedbookdetails where id=:rid) ";
            $query2 = $dbh->prepare($sql2);
            $query2->bindParam(':rid',$rid,PDO::PARAM_STR);
            $query2->execute();  
            $sql1="SELECT fine from issuedbookdetails WHERE id=:rid";
            $query1 = $dbh -> prepare($sql1);
            $query1->bindParam(':rid',$rid,PDO::PARAM_STR);
            $query1->execute();
            $results1=$query1->fetchAll(PDO::FETCH_OBJ);
            if($query1->rowCount() > 0)
            {
                foreach($results1 as $result)
                {
                    $fin=$result->fine;
                }        
            }      
            if($fin=="0")
            {
                $payd=1;
                $sql4 = "UPDATE issuedbookdetails set finePay=:payd where id=:rid";
                $query4 = $dbh->prepare($sql4);
                $query4->bindParam(':rid',$rid,PDO::PARAM_STR);
                $query4->bindParam(':payd',$payd,PDO::PARAM_INT);
                $query4->execute();  
                $_SESSION['msg']="Book Returned successfully";
                header('location:manage-issued-books.php');
            }
            else
            {
                $_SESSION['msg']="Book Returned successfully";
                header("location:update-issue-bookdeails.php?rid=$rid");
            }
        }
        else
        { 
            if($pstatus=="0")
            {
                $payd=1;
                $sql4 = "UPDATE issuedbookdetails set finePay=:payd where id=:rid";
                $query4 = $dbh->prepare($sql4);
                $query4->bindParam(':rid',$rid,PDO::PARAM_STR);
                $query4->bindParam(':payd',$payd,PDO::PARAM_STR);
                $query4->execute();
                $_SESSION['msg']="Due fine paid";
                header('location:manage-issued-books.php');
            }
        }
    }
    if(isset($_POST['cont']))
    {
        $_SESSION['msg']="Added to due list";
        header('location:manage-issued-books.php');
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | UPDATE ISSUE BOOK DERAILS</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script>
// function for get student name
var f = "<?php echo $fin?>";
function getstudent() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_student.php",
data:'studentid='+$("#studentid").val(),
type: "POST",
success:function(data){
$("#get_student_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

//function for book details
function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

function finefxn()
{
    alert("Pay Fine:"f);
}

function finepaid()
{
    alert("Fine Paid:"f);
}

</script> 
<style type="text/css">
  .others{
    color:red;
}
</style>
</head>
<body>
<?php include 'includes/header.php';?>
<br>
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Issued Book Details</h4>
                </div>
            </div>
            <div class="row">

                <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Issued Book Details
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">

<?php 
   $rid=intval($_GET['rid']);
  
$sql = "SELECT students.FullName,books.BookName,books.id,issuedbookdetails.IssuesDate,issuedbookdetails.ReturnDate,issuedbookdetails.id as rid,issuedbookdetails.fine,issuedbookdetails.RetrunStatus,issuedbookdetails.finePay from  issuedbookdetails join students on students.StudentId=issuedbookdetails.StudentId join books on books.id=issuedbookdetails.BookId where issuedbookdetails.id=:rid";
$query = $dbh -> prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
    foreach($results as $result)
    {?> 
                                <div class="form-group">
                                    <label>Student Name :</label>
        <?php echo htmlentities($result->FullName);?>
                                </div>
                                <div class="form-group">
                                    <label>Book Name :</label>
        <?php echo htmlentities($result->BookName);?>
                                </div>
                                <div class="form-group">
                                    <label>ISBN :</label>
        <?php echo htmlentities($result->id);?>
                                </div>
                                <div class="form-group">
                                    <label>Book Issued Date :</label>
        <?php echo htmlentities($result->IssuesDate);?>
                                </div>
                                <div class="form-group">
                                    <label>Book Returned Date :</label>
        <?php if($result->ReturnDate=="")
        {
            echo htmlentities("Not Return Yet");
        }
        else
        {
            echo htmlentities($result->ReturnDate);
        }?>
                                </div>
                                <div class="form-group">

        <?php 
        if($result->fine=="")
        {

        }
        else
        {?>
            <label>Fine (in INR) :</label>
        <?php
            echo htmlentities($result->fine);
        }?>
                                </div>

        <?php if($result->RetrunStatus==0)
        {?>
                                <button type="submit" onclick="finefxn()" name="return" id="submit" class="btn btn-info">Return Book </button>
        <?php } else if($result->finePay==0) {?>
                                     <button type="submit" onclick="finepaid()" name="return" id="submit" class="btn btn-info">Pay fine </button>
                                      &nbsp &nbsp
                                     <button type="submit" onclick="cont()" name="cont" id="submit" class="btn btn-info">Continue </button>
 <?php  }?>
                                </div>

<?php }}} ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include 'includes/footer.php';?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>

