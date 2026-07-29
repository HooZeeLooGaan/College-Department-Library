<?php
session_start();
error_reporting(0);
include'includes/config.php';
if(strlen($_SESSION['alogin'])==0)
{   
    header('location:index.php');
}
else
{ 
    if(isset($_POST['issue']))
    {
        $studentid=strtoupper($_POST['studentid']);
        $bookid=$_POST['bookid'];
        if(isset($_POST['finally']))
        $slno = $_POST['finally'];
        $fine=0;
        $rid = 0 ;

        $sql1="SELECT * from issuedbookdetails WHERE StudentID = '$studentid' AND RetrunStatus = '$rid'";
        $query1=$dbh->prepare($sql1);
        $query1->execute();
        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
        $sql ="SELECT Status FROM students WHERE StudentId=:studentid limit 1";
        $query= $dbh -> prepare($sql);
        $query-> bindParam(':studentid', $studentid, PDO::PARAM_STR);
        $query-> execute();
        $results=$query->fetchColumn();
        $tr=$results;
        if($tr=='0')
        {
        if($query1->rowCount() < 2 )
        {
            $sql2="SELECT No_of_copies from books WHERE id = '$bookid' limit 1";
            $query2=$dbh->prepare($sql2);
            $query2->execute();
            $results2 = $query2->fetchColumn();
            $noc = $results2;
            if(  $noc > 0 )
            {
                $sql="INSERT INTO  issuedbookdetails(StudentID,BookId,finePay,series) VALUES(:studentid,:bookid,:fine,:slno)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
                $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
                $query->bindParam(':fine',$fine,PDO::PARAM_STR);
                $query->bindParam(':slno',$slno,PDO::PARAM_STR);
                $query->execute();
                $lastInsertId = $dbh->lastInsertId();
                if($lastInsertId)
                { 
                    header('location:manage-issued-books.php');
                    $_SESSION['msg']="Book issued successfully";
                    $bookid=$_POST['bookid'];
                    $sql3="UPDATE books set No_of_copies = No_of_copies-1 where id=:bookid";
                    $query3 = $dbh->prepare($sql3);
                    $query3->bindParam(':bookid',$_POST['bookid'],PDO::PARAM_STR);
                    $query3->execute();  
                }
                else 
                {

                    $_SESSION['error']= $slno;
                    header('location:manage-issued-books.php');
                }   
            }
            else
            {
                ?><script>window.alert("No more books left");</script><?php
            }
        }
        else
        {
            ?><script>window.alert("Exceeded his limit");</script><?php
        }
    }
    else
    {
        ?><script>window.alert('Your account has been blocked .Please contact library admin');</script><?php
    }
    }?>

<!DOCTYPE html>
<html>
<head>
    <link rel="Shortcut icon" href="assets/img/Icon.ico" />
    <title>GLOBAL ACADEMY OF TECHNOLOGY | ISSUE BOOK</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
<script>
// function for get student name
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
document.getElementById("chk").checked = false;
var list = document.getElementById("opt");
list.removeChild(list.childNodes[0]);
}

function listCopies()
{
    var x= sessionStorage.getItem("ver");
    sessionStorage.setItem("vers",x);
    var sel = document.createElement('div');
    var selectHtml = "";
    selectHtml = "<select name='finally' style='width:11%;'>";
    var i;
    for (i = 0; i < x.length; i=i+2) 
    { 
        selectHtml += "<option value='"+x[i]+"'>"+x[i]+"</option>";
    }
    selectHtml += "</select>";
    sel.innerHTML = selectHtml;
    document.getElementById("opt").appendChild(sel);
}
</script> 
<style type="text/css">
.others{
    color:red;
}
</style>

</head>
<body>
    <?php include'includes/header.php';?>
    <br>
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Issue a New Book</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Issue a New Book
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Student id<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="studentid" id="studentid" onBlur="getstudent()" autocomplete="off"  required />
                                </div>
                                <div class="form-group">
                                    <span id="get_student_name" style="font-size:16px;"></span> 
                                </div>
                                <div class="form-group">
                                    <label>BookId<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook()"  required="required" />
                                </div>
                                <div class="form-group">
                                    <span id="get_book_name" style="font-size:16px;"></span> 
                                </div>
                                <input name="chk" id="chk" type="checkbox" onClick="listCopies()"/>  Issue a copy of the book <br>
                                <span id="opt" style="font-size:16px; "></span> 
                                <button type="submit" name="issue" id="submit" class="btn btn-info">Issue Book </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php } ?>
