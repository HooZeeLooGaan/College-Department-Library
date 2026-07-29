<?php 
require_once "includes/config.php";
if(!empty($_POST["i"])) {
  $i=$_POST["i"];
  if($i==1)
  {
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
if($studstat==1)
{
	$sql = "UPDATE students set status=0";
}
else
{
	$sql = "UPDATE students set status=1";
}
$query = $dbh -> prepare($sql);
$query->bindParam(':i',$i,PDO::PARAM_STR);
$query->execute();
}

else if($i==2)
  { 
$sql1 = "SELECT status from admin where UserName='dadmin' limit 1";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchColumn();
$dadstat=$results1;
if($dadstat==1)
{
	$sql = "UPDATE admin set status=0 where UserName='dadmin'";
}
else
{
	$sql = "UPDATE admin set status=1 where UserName='dadmin'";
}
$query = $dbh -> prepare($sql);
$query->bindParam(':i',$i,PDO::PARAM_STR);
$query->execute();
}
else
{
	echo "<script>alert('Something went wrong')</script>";
}


}
?>
 