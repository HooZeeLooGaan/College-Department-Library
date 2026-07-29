
<?php 
require_once "includes/config.php";
if(!empty($_POST["bookid"])) {
  $bookid=$_POST["bookid"];
 
  $sql ="SELECT BookName,id FROM books WHERE (id=:bookid)";
$query= $dbh -> prepare($sql);
$query-> bindParam(':bookid', $bookid, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
  foreach ($results as $result) {?>
  <b>Book Name : </b><?php  
  echo htmlentities($result->BookName);
  echo "<script>$('#submit').prop('disabled',false);</script>";
}
$cn=0;
$sql1 ="SELECT No_of_copies FROM books WHERE (id=:bookid) limit 1";
$query1= $dbh -> prepare($sql1);
$query1-> bindParam(':bookid', $bookid, PDO::PARAM_STR);
$query1-> execute();
$results1 = $query1 -> fetchColumn();
$cn = $results1;
if($cn==0)
{?>
	<option class="others"> No copies left</option><?php
}
else
{?>
	<div class="form-group">
<?php
$sql2 ="SELECT series FROM issuedbookdetails WHERE BookId=:bookid and RetrunStatus = 0";
$query2= $dbh -> prepare($sql2);
$query2-> bindParam(':bookid', $bookid, PDO::PARAM_STR);
$query2-> execute();
$results2 = $query2 -> fetchAll(PDO::FETCH_OBJ);
$po=$query2->rowCount();
$sers=array();
$lol=array();
$i=0;
$j=0;
#2
?>
<script type="text/javascript">
var x = [];				
</script>
<?php
foreach ($results2 as $key) {
	$sers[$i]=$key->series;
	$i++;
}
$j=$i;
	for($i=1;$i<=$cn;$i++)
	{
		
		#3
		if(!in_array($i,$sers))
		{
			?>
			<script type="text/javascript">
				x.push("<?php echo $i; ?>");
			</script>
			<?php
		#4
		}
	}
	#5
	while($j>0)
	{
		
		if(!in_array($i,$sers))
		{
			?>
			<script type="text/javascript">
				x.push("<?php echo $i; ?>");
			</script>
			<?php
		}
		$i++;
		$j--;
	}
}


}
 else{?>
  
<option class="others"> Book doesn't exist </option>
<?php
 echo "<script>$('#submit').prop('disabled',true);</script>";
}
}



?>
<script type="text/javascript">
		sessionStorage.setItem("ver",x);
</script>